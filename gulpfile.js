const gulp          = require('gulp');
const rename        = require('gulp-rename');
const sass          = require('gulp-sass');
const browserSync   = require('browser-sync').create();
const runSequence   = require('run-sequence');

//CSS Processing (PostCSS)
const postcss       = require('gulp-postcss');
const sourcemaps    = require('gulp-sourcemaps');
const autoprefixer  = require('autoprefixer');
const cssnext       = require('cssnext');
// const mqpacker      = require('css-mqpacker');
const rucksack      = require('rucksack-css');
const concatUtil    = require('gulp-concat-util');
const cleanCSS      = require('gulp-clean-css');

//JS Processing
const babel         = require('gulp-babel');

// Error handling
const plumber       = require('gulp-plumber');
const notify        = require('gulp-notify');
const onError       = (err) => {
                        notify.onError({
                          title:    "Gulp error in " + err.plugin,
                          message:  err.toString()
                        })(err);
                        console.log(err.toString());
                        // this.emit('end');
                      };
const themeDir      = 'wp-content/themes/matthew-schroeter';

// BrowserSync
gulp.task('browserSync', function() {
  browserSync.init({
    proxy: 'sanborn.local'
  });
});

// SASS
gulp.task('sass', function() {
  return gulp.src(`${themeDir}/sass/style.scss`)
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(sass())
    .pipe(postcss([ rucksack, cssnext, autoprefixer({browsers: ['last 4 versions']}) ]))
    .pipe(rename('styles.css'))
    .pipe(gulp.dest(`${themeDir}/css`))
    .pipe(browserSync.stream());
});

// Minify CSS
gulp.task('minCSS', () => {
  return gulp.src(`${themeDir}/css/styles.css`)
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(cleanCSS())
    .pipe(rename('site.min.css'))
    .pipe(gulp.dest(`${themeDir}/css`))
});

// Minify CSS
gulp.task('processCSS', function () {
  runSequence(['sass'], ['minCSS']);
});

// Critical SASS
gulp.task('criticalSass', function() {
  return gulp.src(`${themeDir}/sass/critical.scss`)
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(sass())
    .pipe(postcss([ rucksack, cssnext, autoprefixer({browsers: ['last 4 versions']}) ]))
    .pipe(rename('critical.css'))
    .pipe(gulp.dest(`${themeDir}/css`))
    .pipe(browserSync.stream());
});

// Compile Critical
gulp.task('prepareCritical', function () {
  runSequence(['criticalSass'], ['optimize']);
});

// Minify Critical CSS
gulp.task('optimize', function() {
  return gulp.src(`${themeDir}/css/critical.css`)
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(cleanCSS())
    .pipe(concatUtil.header('<style>'))
    .pipe(concatUtil.footer('</style>'))
    .pipe(rename({
      basename: 'critical.css',
      extname: '.php'
    }))
    .pipe(gulp.dest(`${themeDir}/css`));
});

//Run JS through babel
gulp.task('babelify', () => {
  return gulp.src(`${themeDir}/js/*.js`)
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(babel({
      presets: [
        ['env', {
          "targets": {
            "browsers": ["last 3 versions"]
          },
          "blacklist": ['useStrict']
        }]],
      plugins: [
        ["transform-remove-strict-mode"]
      ]
    }))
    .pipe(rename('site.js'))
    .pipe(gulp.dest(`${themeDir}/js`))
    .pipe(browserSync.stream());
});

gulp.task('watch', ['browserSync', 'processCSS', 'prepareCritical', 'babelify'], function(){
  gulp.watch(`${themeDir}/sass/*.scss`, ['processCSS', 'prepareCritical']);
  gulp.watch(`${themeDir}/js/*.js`, ['babelify']);
  gulp.watch(`${themeDir}/**/*.php`, browserSync.reload);
});
