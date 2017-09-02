<?php
/*
* Template name: Шаблон карточки товара в архви
*/
die('Обратитесь к вебразработчику.');
/*
$hit_on_off = get_post_meta( get_the_ID(), 'hit_on_off', !0 );
$catalog_sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );
$price = get_post_meta( get_the_ID(), 'catalog_price', !0 );
$oldprice = get_post_meta( get_the_ID(), 'catalog_oldprice', !0 );
?><div class="item-card row" data-id="<?php the_ID();?>">
	<a href="#del" class="a-d ribe bl-del ic close"></a>
	<div class="img bg-contain" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>')"></div>
	<div class="card-info">
		<div class="title-card"><?php the_title();?></div>
		<div class="price-card">
			<span class="price"><?php
				echo ($price?ceil($price - $price*$catalog_sale/100).' руб.':$price);
			?></span><?php
			if($catalog_sale):
				?><span class="old-price"><?php echo $price; ?> руб.</span><?php
			endif;
		?></div>
		<div class="bl-count">
			<a href="#reduce" class="a-d reduce-count bl-brick">-</a>
			<div class="count bl-brick"><input type="text" class="fi-d" value="1"></div>
			<a href="#enlerge" class="a-d enlarge-count bl-brick">+</a>
		</div>
	</div>
</div>
*/