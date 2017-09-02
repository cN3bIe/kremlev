<?php
$cur_term = get_queried_object();
$name_filter = types_render_termmeta( 'category-name-filters', array( 'term_id'=> ( $cur_term->parent?$cur_term->parent:$cur_term->term_id ) ) );
$SEO_text = types_render_termmeta( 'opisanie-dlya-seo', array( 'term_id'=>$cur_term->term_id) );
$terms = get_terms( array(
	'taxonomy'=>$cur_term->taxonomy,
	'parent'=>($cur_term->parent?$cur_term->parent:$cur_term->term_id),
) );
$arr_terms_id = array();
foreach($terms as $term) $arr_terms_id[]= $term->term_id;
$products = get_posts( array(
	'numberposts' =>-1,
	'post_type' => 'catalog',
	'post_status'=>'publish',
	'order'=>'ASC',
	'orderby'=>'meta_value_num',
	'tax_query'         => array(
		array(
			'taxonomy' => 'kremlev_category',
			'terms'    => $arr_terms_id,
		),
	),
) );
$filter_terms = get_terms('kremlev_filter',array('parent'=>0));
$filters = array();
if( is_array( $filter_terms ) && count( $filter_terms ) ):
	foreach( $filter_terms as $key=>$term ):
		$posts = get_posts( array(
			'numberposts' =>-1,
			'post_type' => 'catalog',
			'post_status'=>'publish',
			'order' => 'ASC',
			'orderby' => 'meta_value_num',
			'tax_query' => array(
				'relation'=>'AND',
				array(
					'taxonomy' => 'kremlev_category',
					'terms'    => $arr_terms_id,
				),
				array(
					'taxonomy' => 'kremlev_filter',
					'terms'    => $term,
				),
			)
		) );
		if( count( $posts ) ) array_push( $filters, array( 'parent' => $term, 'children'=>null ) );
	endforeach;
endif;
if( is_array( $filters ) && count( $filters ) ):
	foreach( $filters as $key=>$parent_term ):
		$filters[$key]['children'] = get_terms('kremlev_filter',array('parent'=>$parent_term['parent']->term_id));
	endforeach;
endif;
get_header();
?><section class="section catalog catalog-page">
	<div class="wr">
		<h1 class="title"><?php echo $cur_term->name;?></h1>
		<div class="wr-catalog row">
			<div class="wr-filter col s12 m4 l3 p0">
				<div class="form-filter">
					<div class="bl-filter" data-filter-group="filter-0" data-filter-lvl="0">
						<div class="title-filter"><?php echo ($name_filter?$name_filter:'Категории');?></div><?php
						foreach($terms as $key=>$term){
							?><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?php echo $term->term_id;?>" data-filter=".filter-<?php echo $term->slug;?>">
								<input type="checkbox" id="<?php echo $term->term_id;?>" class="mdl-checkbox__input" name="kremlev_category[]" <?php if( $cur_term->term_id === $term->term_id ) echo 'checked="checked"';?>>
								<span class="mdl-checkbox__label"><?php echo $term->name;?></span>
							</label><?php
						}
					?></div><?php
					if( is_array( $filters ) && count( $filters ) ):
						foreach( $filters as $key => $filter ):
							$parent = $filter['parent'];
							?><div class="bl-filter" data-filter-group="filter-<?php echo $key;?>" data-filter-lvl="<?php echo $key+1;?>">
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
					/*?><button type="submit" class="btn">Показать</button><?php*/
					?><a href="/catalog/" class="a-d reset"><span class="ic close v1"></span>Сбросить фильтры</a><?php /*
					<div class="filter-popup zd-4">
						<div class="bl-empty">Нечего не найдено</div>
						<div class="bl-count">Найдено: 4</div>
						<button type="submit" class="btn">Показать</button>
					</div><?php */
				?></div>
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
if( $SEO_text ):
	?><section class="section bl-text">
		<div class="wr">
			<h1 class="title"><?php echo $cur_term->name;?></h1>
			<div class="text"><?php echo $SEO_text;?></div>
		</div>
	</section><?php
endif;
get_footer();