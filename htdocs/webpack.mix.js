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
  'resources/assets/js/core/jquery.min.js',
  'resources/assets/js/core/popper.min.js', 
  'resources/assets/js/plugins/perfect-scrollbar.jquery.min.js', 
  'resources/assets/js/plugins/chartist.min.js', 
  'resources/assets/js/plugins/arrive.min.js', 
  'resources/assets/js/plugins/bootstrap-notify.js', 
  'resources/assets/js/plugins/demo.js',
  'resources/assets/js/bootstrap-material-design.min.js',
  'resources/assets/js/material-dashboard.js'
], 'public/js/app.js')
.sass('resources/assets/scss/material-dashboard.scss', 'public/css');

mix.scripts([
  'resources/assets/js/jquery-3.3.1.slim.min.js',
  'resources/assets/js/popper.min.js', 
  'resources/assets/js/bootstrap.min.js'
], 'public/js/corpus-admin-core.js');

// mix.js('resources/assets/js/bootstrap.min.js', 'public/js');

mix.js('resources/assets/js/Chart.min.js', 'public/js/chart.js');

mix.styles([
  'resources/assets/scss/bootstrap/bootstrap.min.css', 
  'resources/assets/scss/bootstrap/bootstrap-dashboard.css' 
], 'public/css/bootstrap.css');