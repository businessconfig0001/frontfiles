<?php

namespace FrontFiles;

use Illuminate\{
    Database\Eloquent\Model,
    Support\Facades\Storage,
    Contracts\Filesystem\FileNotFoundException
};
use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\Models\{ CreateContainerOptions, PublicAccessType };
use MicrosoftAzure\Storage\Common\ServiceException;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'short_id', 'filename', 'url', 'title', 'description', 'what', 'where', 'when', 'who'
    ];

    /**
     * Global query scopes for the Video model.
     */
    protected static function boot()
    {
        parent::boot();

        //Automatically deletes from the storage the associated video
        static::deleting(function($video){
            $container = 'user-id-' . auth()->user()->id;

            if(!Storage::exists($container . '/' . $video->filename))
                throw new FileNotFoundException('We couln\'t find this file!');
            else
                Storage::delete($container . '/' . $video->filename);
        });
    }

    /**
     * Gets the path for the video.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function path()
    {
        return url("/video/{$this->short_id}");
    }

    /**
     * Generates a pseudo-random string that will be the Short ID of the video.
     *
     * @param int $length
     * @return string
     */
    public static function generateUniqueShortID(int $length = 15)
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
     * Stores the video and returns the url for this video.
     *
     * @param string $name
     * @return string
     */
    public static function storeAndReturnUrl(string $name)
    {
        // Copy to remote
        //!!! REMOVE THIS ON PRODUCTION
        ini_set('memory_limit', '-1');

        $container = 'user-id-' . auth()->user()->id;

        if(config('filesystems.default') === 'azure')
            static::createContainerIfNeeded($container);

        return config('filesystems.disks.' . config('filesystems.default') . '.url') .
            request()
                ->file('video')
                ->storeAs($container, $name, config('filesystems.default'));
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
     * Creator of the Video.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
