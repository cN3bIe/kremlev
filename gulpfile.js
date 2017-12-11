'use strict';
const
	gulp = require( 'gulp' ),
	sass = require( 'gulp-sass' ),
	browserSync = require( 'browser-sync' ),
	concat = require( 'gulp-concat' ),
	cssnano = require( 'gulp-cssnano' ),
	rename = require( 'gulp-rename' ),
	sourcemaps = require('gulp-sourcemaps'),
	babelify = require('babelify'),
	browserify = require('browserify'),
	source = require('vinyl-source-stream'),
	buffer = require("vinyl-buffer"),
	uglify = require("gulp-uglify"),
	path = {
		app : 'app/cn3bie/templates/default/',
		theme : 'theme/wp-content/themes/kremlev/',
		src: 'src/',
		bower: 'bower_components/',
	};

function log(err){
	console.log('[Compilation Error]');
	console.log(err.fileName + ( err.loc ? `( ${err.loc.line}, ${err.loc.column} ): ` : ': '));
	console.log('error Babel: ' + err.message + '\n');
	console.log(err.codeFrame);
	this.emit('end');
}

gulp

	.task( 'sass',f => gulp.src( path.src + 'sass/**/*.+(sass|scss)')
		.pipe( sourcemaps.init( {loadMaps: true} ) )
		.pipe( sass({ outputStyle: 'compressed' }) ).on( 'error', sass.logError )
		.pipe( rename( {'suffix':'.min'} ) )
		.pipe( sourcemaps.write('./') )
		.pipe( gulp.dest( path.app + 'css') )
		.pipe( gulp.dest( path.theme + 'css') )
		.pipe( browserSync.reload({ stream:!0 }) )
	)

	.task('browserify', f => browserify( path.src + 'js-es6/index.js',{debug: true})
		.transform("babelify", {presets: ['env', 'react']})
		.bundle()
		.on("error", log)
		.pipe( source('main.min.js') )
		.pipe( buffer() )
		.pipe( sourcemaps.init({loadMaps: true}) )
		.pipe( uglify() )
		.pipe( sourcemaps.write('./') )
		.pipe( gulp.dest( path.app + 'js/') )
		.pipe( gulp.dest( path.theme + 'js/') )
	)

	.task( 'custom-vendor-sass',f => gulp.src([
			path.src + 'vendor/custom/sass/custom.sass'
		])
		.pipe( sass({ outputStyle: 'compressed' }) ).on( 'error', sass.logError )
		.pipe( rename({'suffix':'.min'}) )
		.pipe( gulp.dest( path.src + 'vendor/custom/dist' ) )
	)


	.task( 'custom-vendor-js',f => gulp.src([
			path.src + 'vendor/custom/js/markup.js',
			path.src + 'vendor/aishek-jquery-animateNumber/jquery.animateNumber.min.js',
		])
		.pipe( concat( 'custom.min.js') )
		.pipe( uglify() )
		.pipe( gulp.dest( path.src + 'vendor/custom/dist' ) )
	)



	.task( 'vendor-css',['custom-vendor-sass'],f => gulp.src([
			'node_modules/node-waves/dist/waves.min.css',
			'node_modules/izimodal/css/iziModal.min.css',
			'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css',
			'node_modules/material-design-lite/material.min.css',
			path.src + 'vendor/tooltipster-master/dist/css/tooltipster.bundle.min.css',
			path.src + 'vendor/Snarl-master/dist/snarl.min.css',
			path.src + 'vendor/fotorama-4.6.4/fotorama.css',
			path.src + 'vendor/social-share-kit-1.0.15/dist/css/social-share-kit.css',
			path.src + 'vendor/custom/dist/custom.min.css',
		])
		.pipe( concat( 'vendor.min.css' ) )
		.pipe( cssnano() )
		.pipe( gulp.dest( path.app + 'css') )
		.pipe( gulp.dest( path.theme + 'css') )
	)


	.task( 'vendor-js',['custom-vendor-js'],f => gulp.src( [
			'node_modules/jquery/dist/jquery.min.js',
			'node_modules/node-waves/dist/waves.min.js',
			'node_modules/inputmask/dist/min/jquery.inputmask.bundle.min.js',
			'node_modules/izimodal/js/iziModal.min.js',
			'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js',
			'node_modules/isotope-layout/dist/isotope.pkgd.min.js',
			'node_modules/material-design-lite/material.min.js',
			path.src + 'vendor/jquery.countdown.package-2.1.0/js/jquery.plugin.min.js',
			path.src + 'vendor/jquery.countdown.package-2.1.0/js/jquery.countdown.min.js',
			path.src + 'vendor/tooltipster-master/dist/js/tooltipster.bundle.min.js',
			path.src + 'vendor/Snarl-master/dist/snarl.min.js',
			path.src + 'vendor/fotorama-4.6.4/fotorama.js',
			path.src + 'vendor/social-share-kit-1.0.15/dist/js/social-share-kit.min.js',
			path.src + 'vendor/kladrapi-jsclient-master/jquery.kladr.min.js',
			path.src + 'vendor/custom/dist/custom.min.js',
		] )
		.pipe( concat( 'vendor.min.js') )
		.pipe( uglify() )
		.pipe( gulp.dest( path.app + 'js' ) )
		.pipe( gulp.dest( path.theme + 'js' ) )
	)


	.task( 'fonts',f => gulp.src([
			path.src + 'vendor/social-share-kit-1.0.15/dist/fonts/**/*',
			path.src + 'fonts/**/*',
		])
		.pipe( gulp.dest( path.app + 'fonts' ) )
		.pipe( gulp.dest( path.theme + 'fonts' ) )
	)

	.task( 'vendor-img',f => gulp.src([
			path.src + 'vendor/fotorama-4.6.4/**/*.+(jpg|png|gif)',
			path.src + 'vendor/kladrapi-jsclient-master/**/*.+(jpg|png|gif)'
		])
		.pipe( gulp.dest( path.app + 'css' ) )
		.pipe( gulp.dest( path.theme + 'css' ) )
	)

	.task( 'img', f => gulp.src([
			path.src + 'img/**/*'
		])
		.pipe( gulp.dest( path.app + 'img' ) )
		.pipe( gulp.dest( path.theme + 'img' ) )
	)


	.task( 'browser-sync', f => {
		browserSync({
			proxy:'http://kremlev.ru/',
		}); f();
	})


	.task( 'vendor',[ 'vendor-css','vendor-js','fonts','vendor-img' ])

	.task( 'html-watch',['html'], f =>{ browserSync.reload(); f(); } )
	.task( 'js-watch',['browserify'], f =>{ browserSync.reload(); f(); } )
	.task( 'php-watch', f =>{ browserSync.reload(); f(); } )


	.task( 'watch',['sass','browserify'], f =>{
		gulp.watch( path.src + 'sass/**/*.+(sass|scss)', ['sass'] );
		gulp.watch( path.src + 'js-es6/**/*.js',['js-watch'] );
		gulp.watch( path.app + '**/*.php',['php-watch'] );
		f();
	})


	.task( 'dev',['sass','browserify','browser-sync','watch'])

	.task( 'build',['sass','browserify','vendor','img'])

	.task( 'default',['build','browser-sync','watch']);
