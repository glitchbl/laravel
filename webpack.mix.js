const mix = require('laravel-mix');
const webpack = require('webpack');

mix.webpackConfig({
   plugins: [
      new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
   ]
});

mix.js('resources/assets/js/client.js', 'public/js')
   .sass('resources/assets/sass/client.scss', 'public/css')
   .js('resources/assets/js/admin.js', 'public/js')
   .sass('resources/assets/sass/admin.scss', 'public/css')
   .sourceMaps(false, 'source-map');