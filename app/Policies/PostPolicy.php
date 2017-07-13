<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine if the given user can create posts.
     *
     * @return bool
     */
    public function create(User $user)
    {
        // As long as the user is real, allowed
        return $user->id != null;
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        // Only if the user is the owner of the post
        return $user->id == $post->user_id;
    }
}