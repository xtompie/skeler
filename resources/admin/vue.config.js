module.exports = {
  filenameHashing: false,
  chainWebpack: config => {
    config.plugins.delete('html')
    config.plugins.delete('preload')
    config.plugins.delete('prefetch')
    config.optimization.delete("splitChunks");
  },
  outputDir: '../../public/resources/admin',
//   productionSourceMap: false,
  runtimeCompiler: true,
  "transpileDependencies": [
    "vuetify"
  ]
}
