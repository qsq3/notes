var gulp = require('gulp'),//gulp基础库
    concat = require('gulp-concat'),//合并文件
    cssmin = require('gulp-minify-css'),//压缩css
    htmlmin = require("gulp-htmlmin"),//压缩html
    jsmin = require('gulp-uglify'),//压缩js
    rename = require('gulp-rename'),//重命名文件
    clean = require("gulp-clean"),//清理目录
    replace = require('gulp-replace'),//文本替换
    processhtml = require('gulp-processhtml'),//处理html文件
    addsrc = require('gulp-add-src'),//添加额外的文件流
    autoprefixer = require('gulp-autoprefixer'), // 添加 CSS 浏览器前缀
    imagemin = require('gulp-imagemin'), // 图片优化
    tobase64 = require('gulp-tobase64'), //图片转base64
    plumber = require('gulp-plumber'),//捕获错误;
    filter = require ('gulp-filter'), //过滤文件流
    jshint = require('gulp-jshint'), //jshint检查
    jscs = require('gulp-jscs'),  //jscs检查
    connect = require('gulp-connect'), //服务器
    gutil = require('gulp-util'), //打印信息等工具
    rev = require('gulp-rev'),
    babel = require('gulp-babel'), //ES6,react等的编译

    minimist = require('minimist'), //命令行传参数
    path = require('path'), //路径
    glob = require('glob'), //遍历
    browserSync = require('browser-sync').create(); //浏览器同步热更新
    

  //读取参数
var knownOptions = {
        string: 'env',
        default: {env: process.env.NODE_ENV || 'debug'}
    },
    gulpOptions = minimist(process.argv.slice(2), knownOptions);

    console.dir(gulpOptions);
    gutil.log(gulpOptions);

var srcPath = './',
    distPath = './dist/';

var paths = {
    src : srcPath,
    srcStatic : path.join(srcPath , './lib/**'),
    srcHtml : [path.join(srcPath , './**/*.html')],
    srcJs : [path.join(srcPath , './js/**/*.js'),'!'+path.join(srcPath , './js/lib/*.js')],
    srcCss : [path.join(srcPath , './css/**/*.css'),'!'+path.join(srcPath , './css/lib/*.css')],
    srcImg : [path.join(srcPath , './img/**')],
    dist : distPath,
    distStatic : path.join(distPath , './static'),
    distJs : path.join(distPath , './js'),
    distCss : path.join(distPath , './css'),
    distImg : path.join(distPath , './img')
};

var browserSyncPath = gulpOptions.env === 'debug' ? paths.src : paths.dist;

var tobase64Options = {
    log : 1, //是否输出log, 默认值为1
    maxsize:20, //kb
    ignore:'image_loading.png', //过滤图片 {RegExp|Array|String}
    pathrep: {  //将路由地址的图片路径替换成相对地址,格式为{reg:'',rep:''}
        reg:/\/public\/bizapp\d*\//g , //用于匹配替换的正则
        rep:'./public/'
    }
}

//JShint检查
gulp.task('jshint', function () {
  return gulp.src(paths.srcJs)
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

//js代码风格检查
gulp.task('jscs', function () {
  return gulp.src(paths.srcJs)
    .pipe(jscs());
});

//清理目录
gulp.task("clean", function (done) {
    //return cache.clearAll(done);
    return gulp.src(paths.dist, {
        read: false
    })
    .pipe(clean({force: true}));
})

//static
gulp.task('static', function() {
    return gulp.src(paths.srcStatic)
        .pipe(gulp.dest(paths.distStatic));
});

//img
gulp.task('img', function() {
    return gulp.src(paths.srcImg)
        .pipe(imagemin())
        .pipe(gulp.dest(paths.distImg));
});


//css
gulp.task('css', function () {
    return gulp.src(paths.srcCss)
        .pipe(tobase64(tobase64Options)) //图片转码
        .pipe(autoprefixer('last 6 version')) 
        //.pipe(concat('main.css'))
        .pipe(cssmin())
        .pipe(gulp.dest(paths.distCss));
});

//html
gulp.task("html", function () {
    var htmlminOptions = {
        removeComments: true,//清除HTML注释
        collapseWhitespace: true,//压缩HTML
        removeEmptyAttributes: true,//删除所有空格作属性值 <input id="" /> ==> <input />
        //removeScriptTypeAttributes: true,//删除<script>的type="text/javascript"
        //removeStyleLinkTypeAttributes: true,//删除<style>和<link>的type="text/css"
        minifyJS: true,//压缩页面JS
        minifyCSS: true//压缩页面CSS
    };
    return gulp.src(paths.srcHtml)
        .pipe(processhtml())
        .pipe(tobase64(tobase64Options))
        //.pipe(htmlmin(htmlminOptions))
        .pipe(gulp.dest(paths.dist));
})

//JS
gulp.task('js',['jshint','jscs'],function () {
    gulp.src(paths.srcJs)
        //.pipe(jsmin())
        .pipe(gulp.dest(paths.distJs))
});


//需要合并和压缩的文件
gulp.task('concat', function () {
    gulp.src([
        paths.src + '/js/libs/angular.min.js',
        paths.src + '/js/libs/*.js',
        '!' + paths.src + '/js/libs/bridge*.js'
    ])
        .pipe(concat('libs.min.js'))
        .pipe(jsmin())
        .pipe(addsrc(paths.src + '/js/libs/bridge*.js'))
        .pipe(jsmin())
        .pipe(gulp.dest(paths.dist + "/js/libs/"))
});

//处理主页
gulp.task("processhtml", function () {
    var date = new Date().getTime();
    gulp.src( paths.src + '/main.html')
        .pipe(replace(/_VERSION_/gi, date))
        .pipe(processhtml())
        .pipe(htmlmin({
            collapseWhitespace: true
        }))
        .pipe(gulp.dest(paths.dist))
})

//压缩其他html文件
gulp.task('htmlmin', function () {
    var options = {
        removeComments: true,//清除HTML注释
        collapseWhitespace: true,//压缩HTML
        removeEmptyAttributes: true,//删除所有空格作属性值 <input id="" /> ==> <input />
        //removeScriptTypeAttributes: true,//删除<script>的type="text/javascript"
        //removeStyleLinkTypeAttributes: true,//删除<style>和<link>的type="text/css"
        minifyJS: true,//压缩页面JS
        minifyCSS: true//压缩页面CSS
    };
    gulp.src(path.join(paths.src , '*.html'))
        .pipe(htmlmin(options))
        .pipe(gulp.dest(paths.dist))
});

//初始化
gulp.task('init', ['clean'], function() {
    if( gulpOptions.env === 'build') {gulp.start('static','img', 'js', 'css', 'html')};
});

gulp.task('watch', function() {
    gulp.watch(paths.srcHtml, ['html']); //监控js文件
    gulp.watch([paths.srcCss], ['css']); //监控html文件
    gulp.watch([paths.srcJs], ['js']); //监控html文件
    gulp.watch([paths.srcImg], ['img']); //监控html文件
});

gulp.task('browser-sync',['init'],function() {
  var files = [
    path.join(browserSyncPath,'**')
  ];
  browserSync.init(files,{
    injectChanges: false,
    server: {
      baseDir: browserSyncPath,
      port : 3000
    }
  });
});

gulp.task('default',['browser-sync'],function(){
  if( gulpOptions.env === 'build') {gulp.start('watch');}
});
