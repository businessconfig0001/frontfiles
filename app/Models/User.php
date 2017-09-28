<?php

namespace FrontFiles;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\{ HasSlug, SlugOptions };
use FrontFiles\Notifications\MailResetPasswordToken;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class User extends Authenticatable
{
    use HasRoles, HasSlug, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'first_name', 'last_name',
        'slug', 'avatar', 'avatar_name', 'bio',
        'location', 'dropbox_token', 'password',
        'confirmation_code', 'confirmed'
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

            //Delete user's avatar
            if($user->avatar_name)
                if(!Storage::exists('user-avatars/' . $user->avatar_name))
                    throw new FileNotFoundException('We couln\'t find this file!');
                else
                    Storage::delete('user-avatars/' . $user->avatar_name);

            //Delete user's files
            File::where('user_id', $user->id)->get()->each(function($file){
                $file->delete();
            });

        });
    }

    /**
     * Get the options for generating the slug.
     *
     * @return SlugOptions
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('slug');
    }

    /**
     * Returns the full name of the user.
     *
     * @return string
     */
    public function fullName() : string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Returns the full name of the user and his/her location.
     *
     * @return string
     */
    public function fullNameAndLocation() : string
    {
        return $this->first_name . ' ' . $this->last_name . ', ' . $this->location;
    }

    /**
     * Gets the path for the user's profile.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function path()
    {
        return url("/profile/{$this->slug}");
    }

    /**
     * Returns the amount of free space that the user has.
     *
     * @return int
     */
    public function amountOfSpaceLeft(): int
    {
        return (int)($this->allowed_space - $this->files->sum('size'));
    }

    /**
     * Checks if this user is an administrator.
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Send a password reset email to the user
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    /**
     * This will automatically encrypt the password.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        if(preg_match('/^\$2y\$[0-9]*\$.{50,}$/', $password))
            $this->attributes['password'] = $password;
        else
            $this->attributes['password'] = bcrypt($password);
    }

    /**
     * File relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(File::class, 'user_id');
    }
}
