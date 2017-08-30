<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;

class Image implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $new_name
     */
    public function process(File $file, string $new_name)
    {
        \Intervention\Image\Facades\Image::make(public_path('userFiles/') . $file->name)
            ->insert(asset('watermarks/watermark.png'), 'top-right', 10, 10)
            ->save(public_path('userFiles/') . $new_name);
    }
}