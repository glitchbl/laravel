const mix = require('laravel-mix');
const webpack = require('webpack');

mix.webpackConfig({
   plugins: [
      new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
   ]
});

mix.js('resources/js/client.js', 'public/js')
   .sass('resources/sass/client.scss', 'public/css')
   .js('resources/js/admin.js', 'public/js')
   .sass('resources/sass/admin.scss', 'public/css')
   .sourceMaps(false, 'source-map');
