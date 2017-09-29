<?php

namespace FrontFiles\Inspections\TokenValidator;

use FrontFiles\User;
use Laravel\Socialite\Facades\Socialite;

class TokenValidator
{
    /**
     * Checks if the user token is valid.
     *
     * @param string $value
     * @param int $user_id
     * @return bool
     * @throws \Exception
     */
    public function check(string $value, int $user_id) : bool
    {
        $user = User::find($user_id);

        try{
            //If there's no exception thrown, the user has a valid token
            Socialite::driver('dropbox')->userFromToken($user->dropbox_token);
            return true;
        } catch(\Exception $e) {
            //If the user doesn't have a valid token, an Exception is thrown
            $user->update(['dropbox_token' => null]);
            throw new \Exception('Your Dropbox token is not valid.');
        }
    }
}