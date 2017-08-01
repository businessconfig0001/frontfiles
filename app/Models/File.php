<?php

namespace FrontFiles;

use FrontFiles\Utility\Helper;
use Illuminate\{ Database\Eloquent\Model, Support\Facades\Storage, Contracts\Filesystem\FileNotFoundException };
use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\Models\{ CreateContainerOptions, PublicAccessType };
use MicrosoftAzure\Storage\Common\ServiceException;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'short_id', 'drive', 'type', 'extension',
        'size', 'original_name', 'name', 'url', 'title',
        'description', 'where', 'when', 'why'
    ];

    /**
     * Global query scopes for the File model.
     */
    protected static function boot()
    {
        parent::boot();

        //Automatically deletes from the storage the associated file
        static::deleting(function($file){
            switch($file->drive){
                case 'dropbox':
                    $client = new \Spatie\Dropbox\Client($file->owner->dropbox_token);
                    $adapter = new \Spatie\FlysystemDropbox\DropboxAdapter($client);
                    $filesystem = new \League\Flysystem\Filesystem($adapter);

                    if(!$filesystem->has($file->name))
                        throw new FileNotFoundException('We couln\'t find this file!');
                    else
                        $filesystem->delete($file->name);

                    break;
                default:
                    $container = 'user-id-' . $file->owner->id;

                    if(!Storage::exists($container . '/' . $file->name))
                        throw new FileNotFoundException('We couln\'t find this file!');
                    else
                        Storage::delete($container . '/' . $file->name);
                    break;
            }
        });
    }

    /**
     * Gets the path for the file.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function path()
    {
        return url("/files/{$this->short_id}");
    }

    /**
     * Gets the real path for the file.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function realPath()
    {
        return url("/files/{$this->id}");
    }

    /**
     * Generates a pseudo-random string that will be the Short ID of the file.
     *
     * @param int $length
     * @return string
     */
    public static function generateUniqueShortID(int $length = 8)
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
    public static function getFileType(string $mimeType = 'document')
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
     * Stores the file and returns the url for this file.
     *
     * @param string $name
     * @return string
     */
    public static function storeAndReturnUrl(string $name)
    {
        switch(request('drive'))
        {
            case 'dropbox':
                $client = new \Spatie\Dropbox\Client(auth()->user()->dropbox_token);
                $adapter = new \Spatie\FlysystemDropbox\DropboxAdapter($client);
                $filesystem = new \League\Flysystem\Filesystem($adapter);
                $filesystem->write($name, file_get_contents(request()->file('file')));

                return 'https://www.dropbox.com/home/Apps/'.auth()->user()->dropbox_app_name.'/'.$name;

            default:
                $container = 'user-id-' . auth()->user()->id;
                $config = config('filesystems.default');

                if($config === 'azure')
                    static::createContainerIfNeeded($container);

                return config('filesystems.disks.' . $config . '.url') .
                    request()
                        ->file('file')
                        ->storeAs($container, $name, $config);
        }
    }

    /**
     * Checks if the current user container exists in the azure blob storage
     * If it does not exist, he creates it.
     *
     * @param string $container
     */
    protected static function createContainerIfNeeded(string $container)
    {
        //BLOBS_ONLY means that its public
        $containerOptions = new CreateContainerOptions();
        $containerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY);

        try{
            ServicesBuilder::getInstance()
                ->createBlobService(config('filesystems.disks.azure.endpoint'))
                ->createContainer($container, $containerOptions);
        }catch(ServiceException $e){
            //If there's an exception, it means that the container (folder) already exists
        }
    }

    /**
     * Tags associated to this file.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'file_tag', 'file_id', 'tag_id');
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
