<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PostsTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostsTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all tags.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view_all(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can view the postsTag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostsTag  $postsTag
     * @return mixed
     */
    public function view(User $user, PostsTag $postsTag)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can create postsTags.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the postsTag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostsTag  $postsTag
     * @return mixed
     */
    public function update(User $user, PostsTag $postsTag)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can delete the postsTag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostsTag  $postsTag
     * @return mixed
     */
    public function delete(User $user, PostsTag $postsTag)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }
}
