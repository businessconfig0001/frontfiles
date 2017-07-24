<?php

namespace FrontFiles\Console\Commands;

use FFMpeg\FFMpeg;
use Illuminate\Console\Command;

class ConvertVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:video 
                            {input : The path of the input video} 
                            {output : The path of the output video}
                            {--queue= : Whether the job should be queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input=$this->argument('input');
        $output=$this->argument('output');
        FFMpeg::fromDisk(config('filesystems.default'))
            ->open($input)
            // export TO X264
            ->export()
            ->toDisk(config('filesystems.default')) // Maybe we need a different config here
            ->inFormat(new \FFMpeg\Format\Video\X264)
            ->save($output);
    }
}
