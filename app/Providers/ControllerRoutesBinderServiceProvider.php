<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ControllerRoutesBinderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Models\Repositories\UsersRepositoryInterface',
            'App\Models\Repositories\DbUsersRepository'
        );

        $this->app->bind(
            'App\Models\Repositories\ResourcesRepositoryInterface',
            'App\Models\Repositories\DbResourcesRepository'
        );
        $this->app->bind(
            'App\Models\Repositories\ResourcesCategoriesRepositoryInterface',
            'App\Models\Repositories\DbResourcesCategoriesRepository'
        );

        $this->app->bind(
            'App\Models\Repositories\PostsCategoriesRepositoryInterface',
            'App\Models\Repositories\DbPostsCategoriesRepository'
        );
        $this->app->bind(
            'App\Models\Repositories\PostsTagsRepositoryInterface',
            'App\Models\Repositories\DbPostsTagsRepository'
        );
        $this->app->bind(
            'App\Models\Repositories\PostsRepositoryInterface',
            'App\Models\Repositories\DbPostsRepository'
        );
    }
}
