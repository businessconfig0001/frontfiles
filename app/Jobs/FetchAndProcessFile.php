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

        //Process the file
        $this->processFile();
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
                (new FileTypes\Video)->process($this->file);
                break;
            case 'image':
                (new FileTypes\Image)->process($this->file);
                break;
            case 'audio':
                (new FileTypes\Audio)->process($this->file);
                break;
            case 'document':
                (new FileTypes\Document)->process($this->file);
                break;
        }
    }
}
