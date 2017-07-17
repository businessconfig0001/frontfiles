<?php

namespace FrontFiles\Inspections\File\Filters;

use FrontFiles\Inspections\File\Interfaces\FileInterface;

class Image implements FileInterface
{
    /**
     * Valid mime types for images.
     *
     * @var array
     */
    protected $validMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/bmp',
        'image/tiff',
        'image/x-quicktime',
        'image/x-icon',
    ];

    /**
     * Verifies if the image has a valid mime type.
     *
     * @param string $value
     * @throws \Exception
     */
    public function isValid(string $value)
    {
        if(!in_array($value, $this->validMimeTypes))
            throw new \Exception('This is not a valid image file.');
    }
}