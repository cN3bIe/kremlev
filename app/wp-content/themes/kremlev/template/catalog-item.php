<?php
/*
* Template name: Шаблон карточки товара в архви
*/
$hit_on_off = get_post_meta( get_the_ID(), 'hit_on_off', !0 );
$sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );
$spec_sale_on_off = get_post_meta( get_the_ID(), 'sale_on_off', !0 );
$spec_sale = 0;
$add_spec_price = !1;
if( $_SESSION['timer'] > time()*1000 && $spec_sale_on_off === 'on'){
	$spec_sale = 20;
	$add_spec_price = !0;
}
$price = get_post_meta( get_the_ID(), 'catalog_price', !0 );
$category = wp_get_object_terms( get_the_ID(), array( 'kremlev_category','kremlev_filter' ) );
$filter = array();

if( count( $category ) ) foreach($category as $key=>$item) $filter[] = 'filter-'.$item->slug;

?><div class="transfer wr-item-card col s12 m6 l4 p0 <?php if( count($filter) ) echo implode(' ',$filter); ?>">
<div class="item-card ribe-light" data-id="<?php the_ID();?>" data-cpec="<?php echo $spec_sale_on_off;?>">
	<div class="bl-notice"><?php
		if( $hit_on_off === 'on' ) echo '<div class="badget badget-hit">Хит продаж</div>';
		if( $sale ) echo '<div class="badget badget-sale">Скидка<br>-'.$sale.'%</div>';
		if( $add_spec_price ) echo '<div class="timer" data-timer="'.$_SESSION['timer'].'"></div>';
		?></div>
		<a href="<?php the_permalink();?>" class=" a-d img bg-contain" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>');"></a>
		<div class="bl-info">
			<div class="wr-title-card">
				<a href="<?php the_permalink();?>" class="title-card a-d"><?php the_title();?></a>
			</div>
			<div class="price-card"><?php
				if( $sale ): ?><span class="oldprice"><?php echo kremlev_oldprice($price,$sale); ?> руб.</span><?php endif;
				if( $add_spec_price ): ?><span class="specprice"><?php echo $price; ?> руб.</span><?php endif;
				?> <span class="price"><?php echo kremlev_price($price,$spec_sale).' руб.';?></span>
			</div>
		</div>
		<div class="bl-action"><a href="#bookmark" class="btni ic bookmark"><span class="like"></span></a><a href="#basket" class="btni ic basket"></a></div>
	</div>
</div>