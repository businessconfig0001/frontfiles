<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use Intervention\Image\Facades\Image as Image;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;

class Images implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $new_name
     */
    public function process(File $file, string $new_name)
    {
        Image::make(public_path('userFiles/') . $file->name)
            ->insert(asset('watermarks/watermark.png'), 'top-right', 10, 10)
            ->text('ID: ' . $file->short_id , 25, 25, function($font){
                $font->file(4);
                $font->size(60);
                $font->color('#0000FF');
                $font->align('left');
                $font->valign('middle');
            })
            ->save(public_path('userFiles/') . $new_name);
    }
}