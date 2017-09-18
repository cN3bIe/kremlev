<?php
/*
* Template name: Страница карточки товара
*/
$meta = new stdClass;
foreach( (array) get_post_meta( get_the_ID() ) as $k => $v ) $meta->$k = $v[0];
$meta->characteristics_list = get_post_meta( get_the_ID(),'characteristics_list',!0);
$meta->catalog_gallery = explode(',',$meta->catalog_gallery );
foreach( (array)$meta->catalog_gallery as $k=>$v ) $meta->catalog_gallery[$k] = wp_get_attachment_image_url( $v ,'full' );
array_unshift( $meta->catalog_gallery,get_the_post_thumbnail_url( get_the_ID(),'full') );

$meta->catalog_gallery_certificate_1 = isset( $meta->catalog_gallery_certificate_1 )?explode(',',$meta->catalog_gallery_certificate_1 ):!1;
$meta->catalog_gallery_certificate_2 = isset( $meta->catalog_gallery_certificate_2 )?explode(',',$meta->catalog_gallery_certificate_2 ):!1;

$hit_on_off = get_post_meta( get_the_ID(), 'hit_on_off', !0 );
$catalog_sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );

$spec_sale_on_off = get_post_meta( get_the_ID(), 'sale_on_off', !0 );
$spec_sale = 0;
$add_spec_price = !1;
if( $_SESSION['timer'] > time()*1000 && $spec_sale_on_off === 'on'){
	$spec_sale = 20;
	$add_spec_price = !0;
}

$terms = get_the_terms( get_the_ID(),'kremlev_filter' );
$fields = array();
if( is_array( $terms ) && count( $terms ) ):
	foreach( $terms as $key=>$term ):
		if( $term->parent !== 0 ){
			if( !isset( $fields[$term->parent]['children'] ) ) $fields[$term->parent]['children'] = array();
			array_push($fields[$term->parent]['children'], $term);
		}else $fields[$term->term_id]['parent'] = $term;
	endforeach;
endif;


$price = $meta->catalog_price;
$sale = isset( $meta->catalog_sale )?$meta->catalog_sale:0;


