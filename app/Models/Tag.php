<?php

namespace FrontFiles;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
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
    public function associatedTo(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(File::class, 'file_tag', 'tag_id', 'file_id');
    }
}
