const mix = require('laravel-mix');
require('laravel-mix-merge-manifest')

mix.js('resources/front/main.js', 'public/resources/front')
  .mergeManifest()
  .version()
