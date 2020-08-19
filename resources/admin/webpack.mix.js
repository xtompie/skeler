const mix = require('laravel-mix');
require('laravel-mix-merge-manifest')

mix.js('resources/admin/main.js', 'public/resources/admin')
  .extract(['vue'])
  .mergeManifest()
  .version()
