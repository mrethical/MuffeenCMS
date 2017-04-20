<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('admin.resources.select-image', function($view) {
            $view->with('resource_categories', \App\Repositories\ResourceCategories::getAllByName());
            $view->with('resources', \App\Repositories\Resources::getAllImageByName());
            $view->with('uploads_small_url', \App\Services\Uploads::getUploadUrls()['upload_images_small']);
            $view->with('uploads_url', \App\Services\Uploads::getUploadUrls()['upload']);
        });
        View::composer('_layouts.admin-sidebar', function($view) {
            $view->with('menus', \App\Models\MenuGroup::all());
        });
        View::composer('_layouts.public', function($view) {
            $view->with('menus', \App\Repositories\Menus::getRootByGroupID(1));
        });
        View::composer('posts.aside', function($view) {
            $view->with('uploads_small_url', \App\Services\Uploads::getUploadUrls()['upload_images_small']);
            $view->with('categories', \App\Repositories\PostCategories::getAllByName());
            $view->with('recent_posts', \App\Repositories\Posts::getMostRecent(3));
            $view->with('tags', \App\Repositories\PostTags::getAllByName());
        });
        View::composer('admin.users.form', function($view) {
            $view->with('uploads_users_url', \App\Services\Uploads::getUploadUrls()['upload_users']);
        });
        View::composer('_layouts.admin', function($view) {
            $view->with('uploads_users_url', \App\Services\Uploads::getUploadUrls()['upload_users']);
        });
        View::composer('_layouts.admin-sidebar', function($view) {
            $view->with('uploads_users_url', \App\Services\Uploads::getUploadUrls()['upload_users']);
        });
        View::composer('admin.dashboard', function($view) {
            $view->with('uploads_small_url', \App\Services\Uploads::getUploadUrls()['upload_images_small']);
            $view->with('uploads_users_url', \App\Services\Uploads::getUploadUrls()['upload_users']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
