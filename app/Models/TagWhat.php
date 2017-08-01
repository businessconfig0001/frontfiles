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
     * Files that this tag is associated to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(File::class, 'file_tagwhat', 'tagWhat_id', 'file_id');
    }
}
