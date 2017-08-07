<?php

namespace FrontFiles\Rules;

use FrontFiles\Inspections\TokenValidator\TokenValidator;

class ValidToken
{
    /**
     * Custom validation rule for user's tokens.
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try{
            return (new TokenValidator)->check((string)$value, auth()->user()->id);
        } catch(\Exception $e){
            return false;
        }
    }
}