'use strict';

var gulp = require('gulp'),
    plumber = require('gulp-plumber'),//捕获错误;
    babel = require('gulp-babel'),
    connect = require('gulp-connect'),
    browserSync = require('browser-sync').create();
var srcPath = 'es6JS/*.js',
    destPath = 'es5JS';

// Load plugins
//var $ = require('gulp-load-plugins')();

/* es6 */
gulp.task('babel', function() {
  return gulp.src(srcPath)
    .pipe(plumber())
    .pipe(babel({
      presets: ['es2015',"react","stage-3"]
    }))
    .pipe(gulp.dest(destPath));
});


gulp.task('connect', function() {
    connect.server({
        host: '127.0.0.1', //地址，可不写，不写的话，默认localhost
        port: 8000, //端口号，可不写，默认8000
        root: './', //当前项目主目录
        //livereload: true //自动刷新
    });
});

gulp.task('html', function() {
    gulp.src('./*.html')
        .pipe(connect.reload());
});


gulp.task('watch', ['babel'], function() {
    var watcher = gulp.watch([srcPath], ['babel']);//.watch方法路径不要用 './xx'
    watcher.on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });
    //gulp.watch(destPath+'/*.js', ['html']); //监控js文件
    //gulp.watch(['./*.html'], ['html']); //监控html文件
});

gulp.task('server', ['connect','watch']);

//方法二
gulp.task('browser-sync', function() {
  var files = [
    './*.html',
    '**/*.css',
    destPath+'/*.js'
  ];
  browserSync.init(files,{
    injectChanges: false,
    server: {
      baseDir: "./",
      port : 3000
    }
  });
});
gulp.task('browser', ['browser-sync','watch']);

gulp.task('default', ['browser']);
