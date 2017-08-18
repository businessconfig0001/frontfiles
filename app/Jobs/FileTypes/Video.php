<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;
use FrontFiles\Utility\DriversHelper;
use Illuminate\Contracts\Filesystem\FileNotFoundException;


class Video implements FileProcessInterface
{
    /**
     * Method to process the file.
     *
     * @param File $file
     * @throws FileNotFoundException
     */
    public function process(File $file)
    {
        //fetch from dropbox
        $filesystem = DriversHelper::userDropbox($file->owner->dropbox_token);

        if(!$filesystem->has($file->name))
            throw new FileNotFoundException('We couln\'t find this file!');

        $video = $filesystem->read($file->name);

        //add watermark and encoding

        //save to blob storage

        //save blob storage url in "azure_url" field, for previews

        //change value "processed" to true

        //warn user that video has been processed?
    }
}