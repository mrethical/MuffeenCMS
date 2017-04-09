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

    // public styles
    .babel('resources/assets/css/style.css', 'public/css/style.css')

    // admin styles
    .babel('resources/assets/css/admin/style.css', 'public/css/admin/style.css')
    .babel('resources/assets/css/admin/resources/create.css', 'public/css/admin/resources/create.css')
    .babel('resources/assets/css/admin/resources/index.css', 'public/css/admin/resources/index.css')
    .babel('resources/assets/css/admin/posts/form-tags.css', 'public/css/admin/posts/form-tags.css')
    .babel('resources/assets/css/admin/menus/edit.css', 'public/css/admin/menus/edit.css')

    // admin scripts
    .babel('resources/assets/js/admin/users/index.js', 'public/js/admin/users/index.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/categories.js'],
        'public/js/admin/resources/categories.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/create.js'],
        'public/js/admin/resources/create.js')
    .babel([admin_helper, 'resources/assets/js/admin/resources/index.js'],
        'public/js/admin/resources/index.js')
    .babel([
            admin_helper,
            'resources/assets/js/admin/posts/categories.js',
            'resources/assets/js/admin/slug.js'
        ],
        'public/js/admin/posts/categories.js'
    )
    .babel([admin_helper, 'resources/assets/js/admin/posts/tags.js'],
        'public/js/admin/posts/tags.js')
    .babel([
            admin_helper,
            'resources/assets/js/admin/resources/select-image.js',
            'resources/assets/js/admin/resources/image-attributes.js',
            'resources/assets/js/admin/posts/form-tags.js'
        ],
        'public/js/admin/posts/form.js'
    )
    .babel([admin_helper, 'resources/assets/js/admin/posts/index.js'],
        'public/js/admin/posts/index.js')
    .babel([
            admin_helper,
            'resources/assets/js/admin/resources/select-image.js'
        ],
        'public/js/admin/pages/form.js'
    )
    .babel([admin_helper, 'resources/assets/js/admin/pages/index.js'],
        'public/js/admin/pages/index.js')
    .babel([admin_helper, 'resources/assets/js/admin/menus/edit.js'],
        'public/js/admin/menus/edit.js')

    // admin custom scripts
    .babel('resources/assets/js/admin/slug.js',
        'public/js/admin/slug.js')

    // autoload
    .autoload({});