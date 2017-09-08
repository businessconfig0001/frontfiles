var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function() {
    return gulp.src('app/assets/_scss/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('app/assets/css/'));
});

gulp.task('default', ['sass'], function() {
    gulp.watch('app/assets/_scss/**/*.scss', ['sass']);
});