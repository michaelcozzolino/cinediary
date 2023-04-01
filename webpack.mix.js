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

mix.js('resources/js/app.js', 'public/js')
    // todo check how to move telescope css to public folder
    // .js('resources/css/vendor/telescope/app.css', 'public/js/vendor/telescope')
    .vue()
    .sass('resources/css/app.scss', 'public/css')
    .sass('resources/css/mdb.scss', 'public/css')
    .options({
        postCss: [require('postcss-import'), require('autoprefixer')],
    })
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}
