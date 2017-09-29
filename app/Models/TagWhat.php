<?php

namespace FrontFiles;

use Illuminate\Database\Eloquent\Model;

class TagWhat extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tagswhat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Global query scopes for the File model.
     */
    protected static function boot()
    {
        parent::boot();

        //Automatically deletes the relation between the tag and the files
        static::deleting(function($tagWhat){
            $tagWhat->files()->detach();
        });
    }

    /**
     * Files that this tag is associated to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(File::class, 'file_tagwhat', 'tagWhat_id', 'file_id');
    }
}
