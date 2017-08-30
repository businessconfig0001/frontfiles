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
        FFMpeg::fromDisk('local')
            ->open($file->name)
            ->addFilter(['-i', asset('images/watermark.png'),'-filter_complex','overlay=main_w-overlay_w-10:10'])
            ->addFilter(['-strict', 1])
            ->export()
            ->toDisk('local')
            ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
            ->save($new_name);
    }
}