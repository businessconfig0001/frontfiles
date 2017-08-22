<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;
use FrontFiles\Utility\DriversHelper;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Pbmedia\LaravelFFMpeg\FFMpeg;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\{ CreateContainerOptions, PublicAccessType };
use WindowsAzure\Common\ServicesBuilder;

class Video implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @throws FileNotFoundException
     */
    public function process(File $file)
    {
        //fetch from dropbox
        $filesystem = DriversHelper::userDropbox($file->owner->dropbox_token);

        if(!$filesystem->has($file->name))
            throw new FileNotFoundException('We couln\'t find this file!');

        $container = 'user-id-' . auth()->user()->id;
        $config = config('filesystems.default');

        if($config === 'azure')
            $this->createContainerIfNeeded($container);

        $new_name = 'processed_' . $file->name;

        //add encoding
        //add watermark
        FFMpeg::fromFilesystem($filesystem)
            ->open($file->name)
            ->addFilter(['-i', asset('images/logo2x.png'),'-filter_complex','overlay=10:10'])
            ->addFilter(['-strict', 1])
            ->export()
            ->toDisk(config('filesystems.default'))
            ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
            ->save($new_name);

        //save blob storage url in "azure_url" field, for previews
        //change value "processed" to true
        $file->update([
            'azure_url' => config('filesystems.disks.' . $config . '.url') . $container . '/' . $new_name,
            'processed' => true,
        ]);

        //warn user that video has been processed?
    }

    /*
     * Checks if the current user container exists in the azure blob storage
     * If it does not exist, he creates it.
     *
     * @param string $container
     */
    protected function createContainerIfNeeded(string $container)
    {
        //BLOBS_ONLY means that its public
        $containerOptions = new CreateContainerOptions();
        $containerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY);

        try{
            ServicesBuilder::getInstance()
                ->createBlobService(config('filesystems.disks.azure.endpoint'))
                ->createContainer($container, $containerOptions);
        }catch(ServiceException $e){
            //If there's an exception, it means that the container (folder) already exists
        }
    }
}