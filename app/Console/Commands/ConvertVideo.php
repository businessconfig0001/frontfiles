<?php

namespace FrontFiles\Console\Commands;

use Illuminate\Contracts\Filesystem\Factory as Filesystems;
use Illuminate\Config\Repository as ConfigRepository;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Log\Writer;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Monolog\Logger;
use Pbmedia\LaravelFFMpeg\FFMpeg;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;
use Mockery;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as Flysystem;
class ConvertVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:video 
                            {input : The name} 
                            {output : The path of the output video}
                            {watermark_image : The watermark image}
                            {storage_path : Path where file is}
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
        $watermark_image=$this->argument('watermark_image');

        $filesystems = Mockery::mock(Filesystems::class);
        $config      = Mockery::mock(ConfigRepository::class);
        $logger      = new Writer(new Logger('ffmpeg'));
        $adapter = Mockery::mock(AdapterInterface::class);
        $driver = Mockery::mock(FilesystemInterface::class);
        $driver->shouldReceive('getAdapter')->andReturn($adapter);
        $remoteDisk = Mockery::mock(FilesystemAdapter::class);
        $remoteDisk->shouldReceive('getDriver')->andReturn($driver);

        $localDisk = $this->getLocalAdapter();
        $filesystems->shouldReceive('disk')->once()->with('azure')->andReturn($remoteDisk);
        $filesystems->shouldReceive('disk')->once()->with('local')->andReturn($localDisk);
        $config->shouldReceive('get')->once()->with('laravel-ffmpeg')->andReturn(array_merge(config('laravel-ffmpeg'), ['default_disk' => 'local']));
        $config->shouldReceive('get')->once()->with('filesystems.default')->andReturn('local');

        $media = new FFMpeg( $filesystems,$config,$logger);
        $media->fromDisk(config('filesystems.default'))
            ->open($input)
            ->addFilter(['-i', $watermark_image,'-filter_complex','overlay=10:10'])
            ->addFilter(['-strict', 1])

            ->export()
            ->toDisk(config('filesystems.default')) // Maybe we need a different config here
            ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))

        ->save($output);
    }


    public function getLocalAdapter(): FilesystemAdapter
    {
        $flysystem = new Flysystem(new Local($this->argument('storage_path')));
        return new FilesystemAdapter($flysystem);
    }
}
