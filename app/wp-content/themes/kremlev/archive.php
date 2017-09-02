<?php
/*
* Template name: Архив записей
*/
if( isset( $_GET['ajax'] ) ):
	$blog_posts = get_posts(array(
		'numberposts'=>3,
		'post_type'=>get_post_type(),
	));
	if( count( $blog_posts ) ) :
		?><div class="wr-blog row"><?php
			foreach( $blog_posts as $post ) : setup_postdata( $post );
				get_template_part( 'template/blog', 'item' );
			endforeach;
		?></div><?php
		wp_reset_postdata();
	endif;
	die();
else :
	get_header();
		if( have_posts() ):
			get_template_part( 'template/blog' );
		else :
			get_template_part( 'template/blog', 'none' );
		endif;
	get_footer();
endif;
