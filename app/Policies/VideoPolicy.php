<?php

namespace FrontFiles\Policies;

use FrontFiles\{
    User, Video
};
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the video.
     *
     * @param  \FrontFiles\User  $user
     * @param  \FrontFiles\Video  $video
     * @return mixed
     */
    public function view(User $user, Video $video)
    {
        return $video->user_id == $user->id;
    }

    /**
     * Determine whether the user can create videos.
     *
     * @param  \FrontFiles\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the video.
     *
     * @param  \FrontFiles\User  $user
     * @param  \FrontFiles\Video  $video
     * @return mixed
     */
    public function update(User $user, Video $video)
    {
        return $video->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the video.
     *
     * @param  \FrontFiles\User  $user
     * @param  \FrontFiles\Video  $video
     * @return mixed
     */
    public function delete(User $user, Video $video)
    {
        return $video->user_id == $user->id;
    }
}
