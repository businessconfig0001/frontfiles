<?php

namespace FrontFiles;

use FrontFiles\Utility\DriversHelper;
use FrontFiles\Utility\Helper;
use Illuminate\{ Database\Eloquent\Model, Contracts\Filesystem\FileNotFoundException };

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'short_id', 'drive', 'type', 'extension',
        'size', 'original_name', 'name', 'url', 'azure_url',
        'processed', 'title', 'description', 'where', 'when',
        'why', 'latitude', 'longitude'
    ];

    /**
     * The accessors to append custom attributes to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path', 'what', 'who'];

    /**
     * Global query scopes for the File model.
     */
    protected static function boot()
    {
        parent::boot();

        //Automatically deletes from the storage the associated file and the tags relation.
        static::deleting(function($file){

            $dropbox_token = $file->owner->dropbox_token;

            if($dropbox_token)
            {
                $filesystem = DriversHelper::userDropbox($dropbox_token);

                if(!$filesystem->has($file->name))
                    throw new FileNotFoundException('We couln\'t find this file!');
                else
                    $filesystem->delete($file->name);
            }

            $file->tagsWhat()->detach();
            $file->tagsWho()->detach();
        });
    }

    /**
     * Gets the path for the file.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function path() : string
    {
        return url("/files/{$this->short_id}");
    }

    /**
     * Gets the real path for the file.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function realPath() : string
    {
        return url("/files/{$this->id}");
    }

    /**
     * Generates a pseudo-random string that will be the Short ID of the file.
     *
     * @param int $length
     * @return string
     */
    public static function generateUniqueShortID(int $length = 8) : string
    {
        $output = Helper::generateRandomAlphaNumericString();

        if(static::where('short_id', $output)->exists())
            static::generateUniqueShortID($length);

        return $output;
    }

    /**
     * Returns the file type, according to the mime type provided.
     *
     * @param string $mimeType
     * @return string
     */
    public static function getFileType(string $mimeType = 'document') : string
    {
        $type = explode('/', $mimeType)[0];

        $acceptedTypes = [
            'video',
            'image',
            'audio',
        ];

        return in_array($type, $acceptedTypes) ? $type : 'document';
    }

    /**
     * Get the file's path.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * Get the file's who tag.
     *
     * @return array
     */
    public function getWhoAttribute() : array
    {
        return $this->tagsWho()->pluck('name')->toArray();
    }

    /**
     * Get the file's what tag.
     *
     * @return array
     */
    public function getWhatAttribute() : array
    {
        return $this->tagsWhat()->pluck('name')->toArray();
    }

    /**
     * Tags associated to this file.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tagsWho(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(TagWho::class, 'file_tagwho', 'file_id', 'tagwho_id');
    }

    /**
     * Tags associated to this file.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tagsWhat(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(TagWhat::class, 'file_tagwhat', 'file_id', 'tagwhat_id');
    }

    /**
     * Creator of the File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
