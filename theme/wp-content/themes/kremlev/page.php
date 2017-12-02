<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kremlev
 */

get_header();
	while ( have_posts() ) : the_post();
		get_template_part( 'template/content', 'page' );
		// if ( comments_open() || get_comments_number() ) :
			// comments_template();
		// endif;
	endwhile;
get_footer();
