<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PagesController@home');

// Auth
Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    // Home
    Route::get('/home', function(){
        return redirect('/admin');
    });

    // Admin
    Route::get('/admin', 'Admin\DashboardController@index');
    Route::get('admin/profile', 'Admin\DashboardController@profile');

    // Admin User
    Route::resource('admin/users', 'Admin\UserController', ['except' => [
        'show'
    ]]);

    // Admin Resources
    Route::resource('admin/resources', 'Admin\ResourceController', ['except' => [
        'show'
    ]]);
    Route::resource('admin/resources/categories', 'Admin\ResourcesCategoryController', ['except' => [
        'create', 'edit'
    ]]);

    // Admin Posts
    Route::get('admin/posts/categories/possible_parents/{id}', 'Admin\PostsCategoryController@possible_parents');
    Route::resource('admin/posts/categories', 'Admin\PostsCategoryController', ['except' => [
        'create', 'show', 'edit'
    ]]);
    Route::resource('admin/posts/tags', 'Admin\PostsTagController', ['except' => [
        'create', 'show', 'edit'
    ]]);
    Route::resource('admin/posts', 'Admin\PostController', ['except' => [
        'show'
    ]]);

    // Menus
    Route::get('admin/menus/possible_parents/{id}', 'Admin\MenuController@possible_parents');
    Route::resource('admin/menus', 'Admin\MenuController', ['except' => [
        'create', 'show', 'edit'
    ]]);

});

Route::get('/{slug}', 'PagesController@post');
