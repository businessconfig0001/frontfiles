<?php

namespace FrontFiles\Rules;

use FrontFiles\Inspections\File\File;

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
            return (new File)->check($value->getClientMimeType());
        } catch(\Exception $e){
            return false;
        }
    }
}