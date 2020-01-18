/* eslint-disable no-undef */
const mix = require('laravel-mix');

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

mix.webpackConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js')
    }
  }
});

mix
  // .js("resources/js/v1/app.js", "public/js")
  // .sass("resources/sass/en2hpstyle.scss", "public/css")
  // .sass("resources/sass/en2webstyle.scss", "public/css")
  .js('resources/js/main.js', 'public/js');

if (mix.inProduction()) {
  mix.version();
}
