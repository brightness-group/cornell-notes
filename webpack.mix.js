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

/*
 App Compilation
 */

mix.webpackConfig({
    resolve: {
        extensions: ['.ts']
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                loader: 'ts-loader'
            }
        ]
    }
});

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer')
    ])
    .copy(['resources/css/pdf.css', 'resources/css/ckeditor-tailwind-reset.css'], 'public/css');

/*
 Marketing Compilation
 */

mix.js('resources/js/site.js', 'public/js/site.js')
    .postCss('resources/css/site.css', 'public/css/site.css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-focus-visible'),
        require('autoprefixer'),
    ])
    .copyDirectory('resources/assets/images', 'public/assets/images')
    .copyDirectory('resources/svg', 'public/assets/svg');

mix.options({
    cssNano: { minifyFontValues: false }
});

mix.version()
