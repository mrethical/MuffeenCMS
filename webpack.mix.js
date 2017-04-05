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

    // custom vendor
    .styles('resources/assets/css/admin/tinymce-custom.css', 'public/css/admin/tinymce-custom.css')
    .babel('resources/assets/js/admin/init-tinymce.js', 'public/js/admin/init-tinymce.js')
    .babel('resources/assets/js/admin/init-tinymce-minimal.js', 'public/js/admin/init-tinymce-minimal.js')

    // styles
    .styles('resources/assets/css/admin/style.css', 'public/css/admin/style.css')
    .styles('resources/assets/css/admin/resources/create.css', 'public/css/admin/resources/create.css')
    .styles('resources/assets/css/admin/resources/index.css', 'public/css/admin/resources/index.css')
    .styles('resources/assets/css/admin/posts/form-tags.css', 'public/css/admin/posts/form-tags.css')

    // scripts
    .babel([admin_helper, 'resources/assets/js/admin/users/index.js'], 'public/js/admin/users/index.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/categories.js'],
        'public/js/admin/resources/categories.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/create.js'],
        'public/js/admin/resources/create.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/index.js'],
        'public/js/admin/resources/index.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/select-image.js'],
        'public/js/admin/resources/select-image.js')
    .babel([admin_helper, 'resources/assets/js/admin/posts/categories.js'],
        'public/js/admin/posts/categories.js')
    .babel([admin_helper, 'resources/assets/js/admin/posts/tags.js'],
        'public/js/admin/posts/tags.js')
    .babel([admin_helper, 'resources/assets/js/admin/posts/form-tags.js'],
        'public/js/admin/posts/form-tags.js')

    // autoload
    .autoload({});