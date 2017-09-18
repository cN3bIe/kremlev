'use strict';
var
gulp = require( 'gulp' ),
sass = require( 'gulp-sass' ),
browserSync = require( 'browser-sync' ),
concat = require( 'gulp-concat' ),
uglifyjs = require( 'gulp-uglifyjs' ),
cssnano = require( 'gulp-cssnano' ),
rename = require( 'gulp-rename' ),
pagebuilder = require('gulp-pagebuilder'),
sourcemaps = require('gulp-sourcemaps'),
del = require( 'del' );


gulp

.task( 'sass',()=>{
	return gulp.src('src/sass/**/*.+(sass|scss)')
		.pipe( sourcemaps.init() )
		.pipe( sass({ outputStyle: 'compressed' }) ).on( 'error', sass.logError )
		.pipe( sourcemaps.write() )
		.pipe( gulp.dest('src/css') )
		.pipe( gulp.dest('app/wp-content/themes/kremlev/css') )
		.pipe( browserSync.reload({ stream:!0 }) );
})


.task( 'js', ()=>{
	return gulp.src( 'src/js/**/*.js' )
		.pipe( gulp.dest('app/wp-content/themes/kremlev/js') );
})


.task( 'html',()=>{
	return gulp.src( 'src/html/page/**/*.html' )
		.pipe( pagebuilder( 'src/html/template'))
		.pipe( gulp.dest('src'));
})


.task( 'browser-sync',()=>{
	browserSync({
		proxy:'http://kremlev.ru/',
		notify: false
	});
})


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
		.pipe( concat( 'custom.min.js') )
		.pipe( uglifyjs() )
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
			'src/libs/social-share-kit-1.0.14/dist/css/social-share-kit.css',
			'src/libs/custom/dist/custom.min.css',
		])
		.pipe( sourcemaps.init() )
		.pipe( concat( 'libs.min.css' ) )
		.pipe( cssnano() )
		.pipe( sourcemaps.write() )
		.pipe( gulp.dest( 'src/css') )
		.pipe( gulp.dest( 'app/wp-content/themes/kremlev/css') );
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
			'src/libs/social-share-kit-1.0.14/dist/js/social-share-kit.min.js',
			'src/libs/kladrapi-jsclient-master/jquery.kladr.min.js',
			'src/libs/custom/dist/custom.min.js',
		] )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'libs.min.js') )
		.pipe( uglifyjs() )
		.pipe( sourcemaps.write() )
		.pipe( gulp.dest( 'src/js' ) )
		.pipe( gulp.dest( 'app/wp-content/themes/kremlev/js' ) );
})


.task( 'libs-fonts',()=>{
	return gulp.src([
			'src/libs/social-share-kit-1.0.14/dist/fonts/**/*'
		])
		.pipe( gulp.dest( 'src/fonts' ) )
		.pipe( gulp.dest( 'app/wp-content/themes/kremlev/fonts' ) );
})

.task( 'libs-img',()=>{
	return gulp.src([
			'src/libs/fotorama-4.6.4/**/*.+(jpg|png|gif)',
			'src/libs/kladrapi-jsclient-master/**/*.+(jpg|png|gif)'
		])
		.pipe( gulp.dest( 'src/css' ) )
		.pipe( gulp.dest( 'app/wp-content/themes/kremlev/css' ) );
})



.task( 'libs',[ 'libs-css','libs-js','libs-fonts','libs-img' ])


.task( 'clean',()=>{
	return del.sync( 'dist' );
})


.task( 'html-watch',['html'], (done)=>{ browserSync.reload(); done(); } )
.task( 'js-watch',['js'], (done)=>{ browserSync.reload(); done(); } )


.task( 'watch', ()=>{
	gulp.watch( 'src/sass/**/*.+(sass|scss)', ['sass'] );
	gulp.watch( 'src/js/**/*.js',['js-watch'] );
	gulp.watch( 'src/html/**/*.html', ['html-watch'] );
});



gulp.task( 'default',['html','sass','js','libs','browser-sync','watch']);