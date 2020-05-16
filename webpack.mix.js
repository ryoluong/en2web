/* eslint-disable no-undef */
const mix = require('laravel-mix');
const webpack = require('./webpack.config');

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

mix.options({
  hmrOptions: {
    host: '192.168.0.53',
    port: '8080',
  },
  postCss: [require('autoprefixer')],
});

mix.webpackConfig(Object.assign(webpack));

mix
  // .js("resources/js/v1/app.js", "public/js")
  // .sass("resources/sass/en2hpstyle.scss", "public/css")
  // .sass("resources/sass/en2webstyle.scss", "public/css")
  .js('resources/js/main.js', 'public/js');

if (mix.inProduction()) {
  mix.version();
}
