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
mix
   .js('vuejs/modules/security/login/login.js', 'public/themes/controlPanel/views/security/login.min.js')
   .sass('vuejs/sass/app.scss', 'public/build/app.min.css')
   .sass('vuejs/sass/site.scss', 'public/build/site.min.css')

/**
 * your module javascript plugins goes here
 */
   .js('vuejs/modules/app/app.js', 'public/themes/controlPanel/views/app/app.min.js')
   .js('vuejs/modules/security/security.js', 'public/themes/controlPanel/views/security/security.min.js')
   .js('vuejs/modules/users/users.js', 'public/themes/controlPanel/views/users/users.js')

    // main js file
    .js('vuejs/modules/run.js', 'public/themes/controlPanel/assets/js/run.min.js')
;

