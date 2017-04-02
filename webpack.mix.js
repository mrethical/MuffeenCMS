const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

let admin_helper = 'resources/assets/js/admin/helpers.js';

mix
    // vendor
    .copy('node_modules/jquery-toast-plugin/dist/jquery.toast.min.css',
        'public/vendor/jquery-toast-plugin/jquery.toast.min.css')
    .copy('node_modules/jquery-toast-plugin/dist/jquery.toast.min.js',
        'public/vendor/jquery-toast-plugin/jquery.toast.min.js')
    .js('resources/assets/vendor/jquery-simplePagination/jquery-simplePagination.js',
        'public/vendor/jquery-simplePagination/jquery-simplePagination.js')

    // styles
    .styles('resources/assets/css/admin/style.css', 'public/css/admin/style.css')

    // scripts
    .babel([admin_helper, 'resources/assets/js/admin/users/index.js'], 'public/js/admin/users/index.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/categories.js'],
        'public/js/admin/resources/categories.js')

    // autoload
    .autoload({});