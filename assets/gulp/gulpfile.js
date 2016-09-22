var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    minifycss = require('gulp-minify-css');

gulp.task('powerup', ['minify-js', 'minify-css']);

gulp.task('minify-js', function () {
    gulp.src([
    '../bower_components/jquery/dist/jquery.min.js',
    '../bower_components/bootstrap/dist/js/bootstrap.min.js',
    '../bower_components/riot/riot.min.js',
    '../bower_components/riot/riot+compiler.min.js',
    '../bower_components/moment/min/moment.min.js',
    '../bower_components/moment/local/es.js',
    '../bower_components/highcharts/highcharts.js',
      '../js/ini.js',
      '../js/jquery.form.js',
      '../js/jquery.anexgrid.min.js',
  ])
        .pipe(concat('application.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../publish/'))
});

gulp.task('minify-css', function () {
    gulp.src([
      '../css/style.css',
  ])
        .pipe(concat('application.css'))
        .pipe(minifycss())
        .pipe(gulp.dest('../publish/'))
});