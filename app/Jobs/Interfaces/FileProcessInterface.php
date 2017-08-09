<?php

namespace FrontFiles\Jobs\Interfaces;

use FrontFiles\File;

interface FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     */
    public function process(File $file);
}