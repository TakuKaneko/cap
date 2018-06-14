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
  'resources/assets/js/plugins/bootstrap-material-design.min.js',
  'resources/assets/js/plugins/material-dashboard.js'
], 'public/js/dashboard-common.js')
.scripts([
  'resources/assets/js/plugins/jquery-3.3.1.slim.min.js',
  'resources/assets/js/plugins/popper.min.js', 
  'resources/assets/js/plugins/bootstrap.min.js',
  'resources/assets/js/plugins/jquery.circliful.min.js'
], 'public/js/corpus-admin-core.js')
.js('resources/assets/js/plugins/Chart.min.js', 'public/js/chart.js')
.js('resources/assets/js/app.js', 'public/js/')
.sass('resources/assets/scss/common-dashboard.scss', 'public/css/common.css')
.styles([
  'resources/assets/scss/bootstrap/bootstrap.min.css', 
  'resources/assets/scss/bootstrap/bootstrap-dashboard.css',
  'resources/assets/scss/jquery.circliful.css'
], 'public/css/bootstrap.css')
.version();