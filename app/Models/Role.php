<?php

namespace FrontFiles;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
