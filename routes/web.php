<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@home');

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('/admin', 'Admin\DashboardController@index');

    // Users
    Route::get('/admin/profile', 'Admin\ProfileController@edit');
    Route::patch('/admin/profile', 'Admin\ProfileController@update');
    Route::resource('admin/users', 'Admin\UsersController', ['except' => [
        'show'
    ]]);

    // Resources
    Route::resource('admin/resources/categories', 'Admin\ResourceCategoriesController', ['except' => [
        'create', 'edit'
    ]]);
    Route::get('admin/resources/filter', 'Admin\ResourcesController@filter');
    Route::resource('admin/resources', 'Admin\ResourcesController', ['except' => [
        'show'
    ]]);

    // Posts
    Route::get('admin/posts/categories/possible_parent', 'Admin\PostCategoriesController@possible_parent');
    Route::resource('admin/posts/categories', 'Admin\PostCategoriesController', ['except' => [
        'create', 'edit'
    ]]);
    Route::resource('admin/posts/tags', 'Admin\PostTagsController', ['except' => [
        'create', 'edit'
    ]]);
    Route::resource('admin/posts', 'Admin\PostsController', ['except' => [
        'show'
    ]]);

    // Posts
    Route::resource('admin/pages', 'Admin\PagesController', ['except' => [
        'show'
    ]]);

    // Menus
    Route::get('admin/menus/{menu}/edit', 'Admin\MenusController@edit');
    Route::patch('admin/menus/{menu}', 'Admin\MenusController@update');

});

Route::get('/posts', 'PagesController@posts');
Route::get('/posts/{slug}', 'PagesController@post');

Route::get('/pages/{slug}', 'PagesController@page');

Route::get('/feed', 'FeedController@index');

