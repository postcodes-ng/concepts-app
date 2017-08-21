let mix = require('laravel-mix');

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
   .js('resources/assets/js/npc-polyfills.js', 'public/js')
   .js('resources/assets/js/npc-declarations.js', 'public/js')
   .js('resources/assets/js/npc-common-functions.js', 'public/js')
   .js('resources/assets/js/npc-postcodeFinder-page-functions.js', 'public/js')
   .js('resources/assets/js/npc-postcodeReverse-page-functions.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
