<?php
/*
* Template name: Шаблон карточки товара в архви
*/
$hit_on_off = get_post_meta( get_the_ID(), 'hit_on_off', !0 );
$catalog_sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );
$price = get_post_meta( get_the_ID(), 'catalog_price', !0 );
$sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );
?><div class="wr-item-card col p0">
	<div class="item-card">
		<div class="bl-notice"></div>
		<a href="<?php the_permalink();?>" class=" a-d img bg-contain" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>');"></a>
		<div class="bl-info">
			<div class="wr-title-card">
				<a href="<?php the_permalink();?>" class="title-card a-d"><?php the_title();?></a>
			</div>
			<div class="price-card">
				<span class="price"><?php echo $price; ?> руб.</span><?php
				if($sale): ?> <span class="old-price"><?php echo kremlev_oldprice($price,$sale); ?> руб.</span><?php endif;
			?></div>
		</div>
	</div>
</div>