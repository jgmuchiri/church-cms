var mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/public_js.js','public/js')
    .js('resources/assets/js/login.js','public/js')
   .less('resources/assets/css/public.css', 'public/css')
   .less('resources/assets/css/admin.css', 'public/css');
