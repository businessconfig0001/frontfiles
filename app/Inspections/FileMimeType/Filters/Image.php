<?php

namespace FrontFiles\Inspections\FileMimeType\Filters;

use FrontFiles\Inspections\FileMimeType\Interfaces\FileMimeTypeInterface;

class Image implements FileMimeTypeInterface
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