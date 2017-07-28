<?php

namespace FrontFiles\Policies;

use FrontFiles\{ User, File };
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the file.
     *
     * @param  \FrontFiles\User  $user
     * @param  \FrontFiles\File  $file
     * @return mixed
     */
    public function view(User $user, File $file)
    {
        return $file->user_id === $user->id;
    }

    /**
     * Determine whether the user can create files.
     *
     * @param  \FrontFiles\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param  \FrontFiles\User  $user
     * @param  \FrontFiles\File  $file
     * @return mixed
     */
    public function update(User $user, File $file)
    {
        return $file->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the file.
     *
     * @param  \FrontFiles\User  $user
     * @param  \FrontFiles\File  $file
     * @return mixed
     */
    public function delete(User $user, File $file)
    {
        return $file->user_id === $user->id;
    }
}