get_header();
?><section <?php post_class( 'section card item-card'); ?> id="post-<?php the_ID(); ?>">
	<div class="wr">
		<div class="main-info row" data-id="<?php the_ID();?>">
			<div class="col s12 m7 p0">
				<div class="bl-notice"><?php
					if( $hit_on_off === 'on' ) echo '<div class="badget badget-hit">Хит продаж</div>';
					if( $catalog_sale ) echo '<div class="badget badget-sale">Скидка -'.$catalog_sale.'%</div>';
					if( $add_spec_price ) echo '<div class="timer" data-timer="'.$_SESSION['timer'].'"></div>';
				?></div><?php
				if( count( $meta->catalog_gallery ) ):
					?><div class="bl-gallery fotorama"><?php
						foreach( $meta->catalog_gallery as $img){
							?><img class="item-img-gallery" src="<?php echo $img;?>" alt=""><?php
						}
					?></div><?php
				endif;
			?></div>
			<div class="col s12 m5 p0">
				<div class="bl-order">
					<div class="bl-bookmark">
						<a href="#bookmark" class="ic bookmark btni"><span class="like"></span></a>
						<div class="bl-close dn ribe-circle"><a href="#close" class="ic close v1"></a></div>
					</div>
					<h1 class="title-card"><?php the_title();?></h1><?php
					?><div class="name">Цена:</div><?php
					if( $sale ): ?><div class="oldprice"><?php echo kremlev_oldprice($price,$sale);?> руб.</div><?php endif;
					if( $add_spec_price ): ?><span class="specprice"><?php echo $price; ?> руб.</span><?php endif;
					?><div class="price"><?php echo kremlev_price($price,$spec_sale);?> руб.</div>
					<div class="name">Количество:</div>
					<div class="bl-count row">
						<div class="col s3 p0"><a href="#reduce" class="a-d reduce-count bl-brick ribe-light">-</a></div>
						<div class="col s6 p0"><div class="count bl-brick"><input type="text" class="fi-d" value="1"></div></div>
						<div class="col s3 p0"><a href="#enlerge" class="a-d enlarge-count bl-brick ribe-light">+</a></div>
					</div>
					<div class="wr-btn">
						<div id="add-basket" class="btn">Добавить в корзину</div>
						<div id="pay-one-click" class="btn v1">Купить в один клик</div><?php
						echo do_shortcode('[contact-form-7 id="551" title="Заказ в один клик"]');
						/*
						<div id="input-phone" class="wr-phone"><input type="text" class="fi-d phone" placeholder="Введите ваш телефон"></div>
						<button id="make-order" class="btn">Заказать товар</button>
						<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect bl-politic-conf dn" for="politic-conf">
							<input type="checkbox" id="politic-conf" class="mdl-checkbox__input" name="politic-conf" checked="checked">
							<span class="mdl-checkbox__label">Согласен(на) на обработку персональных данных (<a href="<?php echo get_page_link( ot_get_option( 'kremlev_politconf_page_select' ) );?>">соглашение</a>)</span>
						</label>
						*/
					?></div>
				</div>
				<div class="bl-share">
					<div class="title-share">Делитесь с друзьями:</div>
					<div class="ssk-group">
						<a href="" class="ssk ssk-icon ssk-facebook" data-ssk-ready="true"></a>
						<a href="" class="ssk ssk-icon ssk-twitter" data-ssk-ready="true"></a>
						<a href="" class="ssk ssk-icon ssk-google-plus" data-ssk-ready="true"></a>
						<a href="" class="ssk ssk-icon ssk-vk" data-ssk-ready="true"></a>
					</div>
				</div>
			</div>
		</div>
		<div class="more-detailed">
			<div class="wr-control-tab"><?php
				if( count( $meta->characteristics_list ) ) echo '<span class="item-control-tab active" data-tab="#description">Описание</span>';
				if(
					( is_array( $meta->catalog_gallery_certificate_1 ) && count( $meta->catalog_gallery_certificate_1 ) )
					||
					( is_array( $meta->catalog_gallery_certificate_2 ) && count( $meta->catalog_gallery_certificate_2 ) )
				) echo '<span class="item-control-tab" data-tab="#sertificat">Сертификаты</span>';
				?><span class="item-control-tab" data-tab="#delivery">Доставка</span>
			</div>
			<div class="wr-tabs"><?php
				if( count( $meta->characteristics_list ) || count( $fields ) ):
					?><div id="description" class="item-tab active">
						<div class="description">
							<ul class="ul-d"><?php
								if( is_array( $fields ) && count( $fields ) ):
									foreach( $fields as $field){
										$parent = $field['parent'];
										$str = array();
										foreach( $field['children'] as $key=>$item) {
											$str[] = $item->name;
										}
										echo '<li class="li-d"><span class="name">'.$parent->name.':</span> <span class="text">'.implode( ',', $str ).'</span></li>';
									}
								endif;
								if( is_array( $meta->characteristics_list ) && count( $meta->characteristics_list ) ):
									foreach( $meta->characteristics_list as $item){
										echo '<li class="li-d"><span class="name">'.$item['title'].':</span> <span class="text">'.$item['textarea_characteristics_list'].'</span></li>';
									}
								endif;
							?></ul>
						</div>
					</div><?php
				endif;
				if(
					( is_array( $meta->catalog_gallery_certificate_1 ) && count( $meta->catalog_gallery_certificate_1 ) )
					||
					( is_array( $meta->catalog_gallery_certificate_2 ) && count( $meta->catalog_gallery_certificate_2 ) )
				):
					?><div id="sertificat" class="item-tab">
						<div class="sertificat"><?php
							if( is_array( $meta->catalog_gallery_certificate_1 ) && count( $meta->catalog_gallery_certificate_1 ) ){
								?><div class="wr-sert v1 row"><?php
									foreach( $meta->catalog_gallery_certificate_1 as $img){
										?><div class="item-sert"><a href="<?php echo wp_get_attachment_image_url( $img, 'full' );?>" class="a-d img" style="background-image:url('<?php echo wp_get_attachment_image_url( $img, 'medium' );?>');" data-fancybox="catalog_gallery_certificate_1"></a></div><?php
									}
								?></div><?php
							}
							if( is_array( $meta->catalog_gallery_certificate_2 ) && count( $meta->catalog_gallery_certificate_2 ) ){
							?><div class="wr-sert v2 row"><?php
									foreach( $meta->catalog_gallery_certificate_2 as $img){
										?><div class="item-sert"><a href="<?php echo wp_get_attachment_image_url( $img, 'full' );?>" class="a-d img" style="background-image:url('<?php echo wp_get_attachment_image_url( $img, 'medium' );?>');" data-fancybox="catalog_gallery_certificate_2"></a></div><?php
									}
								?></div><?php
							}
						?></div>
					</div><?php
				endif;
				?><div id="delivery" class="item-tab"><?php
					get_template_part( 'template/delivery' );
				?></div>
			</div>
		</div>
	</div>
</section><!-- #post-<?php the_ID(); ?> --><?php
get_template_part( 'template/catalog', 'recomend' );
get_footer();