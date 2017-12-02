<?php
/*
* Template name: Страница Закладки
*/
if( isset($_GET['ajax'] ) ){
	if( !$_SESSION['bookmark'][$_GET['id']] ) $_SESSION['bookmark'][$_GET['id']] = $_GET['id'];
	else unset( $_SESSION['bookmark'][$_GET['id']] );
	var_dump($_SESSION);
	die();
}
service_page( !count( $_SESSION['bookmark'] ), '/catalog/' );

$posts = array();
if( count( $_SESSION['bookmark'] ) ){
	$posts = get_posts( array(
		'numberposts' =>-1,
		'post_type' => 'catalog',
		'post_status'=>'publish',
		'order'=>'ASC',
		'orderby'=>'meta_value_num',
		'post__in'=>array_values( array_flip( $_SESSION['bookmark'] ) )
	) );
}
$page_order = get_page_link( ot_get_option( 'kremlev_order_page_select' ) );

$total = 0;
get_header();
?><section class="section bookmark card-four-in-row">
	<div class="wr">
		<h1 class="title"><?php the_title();?></h1><?php
		if( count($posts) ):
			?><div class="wr-card">
				<div class="row"><?php
						foreach( $posts as $post): setup_postdata( $post );
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
							$total += kremlev_price($price,$spec_sale);
							?><div class="wr-item-card col s12 m4 l3 p0">
							<div class="item-card" data-id="<?php the_ID();?>"><?php
								?><div class="bl-notice"><?php
									if( $hit_on_off === 'on' ) echo '<div class="badget badget-hit">Хит продаж</div>';
									if( $sale ) echo '<div class="badget badget-sale">Скидка -'.$sale.'%</div>';
									if( $add_spec_price ) echo '<div class="timer" data-timer="'.$_SESSION['timer'].'"></div>';
								?></div><?php
								?><a href="<?php the_permalink();?>" class=" a-d img bg-contain" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>');"></a>
								<div class="bl-info">
									<div class="wr-title-card"><a href="<?php the_permalink();?>" class="title-card a-d"><?php the_title();?></a></div>
									<div class="price-card"><?php
										if( $sale ): ?><span class="oldprice"><?php echo kremlev_oldprice($price,$sale); ?> руб.</span><?php endif;
										if( $add_spec_price ): ?><span class="specprice"><?php echo $price; ?> руб.</span><?php endif;
										?> <span class="price"><?php echo kremlev_price($price,$spec_sale);?> руб.</span>
									</div>
								</div>
								<div class="bl-action"><a href="#bookmark" class="btni ic bookmark"><span class="like"></span></a><a href="#basket" class="btni ic basket"></a></div>
							</div>
						</div><?php
					endforeach;
				?></div>
			</div>
			<div class="form form-bookmark-order">
				<div class="bl-total row">
					<span class="name col p0 s6">Итого:</span>
					<span class="price col p0 s6"><?php echo $total;?> руб.</span>
				</div>
				<a href="<?php echo $page_order; ?>" class="btn btni order-bookmark">Оформить заказ</a>
			</div><?php
			wp_reset_postdata();
		endif;
	?></div>
</section><?php
get_footer();