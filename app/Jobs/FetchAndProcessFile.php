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
     * The user container on azure blob storage.
     *
     * @var string
     */
    protected $container;

    /**
     * The file's new name.
     *
     * @var string
     */
    protected $new_name;

    /**
     * The file's path on the blob storage.
     *
     * @var string
     */
    protected $path;

    /**
     * Create a new job instance.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->container = 'user-id-' . $file->owner->id;
        $this->new_name = 'processed_' . $file->name;
        $this->path = $this->container . '/' . $this->new_name;
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

        //Creates a container in the blob storage, for the file owner
        if(config('filesystems.default') === 'azure')
            $this->createContainerIfNeeded();

        //Process the file
        $this->processFile();

        //Updates the file
        $this->updateFile();

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
     */
    protected function createContainerIfNeeded()
    {
        //BLOBS_ONLY means that its public
        $containerOptions = new CreateContainerOptions();
        $containerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY);

        try{
            ServicesBuilder::getInstance()
                ->createBlobService(config('filesystems.disks.azure.endpoint'))
                ->createContainer($this->container, $containerOptions);
        }catch(ServiceException $e){
            //If there's an exception, it means that the container (folder) already exists
        }
    }

    /**
     * Calls the correct class to process the file.
     */
    protected function processFile()
    {
        //Generate class
        //$class = 'FileTypes\\' . ucfirst($this->file->type);
        //Dinamycally call the correct class to process the file
        //(new $class)->process($this->file, $this->new_name);

        //Process the file, according to its type
        switch($this->file->type){
            case 'video':
                (new FileTypes\Video)->process($this->file, $this->path);
                break;
            case 'image':
                (new FileTypes\Image)->process($this->file, $this->path);
                break;
            case 'audio':
                (new FileTypes\Audio)->process($this->file, $this->path);
                break;
            case 'document':
                (new FileTypes\Document)->process($this->file, $this->path);
                break;
        }
    }

    /**
     * Updates the file with the URL for the preview and the processed option as true.
     */
    protected function updateFile()
    {
        $this->file->update([
            'azure_url'         => config('filesystems.disks.' . config('filesystems.default') . '.url') . $this->path,
            'processed_name'    => $this->new_name,
            'processed'         => true,
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
