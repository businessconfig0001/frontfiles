<?php

namespace FrontFiles\Rules;

use FrontFiles\Inspections\AvailableSpace\AvailableSpace;

class HasEnoughSpace
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
            return (new AvailableSpace)->check((int)$value->getClientSize());
        } catch(\Exception $e){
            return false;
        }
    }
}