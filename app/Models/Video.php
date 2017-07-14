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
            if(!Storage::exists('usercontents/'.$video->filename))
                throw new FileNotFoundException('We couln\'t find this file!');
            else
                Storage::delete('usercontents/'.$video->filename);
        });
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
