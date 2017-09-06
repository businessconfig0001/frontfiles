<?php

namespace FrontFiles\Jobs\Interfaces;

use FrontFiles\File;

interface FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $tmp_name
     * @param string $new_name
     * @return
     */
    public function process(File $file, string $tmp_name, string $new_name);
}