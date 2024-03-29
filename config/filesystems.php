<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 'azure'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver'        => 'local',
            'root'          => public_path('userFiles/'),
            'url'           => env('APP_URL').'/userFiles/',
            'visibility'    => 'public',
        ],

        'slideshow' => [
            'driver'        => 'local',
            'root'          => public_path('images/slideshow/'),
            'url'           => env('APP_URL').'/images/slideshow/',
            'visibility'    => 'public',
        ],

        'azure' => [
            'driver'    => 'azure',
            'name'      => env('STORAGE_NAME'),
            'key'       => env('STORAGE_KEY'),
            'container' => env('STORAGE_CONTAINER'),
            'url'       => 'https://ffcontents.blob.core.windows.net/',
            'endpoint'  => sprintf(
                'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
                env('STORAGE_NAME'),
                env('STORAGE_KEY')
            ),
        ],

    ],

];
