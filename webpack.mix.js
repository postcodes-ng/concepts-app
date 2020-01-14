let mix = require('laravel-mix');
const InlineEnviromentVariablesPlugin = require('inline-environment-variables-webpack-plugin');
if (process.env.NODE_ENV !== 'production') {
    require('dotenv').load();
  }

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/npc-polyfills.js', 'public/js')
    .js('resources/js/npc-declarations.js', 'public/js')
    .js('resources/js/npc-common-functions.js', 'public/js')
    .js('resources/js/npc-postcodeFinder-page-functions.js', 'public/js')
    .js('resources/js/npc-postcodeReverse-page-functions.js', 'public/js')
    .js('resources/js/npc-google-map-functions.js', 'public/js')
    .js('resources/js/npc-contact.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/contact.scss', 'public/css')

if (mix.inProduction()) {
    mix.version();
}

mix.webpackConfig({
    plugins: [
        new InlineEnviromentVariablesPlugin([
            'JWT_SECRET',
            'JWT_ID',
            'JWT_ISSUER',
            'JWT_AUDIENCE'
        ])
    ]
});
