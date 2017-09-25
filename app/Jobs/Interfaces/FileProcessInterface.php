<?php

namespace FrontFiles\Jobs\Interfaces;

use FrontFiles\File;

interface FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @return
     */
    public function process(File $file);
}