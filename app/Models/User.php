<?php

namespace FrontFiles;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
        'google_clientId', 'google_clientSecret',
        'google_refreshToken', 'google_folderId',
        'dropbox_token', 'dropbox_app_name',
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
     * This will automatically encrypt the password.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
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
}
