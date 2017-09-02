<?php
/*
* Template name: Страница каталога товаров
*/
$terms = get_terms( array(
	'taxonomy'=>'kremlev_category',
	'parent'=>0
) );
get_header();
if( is_array( $terms ) && count( $terms ) ):
	?><section class="section catalog catalog-page">
		<div class="wr">
			<h1 class="title"><?php the_title();?></h1><?php
			?><div class="wr-card">
				<div class="row"><?php
					foreach( $terms as $key=>$term):
						?><div class="transfer wr-item-card col s12 m4 l3 p0">
							<div class="item-card">
								<a href="/catalog/<?php echo $term->slug;?>/" class=" a-d img bg-contain" style="background-image:url('<?php echo types_render_termmeta( 'category_preview', array( 'url'=>true,'term_id'=>$term->term_id ) ); ?>');"></a>
								<div class="bl-info">
									<div class="wr-title-card">
										<a href="/catalog/<?php echo $term->slug;?>/" class="title-card a-d"><?php echo $term->name;?></a>
									</div>
								</div>
							</div>
						</div><?php
					endforeach;
				?></div>
			</div>
		</div>
	</section><?php
	wp_reset_postdata();
endif;
if( have_posts() ){
	while( have_posts() ){ the_post();
		get_template_part( 'template/content', 'page' );
	};
}
get_footer();