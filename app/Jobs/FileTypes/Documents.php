<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use Illuminate\Support\Facades\Storage;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;

class Documents implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $new_name
     */
    public function process(File $file, string $new_name)
    {
        Storage::disk('local')->delete($this->file->name);
        throw new \Exception('Document processing not implemented yet.');
    }
}