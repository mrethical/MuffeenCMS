const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    // PUBLIC
    mix.styles('style.css');
    mix.scripts('init.js');
    mix.scripts('server-dir.js');
    mix.scripts('jquery-ajax.js');

    // ADMIN
    mix.styles([
        'admin/style.css'
    ], 'public/css/admin/style.css');
    mix.styles([
        'simplePagination-flat.css'
    ], 'public/css/simplePagination-flat.css');
    mix.scripts([
        'init-tinymce.js'
    ], 'public/js/init-tinymce.js');

    // ADMIN - users
    mix.scripts([
        'admin/users.js'
    ], 'public/js/admin/users.js');

    // ADMIN - resources
    mix.styles([
        'admin/resources.css'
    ], 'public/css/admin/resources.css');
    mix.scripts([
        'admin/resources.js'
    ], 'public/js/admin/resources.js');

    // ADMIN - resources-create
    mix.styles([
        'admin/resource-create.css'
    ], 'public/css/admin/resource-create.css');
    mix.scripts([
        'admin/resource-create.js'
    ], 'public/js/admin/resource-create.js');

    // ADMIN - resources-categories
    mix.scripts([
        'admin/resources-categories.js'
    ], 'public/js/admin/resources-categories.js');

    // ADMIN - posts
    mix.scripts([
        'admin/posts.js'
    ], 'public/js/admin/posts.js');

    // ADMIN - resources-create
    mix.styles([
        'admin/post-create.css'
    ], 'public/css/admin/post-create.css');
    mix.scripts([
        'admin/post-create.js'
    ], 'public/js/admin/post-create.js');

    // ADMIN - posts-categories
    mix.scripts([
        'admin/posts-categories.js'
    ], 'public/js/admin/posts-categories.js');

    // ADMIN - posts-tags
    mix.scripts([
        'admin/posts-tags.js'
    ], 'public/js/admin/posts-tags.js');

    // ADMIN - menus
    mix.scripts([
        'admin/menus.js'
    ], 'public/js/admin/menus.js');

});
