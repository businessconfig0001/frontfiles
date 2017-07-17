<?php

namespace FrontFiles\Inspections\File\Filters;

use FrontFiles\Inspections\File\Interfaces\FileInterface;

class Audio implements FileInterface
{
    /**
     * Valid mime types for audios.
     *
     * @var array
     */
    protected $validMimeTypes = [
        'audio/mp4',
        'audio/mpeg',
        'audio/wav',
        'audio/webm',
        'audio/x-aiff',
        'audio/basic',
        'audio/x-midi',
        'audio/ogg',
        'audio/x-wav',
    ];

    /**
     * Verifies if the audio has a valid mime type.
     *
     * @param string $value
     * @throws \Exception
     */
    public function isValid(string $value)
    {
        if(!in_array($value, $this->validMimeTypes))
            throw new \Exception('This is not a valid audio file.');
    }
}