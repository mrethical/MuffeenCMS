<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ResourcesCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcesCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all categories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view_all(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can view the resourcesCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResourcesCategory  $resourcesCategory
     * @return mixed
     */
    public function view(User $user, ResourcesCategory $resourcesCategory)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can create resourcesCategories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the resourcesCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResourcesCategory  $resourcesCategory
     * @return mixed
     */
    public function update(User $user, ResourcesCategory $resourcesCategory)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can delete the resourcesCategory.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ResourcesCategory  $resourcesCategory
     * @return mixed
     */
    public function delete(User $user, ResourcesCategory $resourcesCategory)
    {
        return in_array($user->type, ['superadmin', 'admin']);
    }
}
