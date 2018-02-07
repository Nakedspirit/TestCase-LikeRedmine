var gulp           = require('gulp'),
		gutil          = require('gulp-util' ),
		sass           = require('gulp-sass'),
		browserSync    = require('browser-sync'),
		concat         = require('gulp-concat'),
		uglify         = require('gulp-uglify'),
		cleanCSS       = require('gulp-clean-css'),
		rename         = require('gulp-rename'),
		del            = require('del'),
		imagemin       = require('gulp-imagemin'),
		cache          = require('gulp-cache'),
		autoprefixer   = require('gulp-autoprefixer'),
		ftp            = require('vinyl-ftp'),
		notify         = require("gulp-notify"),
		rsync          = require('gulp-rsync'),
		babel			= require('gulp-babel'),
		jsdoc 			= require('gulp-jsdoc3');

// Скрипты проекта

gulp.task('doc', function (cb) {
    gulp.src(['README.md', 'web/js/*.js'], {read: false})
        .pipe(jsdoc(cb));
});

gulp.task('common-js', function() {
	return gulp.src([
        'web/js/model/*.js',
        'web/js/view/*.js',
        'web/js/controller /*.js',
		'web/js/common.js',
		])
		.pipe(babel({
            //plugins: ['transform-runtime'],
            presets: ['env']
        }))
	.pipe(concat('common.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('web/js'));
});

gulp.task('js', ['common-js'], function() {
	return gulp.src([
		'web/libs/jquery/dist/jquery.min.js',
        'web/libs/bootstrap/dist/js/bootstrap.min.js',
		'web/js/common.min.js', // Всегда в конце
		])
	.pipe(concat('scripts.min.js'))
	// .pipe(uglify()) // Минимизировать весь js (на выбор)
	.pipe(gulp.dest('web/js'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('browser-sync', function() {
	browserSync({
		proxy:'http://localhost/TestCase/web',
		notify: false,
		// tunnel: true,
		// tunnel: "projectmane", //Demonstration page: http://projectmane.localtunnel.me
	});
});

gulp.task('sass', function() {
	return gulp.src('web/sass/**/*.sass')
	.pipe(sass({outputStyle: 'expand'}).on("error", notify.onError()))
	.pipe(rename({suffix: '.min', prefix : ''}))
	.pipe(autoprefixer(['last 15 versions']))
	.pipe(cleanCSS()) // Опционально, закомментировать при отладке
	.pipe(gulp.dest('web/css'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('watch', ['sass', 'js', 'browser-sync'], function() {
	gulp.watch('web/sass/**/*.sass', ['sass']);
	gulp.watch(['libs/**/*.js', 'web/js/common.js'], ['js']);
	gulp.watch(['web/*.html','web/**/*.php'], browserSync.reload);
});

gulp.task('imagemin', function() {
	return gulp.src('web/img/**/*')
	.pipe(cache(imagemin()))
	.pipe(gulp.dest('dist/img')); 
});

gulp.task('build', ['removedist', 'imagemin', 'sass', 'js','doc'], function() {

	var buildFiles = gulp.src([
		'web/*.html',
		'web/.htaccess',
		]).pipe(gulp.dest('dist'));

	var buildCss = gulp.src([
		'web/css/main.min.css',
		]).pipe(gulp.dest('dist/css'));

	var buildJs = gulp.src([
		'web/js/scripts.min.js',
		]).pipe(gulp.dest('dist/js'));

	var buildFonts = gulp.src([
		'web/fonts/**/*',
		]).pipe(gulp.dest('dist/fonts'));

});

gulp.task('deploy', function() {

	var conn = ftp.create({
		host:      'hostname.com',
		user:      'username',
		password:  'userpassword',
		parallel:  10,
		log: gutil.log
	});

	var globs = [
	'dist/**',
	'dist/.htaccess',
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/path/to/folder/on/server'));

});

gulp.task('rsync', function() {
	return gulp.src('dist/**')
	.pipe(rsync({
		root: 'dist/',
		hostname: 'username@yousite.com',
		destination: 'yousite/public_html/',
		archive: true,
		silent: false,
		compress: true
	}));
});

gulp.task('removedist', function() { return del.sync('dist'); });
gulp.task('clearcache', function () { return cache.clearAll(); });

gulp.task('default', ['watch']);
