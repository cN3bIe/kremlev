<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cn3bie-ikra
 */

get_header();
?><section class="section">
	<div class="wr">
		<?php
		if ( have_posts() ) :
			the_posts_navigation();
			while ( have_posts() ) : the_post();
				get_template_part( 'template/content', get_post_format() );
			endwhile;
		else :
			get_template_part( 'template/content', 'none' );
		endif; ?>
	</div>
</section><?php
get_footer();
