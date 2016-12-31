<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PostsCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostsCategoryPolicy
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
     * Determine whether the user can view the postsCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostsCategory  $postsCategory
     * @return mixed
     */
    public function view(User $user, PostsCategory $postsCategory)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can create postsCategories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the postsCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostsCategory  $postsCategory
     * @return mixed
     */
    public function update(User $user, PostsCategory $postsCategory)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can delete the postsCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostsCategory  $postsCategory
     * @return mixed
     */
    public function delete(User $user, PostsCategory $postsCategory)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }
}
