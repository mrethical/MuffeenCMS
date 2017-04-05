<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PostTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostTagPolicy
{
    use HandlesAuthorization;

    public function view_all(User $user)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function view(User $user, PostTag $tag)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function update(User $user, PostTag $tag)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function delete(User $user, PostTag $tag)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }
}
