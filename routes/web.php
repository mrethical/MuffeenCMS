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

Route::get('/', function () {
    return view('welcome');
});

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
    Route::resource('admin/resources', 'Admin\ResourceController', ['except' => [
        'show'
    ]]);


});
