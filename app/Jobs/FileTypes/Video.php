<?php

namespace FrontFiles\Jobs\FileTypes;

use FFMpeg;
use FrontFiles\File;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;

class Video implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $new_name
     */
    public function process(File $file, string $new_name)
    {
        //add encoding
        //add watermark
        FFMpeg::fromDisk('local')
            ->open($file->name)
            ->addFilter(['-i', asset('images/logo2x.png'),'-filter_complex','overlay=10:10'])
            ->addFilter(['-strict', 1])
            ->export()
            ->toDisk(config('filesystems.default'))
            ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
            ->save($new_name);
    }
}