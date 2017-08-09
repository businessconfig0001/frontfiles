<?php

namespace FrontFiles\Jobs;

use FrontFiles\File;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
    public $timeout = 180;

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
                (new FileTypes\Audio)->process($this->file);
                break;
        }
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
}
