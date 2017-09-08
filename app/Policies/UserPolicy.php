<?php

namespace FrontFiles\Policies;

use FrontFiles\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the profile.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return auth()->user()->id === $user->id;
    }

    /**
     * Determine whether the user can edit the profile.
     *
     * @param User $user
     * @return boolean
     */
    public function edit(User $user)
    {
        return auth()->user()->id === $user->id;
    }

    /**
     * Determine whether the user can update the profile.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return auth()->user()->id === $user->id;
    }

    /**
     * Determine whether the user can delete the profile.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return auth()->user()->id === $user->id;
    }

    /**
     * Determine whether the user can connect via oauth.
     *
     * @param User $user
     * @return bool
     */
    public function oauth(User $user)
    {
        return auth()->user()->id === $user->id;
    }
}
