<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;

class Audio implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $new_name
     */
    public function process(File $file, string $new_name)
    {
        throw new \Exception('Image processing not implemented yet.');
    }
}