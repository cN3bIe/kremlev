<?php
/*
* Template name: Детализация статьи
*/

// $quantity_blog = get_post_meta( get_the_ID(), 'main_blog_quantity', !0 );
/*Другие новости*/
$blog_news = get_posts( array(
	'numberposts'=>3,
	'post_type'=>get_post_type(),
	'exclude' => get_the_ID(),
) );
$additional_block = get_post_meta( get_the_ID(), 'additional_block', !0 );
get_header();
?><section class="section blog-item">
	<div class="wr">
		<div class="row">
			<div class="col s12 m9 p0">
				<div class="wr-news">
					<div class="bl-title bg-cover before" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'large'); ?>');">
						<h1 class="title"><?php the_title();?></h1>
					</div>
					<article class="bl-content">
						<div class="content text"><?php the_post(); the_content();?></div><?php
						if($additional_block) echo '<p class="bl-additional">'.$additional_block.'</p>';
					?></article>
				</div>
			</div>
			<div class="col s12 m3 p0"><?php
			if( ot_get_option( 'baner_link' )):
				?><a href="<?php echo ot_get_option( 'baner_link' );?>" class="blog-item-baner">
					<img src="<?php echo ot_get_option( 'baner_upload' );?>" alt="">
				</a><?php
			else:
				?><div class="blog-item-baner">
					<img src="<?php echo ot_get_option( 'baner_upload' );?>" alt="">
				</div><?php
			endif;
			?></div>
		</div>
		<div class="bl-share"><?php
		switch(get_post_type()){
			case 'kremlev_news':
				?><div class="title-share">Понравилась новость? Расскажи друзьям</div><?php
				break;
			case 'kremlev_recipes':
				?><div class="title-share">Понравилась рецепт? Расскажи друзьям</div><?php
				break;
			default:
				?><div class="title-share">Понравилась статья? Расскажи друзьям</div><?php
				break;
		}
		?><div class="ssk-group">
				<a href="" class="ssk ssk-icon ssk-facebook" data-ssk-ready="true"></a>
				<a href="" class="ssk ssk-icon ssk-twitter" data-ssk-ready="true"></a>
				<a href="" class="ssk ssk-icon ssk-google-plus" data-ssk-ready="true"></a>
				<a href="" class="ssk ssk-icon ssk-vk" data-ssk-ready="true"></a>
			</div>
		</div>
	</div>
</section><?php
get_template_part( 'template/catalog', 'recomend' );
if( count( $blog_news ) ):
	?><section class="section others-news">
		<div class="wr"><?php
			switch(get_post_type()){
				case 'kremlev_news':
					?><h2 class="title">Другие новости</h2><?php
					break;
				case 'kremlev_recipes':
					?><h2 class="title">Другие рецепты</h2><?php
					break;
				default:
					?><h2 class="title">Другие статьи</h2><?php
					break;
			}
			?><div class="wr-blog row"><?php
				foreach( $blog_news as $post){ setup_postdata( $post );
					get_template_part( 'template/blog', 'item' );
				}
				wp_reset_postdata();
			?></div>
		</div>
	</section><?php
endif;
get_footer();