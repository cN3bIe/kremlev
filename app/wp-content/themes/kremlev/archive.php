<?php
/*
* Template name: Архив записей
*/
if( isset( $_GET['ajax'] ) ):
	$blog_posts = get_posts(array(
		'numberposts'=>3,
		'post_type'=>get_post_type(),
		'exclude'=>explode( 'id', $_GET['id'] )
	));
	if( count( $blog_posts ) ) :
		foreach( $blog_posts as $post ) : setup_postdata( $post );
			get_template_part( 'template/blog', 'item' );
		endforeach;
		wp_reset_postdata();
	else:
		header("HTTP/1.0 404 Not Found");
	endif;
	die();
else :
	$blog_posts = get_posts(array(
		'numberposts'=>9,
		'post_type'=>get_post_type()
	));
	get_header();
	if( count( $blog_posts ) ):
		?><section class="section blog">
			<div class="wr"><?php
				the_archive_title( '<h1 class="title">', '</h1>' );
				?><div class="wr-blog row"><?php
					foreach( $blog_posts as $post ) : setup_postdata( $post );
						get_template_part( 'template/blog', 'item' );
					endforeach;
				wp_reset_postdata();
				?></div><?php
				if( wp_count_posts( get_post_type() )->publish > 9 ){
					switch(get_post_type()){
						case 'kremlev_news':
							?><a href="/news/" class="a-d btn btni more-blog">Показать другие новости</a><?php
							break;
						case 'kremlev_recipes':
							?><a href="/recipes/" class="a-d btn btni more-blog">Показать другие рецепты</a><?php
							break;
						default:
							?><a href="/blog/" class="a-d btn btni more-blog">Показать другие записи</a><?php
							break;
					}
				}
			?></div>
		</section><?php
	else :
		get_template_part( 'template/blog', 'none' );
	endif;
	get_footer();
endif;
