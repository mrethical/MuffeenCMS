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

mix.styles('resources/assets/css/admin/style.css', 'public/css/admin/style.css')
    .babel([admin_helper, 'resources/assets/js/admin/users/index.js'], 'public/js/admin/users/index.js')
    .autoload({});