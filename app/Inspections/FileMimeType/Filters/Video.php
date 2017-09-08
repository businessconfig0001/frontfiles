<?php

namespace FrontFiles\Inspections\FileMimeType\Filters;

use FrontFiles\Inspections\FileMimeType\Interfaces\FileMimeTypeInterface;

class Video implements FileMimeTypeInterface
{
    /**
     * Valid mime types for videos.
     *
     * @var array
     */
    protected $validMimeTypes = [
        'video/mp4',
        'video/mpeg',
        'video/avi',
        'video/webm',
        'video/ogg',
        'video/msvideo',
        'video/x-msvideo',
        'video/vnd.vivo',
        'video/quicktime',
        'video/mpeg4-generic',
        'video/x-ms-wmv',
    ];

    /**
     * Verifies if the video has a valid mime type.
     *
     * @param string $value
     * @throws \Exception
     */
    public function isValid(string $value)
    {
        if(!in_array($value, $this->validMimeTypes))
            throw new \Exception('This is not a valid video file.');
    }
}