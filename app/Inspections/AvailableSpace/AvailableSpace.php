<?php

namespace FrontFiles\Inspections\AvailableSpace;

class AvailableSpace
{
    /**
     * Checks if the user has enough space left to store this file.
     *
     * @param int $value
     * @return bool
     * @throws \Exception
     */
    public function check(int $value)
    {
        //If the use doesn't have enough space left, an Exception is thrown
        if($value > auth()->user()->amountOfSpaceLeft())
            throw new \Exception('You have reached your storage limit.');

        //If there's no exception thrown, the user has space
        return true;
    }
}