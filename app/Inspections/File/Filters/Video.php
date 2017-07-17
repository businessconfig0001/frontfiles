<?php

namespace FrontFiles\Inspections\File\Filters;

use FrontFiles\Inspections\File\Interfaces\FileInterface;

class Video implements FileInterface
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