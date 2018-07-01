let mix = require('laravel-mix')

require('laravel-mix-purgecss')

mix
  .copyDirectory('resources/assets/fonts', 'public/fonts')
  .copyDirectory('resources/assets/images', 'public/images')
  .copyDirectory('resources/assets/js/plugins', 'public/js')
  .copyDirectory('resources/assets/js/skins', 'public/js')
  .copyDirectory('resources/assets/js/themes', 'public/js')
  .copyDirectory('resources/assets/flags', 'public/flags')
  .js('resources/assets/js/front.js', 'public/js')
  .js('resources/assets/js/admin.js', 'public/js')
  .sourceMaps()
  .sass('resources/assets/sass/front.scss', 'public/css')
  .sass('resources/assets/sass/admin.scss', 'public/css')
  .purgeCss({ enabled: true })
