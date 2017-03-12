<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all menus.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view_all(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can view the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function view(User $user, Menu $menu)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can create menus.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function update(User $user, Menu $menu)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can delete the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function delete(User $user, Menu $menu)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }
}
