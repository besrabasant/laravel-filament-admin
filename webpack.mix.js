const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
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

mix.options({
    terser: {
        extractComments: false,
    },
})

mix.setPublicPath('dist')

mix.sourceMaps(false);

mix.version()

mix.js('resources/js/app.js', 'dist')
    .postCss('resources/css/app.css', 'dist', [
        tailwindcss('./tailwind.config.js'),
    ])
    .options({
        processCssUrls: false,
    });
