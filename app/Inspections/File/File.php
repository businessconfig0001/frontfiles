<?php

namespace FrontFiles\Inspections\File;

class File
{
    /**
     * Filters the input for each file type.
     *
     * @param string $value
     * @return bool
     */
    public function check(string $value)
    {
        //Checks if the mime type is valid for each type
        switch(explode('/', $value)[0]){
            case 'video':
                (new Filters\Video)->isValid($value);
                break;
            case 'image':
                (new Filters\Image)->isValid($value);
                break;
            case 'audio':
                (new Filters\Audio)->isValid($value);
                break;
            default:
                (new Filters\Document)->isValid($value);
        }

        //If there's no exception thrown, it's a valid type
        return true;
    }
}