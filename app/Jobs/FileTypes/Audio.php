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
     */
    public function process(File $file)
    {
        //fetch from dropbox

        //add watermark and encoding

        //save to blob storage

        //save blob storage url in "azure_url" field, for previews

        //change value "processed" to true

        //warn user that video has been processed?
    }
}