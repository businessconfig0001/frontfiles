<?php

namespace FrontFiles\Rules;

use FrontFiles\Inspections\FileMimeType\FileMimeType;

class AllowedFile
{
    /**
     * Custom validation rule for files.
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try{
            return (new FileMimeType)->check((string)$value->getMimeType());
        } catch(\Exception $e){
            return false;
        }
    }
}