<?php

namespace FrontFiles\Jobs;

use FrontFiles\File;
use Illuminate\Bus\Queueable;
use FrontFiles\Utility\DriversHelper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

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
     * The file's temporary name.
     *
     * @var string
     */
    protected $tmp_name;

    /**
     * The file's new name.
     *
     * @var string
     */
    protected $new_name;

    /**
     * Create a new job instance.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->tmp_name = 'tmp_' . $file->name;
        $this->new_name = 'processed_' . $file->name;
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

        //Process the file
        $this->processFile();

        //Save to the blob storage
        if(config('filesystems.default') === 'azure')
            $this->sendToAzureBlobStorage();

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
                (new FileTypes\Videos)->process($this->file, $this->tmp_name, $this->new_name);
                break;
            case 'image':
                (new FileTypes\Images)->process($this->file, $this->tmp_name, $this->new_name);
                break;
            case 'audio':
                (new FileTypes\Audios)->process($this->file, $this->tmp_name, $this->new_name);
                break;
            case 'document':
                (new FileTypes\Documents)->process($this->file, $this->tmp_name, $this->new_name);
                break;
        }
    }

    /**
     * Saves the processed file on the blob storage.
     */
    protected function sendToAzureBlobStorage()
    {
        $processed_video = Storage::disk('local')->get($this->new_name);

        Storage::disk('azure')->put('user-files/'.$this->new_name, $processed_video);
    }

    /**
     * Updates the file with the URL for the preview and the processed option as true.
     */
    protected function updateFile()
    {
        $this->file->update([
            'azure_url'         => 'https://ffcontents.blob.core.windows.net/user-files/' . $this->new_name,
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
        Storage::disk('local')->delete($this->new_name);
        Storage::disk('local')->delete($this->tmp_name);
    }
}
