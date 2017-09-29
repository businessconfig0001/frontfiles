<?php

namespace FrontFiles\Utility;

use Illuminate\Support\Facades\Storage;
use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use MicrosoftAzure\Storage\Blob\Models\{ CreateContainerOptions, PublicAccessType };

class Helper
{
    /**
     * Generates a pseudo-random alpha-numeric string.
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomAlphaNumericString(int $length = 8) : string
    {
        $output = '';
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($chars) - 1;

        for($i = 0; $i < $length; $i++)
            $output .= $chars[random_int(0, $max)];

        return $output;
    }

    /**
     * Stores the user avatar in the azure blob storage and returns its URL.
     *
     * @param string $name
     * @param string $img
     * @return string
     */
    public static function storeUserAvatarAndReturnUrl(string $name, string $img) : string
    {
        $container = 'user-avatars';
        $config = config('filesystems.default');

        if($config === 'azure')
            static::createContainerIfNeeded($container);

        Storage::disk($config)->put($container . '/' . $name, $img);

        return config('filesystems.disks.' . $config . '.url') . $container . '/' . $name;
    }

    /**
     * If the user has an Avatar, it gets deleted.
     *
     * @param string $avatar_name
     * @throws FileNotFoundException
     */
    public static function deleteUserAvatar(string $avatar_name){
        if(!Storage::exists('user-avatars/' . $avatar_name))
            throw new FileNotFoundException('We couln\'t find this file!');
        else
            Storage::delete('user-avatars/' . $avatar_name);
    }

    /**
     * Checks if the container exists in the azure blob storage
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
     * Returns an array with the id's of the tags.
     *
     * @param string $tags
     * @param $type
     * @return array
     */
    public static function getTagIds(string $tags, $type) : array
    {
        $tagsFiltered = json_decode($tags, true);
        $output = [];

        foreach($tagsFiltered as $tag)
            if(!$type::where('name', $tag)->exists())
                array_push($output, $type::create(['name' => $tag])->id);
            else
                array_push($output, $type::where('name', $tag)->first()->id);

        return $output;
    }
}
