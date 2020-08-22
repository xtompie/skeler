module.exports = {
  filenameHashing: false,
  chainWebpack: config => {
    config.plugins.delete('html')
    config.plugins.delete('preload')
    config.plugins.delete('prefetch')
    config.optimization.delete("splitChunks");
  },
  outputDir: '../../public/resources/admin',
  productionSourceMap: false,
  runtimeCompiler: true,

  // vue-bluprint-chimera
  // publicPath: "./",

  // laravel + vue cli
  // // local Laravel server address for api proxy
  // devServer: { proxy: 'http://localhost:8000' },
  // publicPath: '/',
  // // for production we use blade template file
  // indexPath: process.env.NODE_ENV === 'production'
  //   ? '../resources/views/app.blade.php'
  //   : 'index.html',
  }
