<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Resource' => 'App\Policies\ResourcePolicy',
        'App\Models\ResourcesCategory' => 'App\Policies\ResourcesCategoryPolicy',
        'App\Models\PostsCategory' => 'App\Policies\PostsCategoryPolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\PostsTag' => 'App\Policies\PostsTagPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
