<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use Illuminate\Support\Facades\Storage;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;

class Audios implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $tmp_name
     * @param string $new_name
     */
    public function process(File $file, string $tmp_name, string $new_name)
    {
        Storage::disk('local')->delete($this->file->name);
        throw new \Exception('Audio processing not implemented yet.');
    }
}