// Import gulp dependencies
var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat-css');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

// Processes CSS
gulp.task('css', function () {
  return gulp.src('./src/scss/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('styles.css'))
    .pipe(cleanCSS())
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.dest('./res'));
});

// Processes JS
gulp.task('js', function () {
  return gulp.src('./src/js/*.js')
    .pipe(uglify())
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.dest('./res'));
});

// Watch over changes in the src directory
gulp.task('watch', function () {
  gulp.watch('./src/scss/*.scss', ['css']);
  gulp.watch('./src/js/*.js', ['js']);
});

gulp.task('run', ['css', 'js']);

gulp.task('default', function () {
  gulp.start(['run', 'watch']);
});
