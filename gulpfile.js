/**
 *  Initialize Gulp
 */
var gulp = require('gulp');

/**
 *  Load Gulp Dependencies
 */
var sass = require('gulp-sass');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');
var util = require('gulp-util');

/**
 * Default Task
 */
gulp.task('default', ['scss', 'watch']);

/**
 * SCSS Task
 */
gulp.task('scss', function () {
    gulp.src(['admin/scss/image-size-manager-admin.scss'])
        .pipe(sass({style: 'compressed', errLogToConsole: true}))
        .pipe(rename('image-size-manager-admin.css'))
        .pipe(minifycss())
        .pipe(gulp.dest('admin/css'));
    util.log(util.colors.red('> > > compiled < < <'));
});

/**
 * Watch Task
 */
gulp.task('watch', function () {

    /**
     *  Watch PHP files for changes
     */
    var php = '**/*.php';

    gulp.watch(php).on('change', function (file) {

        util.log(util.colors.blue('[ ' + file.path + ' ]'));
    });

    /**
     *  Watch SCSS files for changes - trigger 'scss' task
     */
    gulp.watch('admin/scss/**/*.scss', ['scss']);
});
