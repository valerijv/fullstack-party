var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableReactPreset()
    .enableVersioning(Encore.isProduction())
    .addEntry('js/app', './assets/js/app.js')
;

var config = Encore.getWebpackConfig();
config.module.rules.push({
  test: /\.scss$/,
  use: [
    'style-loader',
    'css-loader',
    'sass-loader',
  ]
})
module.exports = config;
