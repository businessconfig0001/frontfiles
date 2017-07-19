<?php

namespace FrontFiles\Inspections\AvailableSpace;

use FrontFiles\User;

class AvailableSpace
{
    /**
     * Checks if the user has enough space left to store this file.
     *
     * @param string $value
     * @return bool
     */
    public function check(string $value)
    {
        $user = auth()->user();

        dd($user);

        $user_space = $user->allowed_space;

        $used_space = $user->files->sum('size');

        //If there's no exception thrown, it's a valid type
        return true;
    }
}