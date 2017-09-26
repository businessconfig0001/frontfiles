<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use Illuminate\Support\Facades\Storage;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;

class Audio implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     */
    public function process(File $file)
    {
        Storage::disk('local')->delete($this->file->name);
        throw new \Exception('Audio processing not implemented yet.');
    }
}