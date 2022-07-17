const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.disableSuccessNotifications()


mix.js('resources/js/admin/app.js', 'public/js/admin')
    .extract()
    .vue()
    .postCss('resources/css/admin/app.css', 'public/css/admin', [require('tailwindcss'), require('autoprefixer')])
    .postCss('resources/css/app.css', 'public/css', [require('tailwindcss'), require('autoprefixer')])

    .alias({
        '@': 'resources/js/admin',
        ziggy: 'vendor/tightenco/ziggy/dist/index',
    })
    .sourceMaps()
    .version();

if (mix.inProduction()) {
    mix.version();
}
