<?php

namespace FrontFiles;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Global query scopes for the File model.
     */
    protected static function boot()
    {
        parent::boot();

        //Automatically deletes this user's files (from the storage and the database)
        static::deleting(function($user){
            File::where('user_id', $user->id)->get()->each(function($file){
                $file->delete();
            });
        });
    }


    /**
     * Returns the amount of free space that the user has.
     *
     * @return int
     */
    public function amountOfSpaceLeft()
    {
        return (int)($this->allowed_space - $this->files->sum('size'));
    }

    /**
     * File relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class, 'user_id');
    }

    /**
     * Role relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
