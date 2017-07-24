<?php

namespace FrontFiles;

use Illuminate\{ Database\Eloquent\Model, Support\Facades\Storage, Contracts\Filesystem\FileNotFoundException };
use Illuminate\Support\Facades\Artisan;
use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\Models\{ CreateContainerOptions, PublicAccessType };
use MicrosoftAzure\Storage\Common\ServiceException;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'short_id', 'type', 'extension',
        'size', 'original_name', 'name', 'url', 'title',
        'description', 'what', 'where', 'when', 'who'
    ];

    /**
     * Global query scopes for the File model.
     */
    protected static function boot()
    {
        parent::boot();

        //Automatically deletes from the storage the associated file
        static::deleting(function($file){
            $container = 'user-id-' . auth()->user()->id;

            if(!Storage::exists($container . '/' . $file->name))
                throw new FileNotFoundException('We couln\'t find this file!');
            else
                Storage::delete($container . '/' . $file->name);
        });
    }

    /**
     * Gets the path for the file.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function path()
    {
        return url("/files/{$this->short_id}");
    }

    /**
     * Generates a pseudo-random string that will be the Short ID of the file.
     *
     * @param int $length
     * @return string
     */
    public static function generateUniqueShortID(int $length = 8)
    {
        $output = '';
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($chars) - 1;

        for($i = 0; $i < $length; $i++)
            $output .= $chars[mt_rand(0, $max)];

        if(static::where('short_id', $output)->exists())
            static::generateUniqueShortID($length);

        return $output;
    }

    /**
     * Returns the file type, according to the mime type provided.
     *
     * @param string $mimeType
     * @return string
     */
    public static function getFileType(string $mimeType = 'document')
    {
        $type = explode('/', $mimeType)[0];

        $acceptedTypes = [
            'video',
            'image',
            'audio',
        ];

        return in_array($type, $acceptedTypes) ? $type : 'document';
    }

    /**
     * Stores the file and returns the url for this file.
     *
     * @param string $name
     * @return string
     */
    public static function storeAndReturnUrl(string $name)
    {
        // Copy to remote
        //!!! REMOVE THIS ON PRODUCTION
        //ini_set('memory_limit', '-1');

        // 1. Copy from /tmp to local storage

        // Code here

        $container = 'user-id-' . auth()->user()->id;

        $config = config('filesystems.default');

        if($config === 'azure')
            static::createContainerIfNeeded($container);

        return config('filesystems.disks.' . $config . '.url') .
            request()
                ->file('file')
                ->storeAs($container, $name, $config);
    }

    /**
     * Checks if the current user container exists in the azure blob storage
     * If it does not exist, he creates it.
     *
     * @param string $container
     */
    protected static function createContainerIfNeeded(string $container)
    {
        //BLOBS_ONLY means that its public
        $containerOptions = new CreateContainerOptions();
        $containerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY);

        try{
            ServicesBuilder::getInstance()
                ->createBlobService(config('filesystems.disks.azure.endpoint'))
                ->createContainer($container, $containerOptions);
        }catch(ServiceException $e){
            //If there's an exception, it means that the container (folder) already exists
        }
    }

    /**
     * Creator of the File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
