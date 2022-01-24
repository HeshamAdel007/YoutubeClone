<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Video $video)
    {

        return $user->id === $video->channel->user_id;
    } // End OF Delete

} // End Of Policy
