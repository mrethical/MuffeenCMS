## MuffeenCMS.
A Laravel 5.4 based CMS boilerplate to get started on any kind of project.

## System Requirements
Since MuffeenCMS is based on Laravel Framework, the same requirements also applies.

* PHP >= 7.0
  * OpenSSL PHP Extension
  * PDO PHP Extension
  * Mbstring PHP Extension
  * Tokenizer PHP Extension
  * XML PHP Extension
* [Composer](https://getcomposer.org) installed to load the dependencies.
* NodeJS with NPM
  * Required to push and modify CSS an JS files since these files are compiled using Webpack.

## Installation
Please check the system requirements before installing MuffeenCMS.

1. You may install by cloning from github.
   `git clone https://github.com/mrethical/MuffeenCMS.git`
2. On the project's root directory, run `composer install`
3. Rename .env.example to .env and set your database configuration there.
4. Run `php artisan key:generate`
5. Run migrations with seed:
   `php artisan migrate --seed`
6. Setup your web server to point to the "public" folder.
7. Run `npm install`
8. Run `npm run production` to compiled and move css and js files to public directory 
9. You can configure the site in the config folder before production.

### Permissions
MuffeenCMS may require one set of permissions to be configured to have write access by the web server.
For more details on installation check laravel installation guide
http://laravel.com/docs/5.4/installation

You may also take a look at this
http://stackoverflow.com/questions/30639174/file-permissions-for-laravel-5-and-others#answer-37266353

## Frameworks/Libraries

### PHP Libraries
* [laravel/laravel](https://github.com/laravel/laravel) - A PHP Framework For Web Artisans
* [doctrine/dbal](https://github.com/doctrine/dbal) - Doctrine Database Abstraction Layer
* [roumen/feed](https://github.com/RoumenDamianoff/laravel-feed) - A simple feed generator for Laravel

### CSS and Javascript Libraries
* [twbs/bootstrap](https://github.com/twbs/bootstrap) - The most popular HTML, CSS, and JavaScript framework for developing responsive, mobile first projects on the web
* [FortAwesome/Font-Awesome](https://github.com/FortAwesome/Font-Awesome) - The iconic font and CSS toolkit
* [driftyco/ionicons](https://github.com/driftyco/ionicons) - The premium icon font for Ionic
* [almasaeed2010/AdminLTE](https://github.com/almasaeed2010/AdminLTE) - Free Premium Admin control Panel Theme Based On Bootstrap 3.x
* [enyo/dropzone](https://github.com/enyo/dropzone) - An easy to use drag'n'drop library. It supports image previews and shows nice progress bars
* [fengyuanchen/cropper](https://github.com/fengyuanchen/cropper) - A simple jQuery image cropping plugin
* [rvera/image-picker](https://github.com/rvera/image-picker) - A simple jQuery plugin that transforms a select element into a more user friendly graphical interface
* [kamranahmedse/jquery-toast-plugin](https://github.com/kamranahmedse/jquery-toast-plugin) - Highly customizable jquery plugin to show toast messages

## Contributing, Questions and Suggestions

Thank you for considering contributing to MuffeenCMS! Please feel free to email me at jeffersonmagboo21@gmail.com.

## License

MuffeenCMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
