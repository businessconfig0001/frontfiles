<?php

namespace FrontFiles\Inspections\File\Filters;

use FrontFiles\Inspections\File\Interfaces\FileInterface;

class Document implements FileInterface
{
    /**
     * Valid mime types for documents.
     *
     * @var array
     */
    protected $validMimeTypes = [
        'application/pdf',
    ];

    /**
     * Verifies if the document has a valid mime type.
     *
     * @param string $value
     * @throws \Exception
     */
    public function isValid(string $value)
    {
        if(!in_array($value, $this->validMimeTypes))
            throw new \Exception('This is not a valid document file.');
    }
}