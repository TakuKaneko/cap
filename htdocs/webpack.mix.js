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

mix.scripts([
  'resources/assets/js/material-dashboard.js',
   'resources/assets/js/core/jquery.min.js',
   'resources/assets/js/core/popper.min.js', 
   'resources/assets/js/plugins/perfect-scrollbar.jquery.min.js', 
   'resources/assets/js/plugins/chartist.min.js', 
   'resources/assets/js/plugins/arrive.min.js', 
   'resources/assets/js/plugins/bootstrap-notify.js', 
   'resources/assets/js/plugins/demo.js'
    ], 'public/js/app.js')
   .sass('resources/assets/scss/material-dashboard.scss', 'public/css');