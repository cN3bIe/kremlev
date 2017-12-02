<?php
 /*
 * Template name: Страница "Спасибо"
 */
$card_sale = get_posts( [
	'numberposts'=>-1,
	'post_type'=>'catalog',
	'meta_query' => [[
		'key' => 'sale_on_off',
		'value' => 'on',
	]]
] );
get_header();
if( !isset( $_GET['reviews'] ) ):
	?><section class="section thanks">
		<div class="wr">
			<h1 class="title">Спасибо за вашу заявку!</h1><?php
			if( !isset( $_GET['promocode'] ) ){
				?><div class="text">Наш менеджер свяжется с вами в течение 30 минут,<span class="br"></span>чтобы подтвердить ваш заказ</div><?php
			}else{
				?><div class="text">Промо-код отправлен на ваш e-mail</div><?php
			}
		?></div>
	</section><?php
else:
	?><section class="section thanks">
		<div class="wr">
			<h1 class="title">Спасибо за ваш отзыв!</h1>
		</div>
	</section><?php
endif;
if( !isset( $_GET['promocode'] ) && !isset( $_GET['reviews'] ) ):
	?><section class="section specsale catalog">
		<div class="wr">
			<h2 class="title">Специально для вас товар с дополнительной скидкой 20%</h2>
			<div class="text">Предложение действительно в течение 10 минут</div>
			<div class="timer" data-timer="<?php echo $_SESSION['timer']; ?>"></div>
			<div class="wr-card">
				<div class="row"><?php
				foreach( $card_sale as $post){ setup_postdata( $post );
					get_template_part( 'template/catalog', 'item-four' );
				}
				wp_reset_postdata();
			?></div>
			</div>
		</div>
	</section><?php
endif;
get_footer();