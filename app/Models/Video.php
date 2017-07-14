<?php

namespace FrontFiles;

use Illuminate\{
    Database\Eloquent\Model,
    Support\Facades\Storage,
    Contracts\Filesystem\FileNotFoundException
};

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
            if(!Storage::exists(auth()->user()->email . '/' . $video->filename))
                throw new FileNotFoundException('We couln\'t find this file!');
            else
                Storage::delete(auth()->user()->email . '/' . $video->filename);
        });
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

        if(config('filesystems.default') === 'local')
            return config('filesystems.disks.local.url') .
                request()
                    ->file('video')
                    ->storeAs(auth()->user()->email, $name, config('filesystems.default'));

        return config('filesystems.disks.azure.url') .
            request()
                ->file('video')
                ->storeAs(auth()->user()->email, $name, config('filesystems.default'));
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
