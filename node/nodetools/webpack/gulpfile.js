'use strict';

var gulp = require('gulp');
var path = require('path');

var webpack = require('webpack');
var webpackDevServer = require('webpack-dev-server');
var webpackConfig = require('./webpack.config.allinone.js');

//用于gulp传递参数
var minimist = require('minimist');
var gutil = require('gulp-util');

//读取参数
var knownOptions = {
    string: 'env',
    default: {env: process.env.NODE_ENV || 'production'}
};
var options = minimist(process.argv.slice(2), knownOptions);

//设置路径
var srcDir  = path.join(__dirname, './example/src'); //process.cwd() 取当前工作目录
var distDir = path.join(__dirname, './example/dist');
//配置webpack
var webpackConfigOptions = {
  debug : options.env === 'production' ? false : true,
  
  srcDir : srcDir,
  distDir : distDir,
  publicPath : '',
  alias: {
      jquery : path.join('js/lib','jquery-2.1.4'), //在定义root后可使用相对路径
      vue : path.join(srcDir,'js/lib','vue-2.1.6.js'), 
      loadash : path.join(srcDir,'js/lib','lodash-4.17.2.js'),
      publicPath: '/'
  },
  vendor : ['jquery', 'loadash'],
  
  port : 8080
};

var webpackCompiler = webpackConfig( webpackConfigOptions );
//var webpackCompiler = require('./webpack.config.js');

var remoteServer = {
    host: '192.168.0.129',
    port : '80',
    remotePath: '/data/website/website1',
    user: 'root',
    pass: 'password'
};
var localServer = {
    host: '192.168.56.130',
    port : '80',
    remotePath: '/data/website/website1',
    user: 'root',
    pass: 'password'
}

//check code
gulp.task('hint', function () {
    var jshint = require('gulp-jshint')
    var stylish = require('jshint-stylish')

    return gulp.src([
        '!' + srcDir + '/js/lib/**/*.js',
        srcDir + '/js/**/*.js'
    ])
        .pipe(jshint())
        .pipe(jshint.reporter(stylish));
})

// clean 
gulp.task('clean', ['hint'], function () {
    var clean = require('gulp-clean');
    return gulp.src(distDir, {read: true}).pipe(clean())
});

//run webpack pack
gulp.task('webpack-build', ['clean'], function (done) {
    webpack( webpackCompiler , function (err, stats) {
        if (err) throw new gutil.PluginError('webpack', err)
        gutil.log('[webpack-build]', stats.toString({colors: true}))
        done()
    });
});


//run webpackDevServer
gulp.task('webpack-dev-server',  function (done) {
    webpackCompiler.entry.index = webpackCompiler.entry.index || [];
    webpackCompiler.entry.index.unshift("webpack-dev-server/client?http://localhost:8080");  // 将执替换js内联进去
    webpackCompiler.entry.index.unshift("webpack/hot/dev-server"); // HMR 更新失败之后会刷新整个页面;webpack/hot/only-dev-server配置会要求手动刷新
    /*"server": "webpack-dev-server --progress --colors --hot --inline",*/
    new webpackDevServer(webpack(webpackCompiler), {
          hot: true , 
          stats: { colors: true },
          historyApiFallback: true
    }).listen(webpackCompiler.devServer.port, 'localhost', function (err) {
        if (err) {
            throw new gutil.PluginError('webpack-dev-server', err);
        }
        gutil.log('[webpack-dev-server]', 'http://localhost:' + webpackCompiler.devServer.port+'/index.html');
    });
});

//default task
gulp.task('default', ['webpack-build'])

//deploy distDir to remote server
gulp.task('deploy', function () {
    var sftp = require('gulp-sftp');
    var _conf = options.env === 'production' ? remoteServer : localServer;
    return gulp.src(distDir + '/**')
        .pipe(sftp(_conf))
})