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
    option = {
        srcPath: "../xm/choujiang2", //项目目录
        distPath: "../dist/choujiang"//构建目录
    };

//构建目录清理
gulp.task("clean", function (done) {
    //return cache.clearAll(done);
    return gulp.src(option.distPath, {
        read: false
    })
    .pipe(clean({force: true}));

})

gulp.task("imgcopy", function () {//图片拷贝
    gulp.src(option.srcPath + "/images/**/*")
    .pipe(gulp.dest(option.distPath + '/images/'))
})

//js文件压缩
gulp.task('jsmin', function () {
    gulp.src([option.srcPath + "/js/**/**/*.js", '!' + option.srcPath + '/js/libs/*.js'])
        .pipe(jsmin())
        .pipe(gulp.dest(option.distPath+ "/js/"))
});

//需要合并和压缩的文件
gulp.task('concat', function () {
    gulp.src([
        option.srcPath + '/js/libs/angular.min.js',
        option.srcPath + '/js/libs/*.js',
        '!' + option.srcPath + '/js/libs/bridge*.js'
    ])
        .pipe(concat('libs.min.js'))
        .pipe(jsmin())
        .pipe(addsrc(option.srcPath + '/js/libs/bridge*.js'))
        .pipe(jsmin())
        .pipe(gulp.dest(option.distPath + "/js/libs/"))
});

gulp.task("processhtml", function () {
    var date = new Date().getTime();
    gulp.src( option.srcPath + '/main.html')
        .pipe(replace(/_VERSION_/gi, date))
        .pipe(processhtml())
        .pipe(htmlmin({
            collapseWhitespace: true
        }))
        .pipe(gulp.dest(option.distPath + '/'))
})

//压缩css
gulp.task("cssmin", function () {
    gulp.src(option.srcPath + "/css/*.css")
        .pipe(cssmin())
        .pipe(gulp.dest(option.distPath + '/css'))
})

//压缩html文件
gulp.task('htmlmin', function () {
    var options = {
        removeComments: true,//清除HTML注释
        collapseWhitespace: true,//压缩HTML
        removeEmptyAttributes: true,//删除所有空格作属性值 <input id="" /> ==> <input />
        removeScriptTypeAttributes: true,//删除<script>的type="text/javascript"
        removeStyleLinkTypeAttributes: true,//删除<style>和<link>的type="text/css"
        minifyJS: true,//压缩页面JS
        minifyCSS: true//压缩页面CSS
    };
    gulp.src(option.srcPath + '/**/*.html')
        .pipe(htmlmin(options))
        .pipe(gulp.dest(option.distPath + '/'))
});


// 默认任务 清空图片、样式、js并重建 运行语句 gulp
gulp.task('default', ['clean'], function () {
    gulp.start('jsmin', 'cssmin', 'processhtml', "htmlmin", 'imgcopy', 'concat');
});
