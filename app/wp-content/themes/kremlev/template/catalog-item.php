<?php
/*
* Template name: Шаблон карточки товара в архви
*/
$hit_on_off = get_post_meta( get_the_ID(), 'hit_on_off', !0 );
$catalog_sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );
$price = get_post_meta( get_the_ID(), 'catalog_price', !0 );
$oldprice = get_post_meta( get_the_ID(), 'catalog_oldprice', !0 );
$category = wp_get_object_terms( get_the_ID(), array( 'kremlev_category','kremlev_filter' ) );
$filter = array();

if( count( $category ) ) foreach($category as $key=>$item) $filter[] = 'filter-'.$item->slug;

?><div class="transfer wr-item-card col s12 m6 l4 p0 <?php if( count($filter) ) echo implode(' ',$filter); ?>">
<div class="item-card" data-id="<?php the_ID();?>">
	<div class="bl-notice"><?php
		if( $hit_on_off === 'on' ) echo '<div class="badget badget-hit">Хит продаж</div>';
		if( $catalog_sale ) echo '<div class="badget badget-sale">Скидка -'.$catalog_sale.'%</div>';
		?></div>
		<a href="<?php the_permalink();?>" class=" a-d img bg-contain" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>');"></a>
		<div class="bl-info">
			<div class="wr-title-card">
				<a href="<?php the_permalink();?>" class="title-card a-d"><?php the_title();?></a>
			</div>
			<div class="price-card"><?php
				if($catalog_sale):
					?><span class="old-price"><?php echo $price; ?> руб.</span><?php
				endif;
				?> <span class="price"><?php
				echo $price?ceil($price - $price*$catalog_sale/100).' руб.':$price;
				?></span>
			</div>
		</div>
		<div class="bl-action"><a href="#bookmark" class="btni ic bookmark"><span class="like"></span></a><a href="#basket" class="btni ic basket"></a></div>
	</div>
</div>