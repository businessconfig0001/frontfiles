<?php

namespace FrontFiles\Jobs;

use FrontFiles\File;
use Illuminate\Bus\Queueable;
use FrontFiles\Utility\DriversHelper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use WindowsAzure\Common\ServicesBuilder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use MicrosoftAzure\Storage\Common\ServiceException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use MicrosoftAzure\Storage\Blob\Models\{ CreateContainerOptions, PublicAccessType };

class FetchAndProcessFile implements ShouldQueue
{
    /**
     * Traits.
     */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * The file to be processed.
     *
     * @var File
     */
    protected $file;

    /**
     * Create a new job instance.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Fetches file
        $this->fetchFile();

        //Preparing the outcome
        $container = 'user-id-' . $this->file->owner->id;
        $new_name = 'processed_' . $this->file->name;

        //Creates a container in the blob storage, for the file owner
        if(config('filesystems.default') === 'azure')
            $this->createContainerIfNeeded($container);

        //Process the file, according to its type
        switch($this->file->type){
            case 'video':
                (new FileTypes\Video)->process($this->file, $new_name);
                break;
            case 'image':
                (new FileTypes\Image)->process($this->file, $new_name);
                break;
            case 'audio':
                (new FileTypes\Audio)->process($this->file, $new_name);
                break;
            case 'document':
                (new FileTypes\Audio)->process($this->file, $new_name);
                break;
        }

        //Updates the file
        $this->updateFile($container, $new_name);

        //Delete file locally
        $this->deleteFileLocally();
    }

    /**
     * The job failed to process.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        // Send user notification of failure, etc...
    }

    /**
     * Fetches the file from Dropbox and saves it locally.
     *
     * @throws FileNotFoundException
     */
    protected function fetchFile()
    {
        $filesystem = DriversHelper::userDropbox($this->file->owner->dropbox_token);

        if(!$filesystem->has($this->file->name))
            throw new FileNotFoundException('We couln\'t find this file!');
        else
            Storage::disk('local')->put($this->file->name, $filesystem->read($this->file->name));
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

    /**
     * Updates the file with the URL for the preview and the processed option as true.
     *
     * @param string $container
     * @param string $new_name
     */
    protected function updateFile(string $container, string $new_name)
    {
        $this->file->update([
            'azure_url' => config('filesystems.disks.' . config('filesystems.default') . '.url') . $container . '/' . $new_name,
            'processed' => true,
        ]);
    }

    /**
     * Deletes the file locally.
     */
    protected function deleteFileLocally()
    {
        Storage::disk('local')->delete($this->file->name);
    }
}
