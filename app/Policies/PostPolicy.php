<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all Posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view_all(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can view the PostsCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        return in_array($user->type, ['superadmin', 'admin'])
            || $user->id === $post->author;
    }

    /**
     * Determine whether the user can create PostsCategories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the PostsCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return in_array($user->type, ['superadmin', 'admin'])
            || $user->id === $post->author;
    }

    /**
     * Determine whether the user can delete the PostsCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return in_array($user->type, ['superadmin', 'admin'])
            || $user->id === $post->author;
    }
}
