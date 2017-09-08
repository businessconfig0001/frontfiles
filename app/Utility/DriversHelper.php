<?php

namespace FrontFiles\Utility;

use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DriversHelper
{
    /**
     * Returns the connection to the User's Dropbox.
     *
     * @param string $token
     * @return Filesystem
     */
    public static function userDropbox(string $token) : Filesystem
    {
        return new Filesystem(new DropboxAdapter(new Client($token)));
    }
}