<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all users.
     *
     * @param  \App\Models\User  $current_user
     * @return mixed
     */
    public function view_all(User $current_user)
    {
        return in_array($current_user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\User  $current_user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $current_user, User $user)
    {
        return in_array($current_user->type, ['superadmin', 'admin'])
            || $current_user->id === $user->id;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\User  $current_user
     * @return mixed
     */
    public function create(User $current_user)
    {
        return in_array($current_user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $current_user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $current_user, User $user)
    {
        return $current_user->type === 'superadmin'
            || ($current_user->type === 'admin' && $user->type !== 'superadmin')
            || $current_user->id === $user->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Models\User  $current_user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $current_user, User $user)
    {
        if ($current_user->id === $user->id) return false;
        return $current_user->type === 'superadmin'
            || ($current_user->type === 'admin' && $user->type !== 'superadmin')
            || $current_user->id === $user->id;
    }
}
