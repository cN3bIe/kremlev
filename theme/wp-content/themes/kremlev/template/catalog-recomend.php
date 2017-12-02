<?php
/*
* Template name: Шаблон блока Рекомендуемые товары
*/
$card_recomend = get_posts( array(
	'numberposts'=>4,
	'post_type'=>'catalog',
	'exclude' => get_the_ID(),
	'meta_query' => array(
		'relation'=>'OR',
		array(
			'key' => 'recoment_on_off',
			'value' => 'on',
		),
	),
) );
if( count( $card_recomend ) ):
	?><section class="section catalog catalog-page recomend card-four-in-row">
		<div class="wr">
			<h3 class="title">Рекомендуем попробовать</h3>
			<div class="wr-catalog">
				<div class="wr-card row"><?php
					foreach( $card_recomend as $post){ setup_postdata( $post );
						get_template_part( 'template/catalog', 'item-four' );
					}
				?></div>
			</div>
		</div>
	</section><?php
	wp_reset_postdata();
endif;