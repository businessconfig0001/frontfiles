<?php

namespace FrontFiles;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\{ HasSlug, SlugOptions };

class User extends Authenticatable
{
    use HasRoles;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'email',
        'dropbox_token', 'password',
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
     * Get the options for generating the slug.
     *
     * @return SlugOptions
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
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
    public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(File::class, 'user_id');
    }
}
