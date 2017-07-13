<?php

namespace FrontFiles;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'short_id', 'filename', 'url', 'title', 'description', 'what', 'where', 'when', 'who'
    ];

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
