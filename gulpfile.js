'use strict';
const
	gulp = require( 'gulp' ),
	sass = require( 'gulp-sass' ),
	babel = require( 'gulp-babel' ),
	// browserSync = require( 'browser-sync' ),
	concat = require( 'gulp-concat' ),
	uglify = require( 'gulp-uglify' ),
	cssnano = require( 'gulp-cssnano' ),
	rename = require( 'gulp-rename' ),
	sourcemaps = require('gulp-sourcemaps'),/*
	pagebuilder = require('gulp-pagebuilder'),
	del = require( 'del' )*/
	path = {
		src: 'src/cn3bie/templates/default/',
		theme : 'app/wp-content/themes/kremlev/'
	};


gulp

	.task( 'sass',()=>{
		return gulp.src('src/sass/**/*.+(sass|scss)')
			.pipe( sourcemaps.init() )
			.pipe( sass({ outputStyle: 'compressed' }) ).on( 'error', sass.logError )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( path.src + 'css') )
			.pipe( gulp.dest( path.theme + 'css') )/*
			.pipe( browserSync.reload({ stream:!0 }) )*/;
	})


	.task( 'js', ()=>{
		return gulp.src( 'src/js/**/*.js' )
			/*.pipe( babel({
				presets: ['env']
			}) ).on('error', function(err){
				console.log('[Compilation Error]');
				console.log(err.fileName + ( err.loc ? `( ${err.loc.line}, ${err.loc.column} ): ` : ': '));
				console.log('error Babel: ' + err.message + '\n');
				console.log(err.codeFrame);
				this.emit('end');
			})*/
			.pipe( concat( 'main.min.js' ) )
			.pipe( uglify() )
			.pipe( gulp.dest( path.src + 'js') )
			.pipe( gulp.dest( path.theme + 'js') );
	})

/*
	.task( 'html',()=>{
		return gulp.src( 'src/html/page/**//*.html' )
			.pipe( pagebuilder( 'src/html/template'))
			.pipe( gulp.dest('src'));
	})


	.task( 'browser-sync',()=>{
		browserSync({
			proxy:'http://kremlev.ru/',
			notify: false
		});
	})
*/

	.task( 'custom-libs-sass',()=>{
		return gulp.src([
				'src/libs/custom/sass/custom.sass'
			])
			.pipe( sourcemaps.init() )
			.pipe( sass({ outputStyle: 'compressed' }) ).on( 'error', sass.logError )
			.pipe( rename({'suffix':'.min'}) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( 'src/libs/custom/dist' ) );
	})


	.task( 'custom-libs-js',()=>{
		return gulp.src([
				'src/libs/custom/js/markup.js',
				'src/libs/aishek-jquery-animateNumber/jquery.animateNumber.min.js',
			])
			.pipe( sourcemaps.init() )
			.pipe( concat( 'custom.min.js') )
			.pipe( uglify() )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( 'src/libs/custom/dist' ) );
	})



	.task( 'libs-css',['custom-libs-sass'],()=>{
		return gulp.src([
				'node_modules/node-waves/dist/waves.min.css',
				'node_modules/izimodal/css/iziModal.min.css',
				'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css',
				'src/libs/material-design-lite/material.min.css',
				'src/libs/tooltipster-master/dist/css/tooltipster.bundle.min.css',
				'src/libs/Snarl-master/dist/snarl.min.css',
				'src/libs/fotorama-4.6.4/fotorama.css',
				'src/libs/social-share-kit-1.0.15/dist/css/social-share-kit.css',
				'src/libs/custom/dist/custom.min.css',
			])
			.pipe( sourcemaps.init() )
			.pipe( concat( 'libs.min.css' ) )
			.pipe( cssnano() )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( path.src + 'css') )
			.pipe( gulp.dest( path.theme + 'css') );
	})


	.task( 'libs-js',['custom-libs-js'],()=>{
		return gulp.src( [
				'node_modules/jquery/dist/jquery.min.js',
				'node_modules/node-waves/dist/waves.min.js',
				'node_modules/inputmask/dist/min/jquery.inputmask.bundle.min.js',
				'node_modules/izimodal/js/iziModal.min.js',
				'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js',
				'node_modules/isotope-layout/dist/isotope.pkgd.min.js',
				'src/libs/material-design-lite/material.min.js',
				'src/libs/jquery.countdown.package-2.1.0/js/jquery.plugin.min.js',
				'src/libs/jquery.countdown.package-2.1.0/js/jquery.countdown.min.js',
				'src/libs/tooltipster-master/dist/js/tooltipster.bundle.min.js',
				'src/libs/Snarl-master/dist/snarl.min.js',
				'src/libs/fotorama-4.6.4/fotorama.js',
				'src/libs/social-share-kit-1.0.15/dist/js/social-share-kit.min.js',
				'src/libs/kladrapi-jsclient-master/jquery.kladr.min.js',
				'src/libs/custom/dist/custom.min.js',
			] )
			.pipe( sourcemaps.init() )
			.pipe( concat( 'libs.min.js') )
			.pipe( uglify() )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( path.src + 'js' ) )
			.pipe( gulp.dest( path.theme + 'js' ) );
	})


	.task( 'libs-fonts',()=>{
		return gulp.src([
				'src/libs/social-share-kit-1.0.15/dist/fonts/**/*'
			])
			.pipe( gulp.dest( path.src + 'fonts' ) )
			.pipe( gulp.dest( path.theme + 'fonts' ) );
	})

	.task( 'libs-img',()=>{
		return gulp.src([
				'src/libs/fotorama-4.6.4/**/*.+(jpg|png|gif)',
				'src/libs/kladrapi-jsclient-master/**/*.+(jpg|png|gif)'
			])
			.pipe( gulp.dest( path.src + 'css' ) )
			.pipe( gulp.dest( path.theme + 'css' ) );
	})



	.task( 'libs',[ 'libs-css','libs-js','libs-fonts','libs-img' ])

/*
	.task( 'clean',()=>{
		return del.sync( 'dist' );
	})
*/

	.task( 'html-watch',['html'], (done)=>{ browserSync.reload(); done(); } )
	.task( 'js-watch',['js'], (done)=>{ /*browserSync.reload();*/ done(); } )


	.task( 'watch', ()=>{
		gulp.watch( 'src/sass/**/*.+(sass|scss)', ['sass'] );
		gulp.watch( 'src/js/**/*.js',['js-watch'] );
		// gulp.watch( 'src/html/**/*.html', ['html-watch'] );
	})


	.task( 'build',['sass','js','libs'])


	.task( 'default',[/*'html'*/,'sass','js','libs'/*,'browser-sync'*/,'watch']);