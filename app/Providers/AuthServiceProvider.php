<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\ResourceCategory' => 'App\Policies\ResourceCategoryPolicy',
        'App\Models\Resource' => 'App\Policies\ResourcePolicy',
        'App\Models\PostCategory' => 'App\Policies\PostCategoryPolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\PostTag' => 'App\Policies\PostTagPolicy',
        'App\Models\Page' => 'App\Policies\PagePolicy',
        'App\Models\MenuGroup' => 'App\Policies\MenuPolicy',
        'App\Models\Inquiry' => 'App\Policies\InquiryPolicy'
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
