<?php
/*
* Template name: Страница Акций
*/


// if( !isset($_GET['d']) ) die('Еще видётся разработка, зайдите позже или обратитесь к администратору');
$products = get_posts( [
	'numberposts' =>-1,
	'post_type' => 'catalog',
	'post_status'=>'publish',
	'order'=>'ASC',
	'orderby'=>'meta_value_num',
	'meta_query' => [
		'relation'=>'OR',
		[
			'key' => 'catalog_sale',
			'value' => '',
			'compare' => '!=',
		],
	],
] );
$prod_id = [];

if( is_array( $products ) && count( $products ) ) foreach( $products as $item ) $prod_id[] = $item->ID;

$category = get_terms( 'kremlev_category', ['object_ids' => $prod_id,] );

$arr_terms = [];
$arr_terms_id = [];
if( is_array( $category ) && count( $category ) ):
	foreach( $category as $term ):
		if( $term->parent ):
			$arr_terms[] = $term;
			$arr_terms_id[] = $term->term_id;
		endif;
	endforeach;
endif;

$filter_terms = get_terms( 'kremlev_filter' );
$filters = [];
if( is_array( $filter_terms ) && count( $filter_terms ) ):
	foreach( $filter_terms as $term ):
		if( !$term->parent ):
			$filters[$term->term_id]['parent'] = $term;
		else:
			$posts = get_posts( [
				'numberposts' =>-1,
				'post_type' => 'catalog',
				'post_status'=>'publish',
				'order' => 'ASC',
				'orderby' => 'meta_value_num',
				'meta_query' => [
					'relation'=>'OR',
					[
						'key' => 'catalog_sale',
						'value' => '',
						'compare' => '!=',
					],
				],
				'tax_query' => [
					'relation'=>'AND',
					[
						'taxonomy' => 'kremlev_category',
						'terms'    => $arr_terms_id,
					],
					[
						'taxonomy' => 'kremlev_filter',
						'terms'    => $term->term_id,
					],
				]
			] );
			if( count( $posts ) ) $filters[$term->parent]['children'][$term->term_id] = $term;
		endif;
	endforeach;
endif;
$action_list = ot_get_option( 'action_list' );

get_header();
if( is_array( $action_list ) && count( $action_list ) ):
	?><section class="section"><div class="wr section-action-banner"><?php
		foreach( $action_list as $key => $item ):
			if( $item[ 'action_baner_link' ] ) { ?><a href="<?php echo $item[ 'action_baner_link' ];?>" class="action-item-baner a-d action-js-banner"><?php }
				?><img <?php if( !$item[ 'action_baner_link' ] ) { ?>class="action-js-banner"><?php } ?> src="<?php echo $item[ 'action_baner_upload' ];?>" alt=""><?php
			if( $item[ 'action_baner_link' ] ) { ?></a><?php }
		endforeach;
	?></div></section><?php
endif;
?><section class="section catalog catalog-page">
	<div class="wr">
		<h1 class="title"><?php the_title();?></h1>
		<div class="wr-catalog row">
			<div class="wr-filter col s12 m4 l3 p0">
				<div class="dn btn-filter">Фильтр</div>
				<div class="form-filter">
					<div class="bl-filter" data-filter-group="filter-0" data-filter-lvl="0">
						<div class="title-filter">Марка товара</div><?php
						foreach($arr_terms as $key=>$term){
							?><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?php echo $term->term_id;?>" data-filter=".filter-<?php echo $term->slug;?>">
								<input type="checkbox" id="<?php echo $term->term_id;?>" class="mdl-checkbox__input" name="kremlev_category[]">
								<span class="mdl-checkbox__label"><?php echo $term->name;?></span>
							</label><?php
						}
					?></div><?php
					if( is_array( $filters ) && count( $filters ) ):
						foreach( $filters as $key => $filter ):
							$parent = $filter['parent'];
							?><div class="bl-filter" data-filter-group="filter-<?php echo $key;?>" data-filter-lvl="<?php echo $key;?>">
								<div class="title-filter"><?php echo $parent->name;?></div><?php
								foreach( $filter['children'] as $item){
								?><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?php echo $item->term_id;?>" data-filter=".filter-<?php echo $item->slug;?>">
									<input type="checkbox" id="<?php echo $item->term_id;?>" class="mdl-checkbox__input" name="<?php echo $item->slug;?>[]">
									<span class="mdl-checkbox__label"><?php echo $item->name;?></span>
								</label><?php
								}
							?></div><?php
						endforeach;
					endif;
					?><a href="#reset" class="a-d reset ribe-dark"><span class="ic close v1"></span>Сбросить фильтры</a>
				</div>
			</div>
			<div class="col s12 m8 l9 p0">
				<div class="wr-card">
					<div class="row"><?php
						if( is_array( $products ) && count( $products ) ){
							foreach( $products as $key=>$post){ setup_postdata($post);
								get_template_part( 'template/catalog', 'item' );
							}
						}else echo 'Каталог на данный период времени пуст!';
					?></div>
				</div>
			</div>
		</div>
	</div>
</section><?php
get_footer();