<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ResourceCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourceCategoryPolicy
{
    use HandlesAuthorization;

    public function view_all(User $user)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function view(User $user, ResourceCategory $category)
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

    public function update(User $user, ResourceCategory $category)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }

    public function delete(User $user, ResourceCategory $category)
    {
        if (in_array($user->type, ['superadmin', 'admin'])) {
            return true;
        }
        return false;
    }
}
