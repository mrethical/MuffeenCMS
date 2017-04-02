<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view_all(User $admin)
    {
        if (in_array($admin->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function view(User $admin, User $user)
    {
        if ($admin->type == 'superadmin') {
            return true;
        } else if ($admin->type == 'admin') {
            return $user->type != 'superadmin';
        }
        return $admin->id = $user->id;
    }

    public function create(User $admin)
    {
        if (in_array($admin->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function update(User $admin, User $user)
    {
        if ($admin->type == 'superadmin') {
            return true;
        } else if ($admin->type == 'admin') {
            return $user->type != 'superadmin';
        }
        return $admin->id = $user->id;
    }

    public function delete(User $admin, User $user)
    {
        if ($admin->type == 'superadmin' && $admin->id != $user->id) {
            return true;
        } else if ($admin->type == 'admin') {
            return $user->type != 'superadmin';
        }
        return false;
    }
}
