<?php
/*
* Template name: Страница оформления заказа
*/
if( isset($_GET['ajax'] ) ){
	if( isset( $_GET['del'] ) ) unset( $_SESSION['basket'][$_GET['id']] );
	else $_SESSION['basket'][$_GET['id']] = $_GET['count'];
	if( !count( $_SESSION['basket']) ) unset( $_SESSION['basket'] );
	var_dump($_SESSION);
	die();
}
$posts = null;
if( isset( $_SESSION['basket'] ) && count( $_SESSION['basket'] ) ) $posts = get_posts( array(
	'numberposts' =>-1,
	'post_type' => 'catalog',
	'post_status'=>'publish',
	'order'=>'ASC',
	'orderby'=>'meta_value_num',
	'post__in'=>array_keys( $_SESSION['basket'] )
) );
$city_string = isset($_GET['city_delivery'])?$_GET['city_delivery']:$_SESSION['city'];
$citys =  get_posts( array(
	'numberposts' =>1,
	'name' => $city_string,
	'post_type' => 'kremlev_city',
	'post_status'=>'publish',
	'order' => 'ASC',
	'orderby' => 'meta_value_num'
) );
if( is_array( $citys ) && count( $citys ) ){
	$city = array_shift($citys);
	$list_item_delivery = get_post_meta( $city->ID, 'delivery_list', !0 );
	$pickup_on_off =  get_post_meta( $city->ID, 'pickup_on_off', !0 );
	$pickup_address =  get_post_meta( $city->ID, 'pickup_address', !0 );
}else{
	$list_item_delivery = ot_get_option( 'op_delivery_list' );
	$pickup_on_off =  ot_get_option( 'op_pickup_on_off' );
	$pickup_address =  ot_get_option( 'op_pickup_address' );
}
$pickup_time =  ot_get_option( 'time_work' );
$total = 0;
$sale_total = 0;
$delivery = 0;
$delivery_min_price_free = 0;
if( isset($_GET['city_delivery']) && $_GET['city_delivery'] ):
	?><div class="wr-delivery"><?php
		if( is_array( $list_item_delivery ) && count( $list_item_delivery ) ):
			foreach( $list_item_delivery as $key=>$item ):
				?><label class="mdl-radio mdl-js-radio mdl-js-ripple-effect radio-delivery" for="delivery-<?php echo $key;?>" data-price="<?php echo $item['price_delivery_list'];?>" data-free="<?php echo $item['free_delivery_list'];?>">
					<input type="radio" id="delivery-<?php echo $key;?>" class="mdl-radio__button" name="delivery" value="<?php echo $item['title'];?>" <?php echo !$key?'checked':'';?>>
					<span class="mdl-radio__label"><?php echo $item['title'];?> <span class="time"><?php echo $item['time_delivery_list'];?></span></span>
				</label><?php
			endforeach;
		endif;
		if( $pickup_on_off === 'on' ):
			?><label class="delivery-pickup mdl-radio mdl-js-radio mdl-js-ripple-effect radio-delivery" for="delivery-pickup" data-price="0" data-free="0">
				<input type="radio" id="delivery-pickup" class="mdl-radio__button" name="delivery" value="Самовывоз">
				<span class="mdl-radio__label">Самовывоз <?php echo ot_get_option( 'main_address' );?> <span class="time"><?php echo $pickup_time;?></span></span>
			</label><?php
		endif;
	?></div><?php
	exit();
endif;
get_header();
?><section class="section order">
	<div class="wr">
		<h1 class="title"><?php the_title();?></h1>
		<div class="wr-order">
			<form action="" class="form form-order row" method="post">
				<div class="wr-info wr-info-client col s12 m6">
					<div class="bl-info row">
						<div class="number bl-brick">1</div>
						<div class="info">
							<div class="bl-city">
								Город доставки: <span id="city_delivery" class="select city"><?php echo (isset( $_SESSION['city'] )?$_SESSION['city']:'Санкт-Петербург');?></span>
								<div class="bl-search-city"><div class="wr-fi"><input type="text" class="fi-d" placeholder="Поиск города"></div></div>
							</div>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">2</div>
						<div class="info">
							<div class="title-info">Контактная информация:</div>
							<div class="form-input"><input class="fi-d name" type="text" name="name" placeholder="Ваше имя"></div>
							<div class="form-input"><input class="fi-d phone" type="text" name="phone" placeholder="Ваш телефон"></div>
							<div class="form-input"><input class="fi-d email" type="text" name="email" placeholder="Ваш E-mail"></div>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">3</div>
						<div class="info">
							<div class="title-info">Выберите способ доставки:</div>
							<div class="wr-delivery"><?php
								if( is_array( $list_item_delivery ) && count( $list_item_delivery ) ):
									foreach( $list_item_delivery as $key=>$item ):
										?><label class="mdl-radio mdl-js-radio mdl-js-ripple-effect radio-delivery" for="delivery-<?php echo $key;?>" data-price="<?php echo $item['price_delivery_list'];?>" data-free="<?php echo $item['free_delivery_list'];?>">
											<input type="radio" id="delivery-<?php echo $key;?>" class="mdl-radio__button" name="delivery" value="<?php echo $item['title'];?>" <?php echo !$key?'checked':'';?>>
											<span class="mdl-radio__label"><?php echo $item['title'];?> <span class="time"><?php echo $item['time_delivery_list'];?></span></span>
										</label><?php
										if( !$key ){
											$delivery = $item['price_delivery_list'];
											$delivery_min_price_free = ceil( $item['free_delivery_list'] );
										}
									endforeach;
								endif;
								if( $pickup_on_off === 'on' ):
									?><label class="delivery-pickup mdl-radio mdl-js-radio mdl-js-ripple-effect radio-delivery" for="delivery-pickup" data-price="0" data-free="0">
										<input type="radio" id="delivery-pickup" class="mdl-radio__button" name="delivery" value="Самовывоз">
										<span class="mdl-radio__label">Самовывоз <?php echo ot_get_option( 'main_address' );?><span class="time"><?php echo $pickup_time;?></span></span>
									</label><?php

								endif;
							?></div>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">4</div>
						<div class="info">
							<div class="title-info">Адрес доставки:</div>
							<textarea class="form-textarea" placeholder="Укажите улицу, дом, корпус, квартиру"></textarea>
							<div class="wr-maps dn"><?php
								echo '<div class="text">'.ot_get_option( 'main_address' ).'</div>';
								echo ot_get_option( 'maps_textarea' );
							?></div>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">5</div>
						<div class="info">
							<div class="title-info">Выберите способ оплаты:</div>
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="pay-1">
								<input type="radio" id="pay-1" class="mdl-radio__button" name="pay" value="1" checked="checked">
								<span class="mdl-radio__label">Наличными при получении</span>
							</label>
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="pay-2">
								<input type="radio" id="pay-2" class="mdl-radio__button" name="pay" value="2">
								<span class="mdl-radio__label">Банковской картой при получении</span>
							</label>
							<div class="wr-bank"><span class="ic visa"></span><span class="ic mastercard"></span><span class="ic mir"></span></div>
						</div>
					</div>
					<button type="submit" class="btn">Оформить заказ</button>
				</div>
				<div class="wr-info wr-info-order col s12 m6 bl-card"><?php
					if( is_array( $posts ) && count( $posts ) ){
						foreach( $posts as $post){ setup_postdata( $post );
							$hit_on_off = get_post_meta( get_the_ID(), 'hit_on_off', !0 );
							$oldprice = get_post_meta( get_the_ID(), 'catalog_price', !0 );
							$sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );

							$sale_price = $sale?( $oldprice * $sale / 100):0;
							$price = ( $sale?ceil($oldprice - $sale_price):$oldprice );
							$total += $price ? $price * $_SESSION['basket'][get_the_ID()] : 0;
							$sale_total += $sale_price;
							?><div class="item-card row" id="<?php the_ID();?>">
								<input class="sale" type="hidden" value="<?php echo ($sale_price?$sale_price:0);?>">
								<a href="#del" class="a-d ribe bl-del ic close v1"></a>
								<div class="bl-del-select row dn">
									<div class="bl-bookmark col s6 p0">
										<a href="#" class="del-in-bookmark dn"><div class="ic bookmark v1 active"></div>Находится<br>в списке желаний</a>
										<a href="#" class="add-in-bookmark dn"><div class="ic bookmark v1"></div>Переместить<br>в список желаний</a>
									</div>
									<a href="#" class="col s6 del close v1 p0"><div class="ic close v2"></div>Удалить<br>без сохранения</a>
									<a href="#" class="col s12 cancel p0">Отмена</a>
								</div>
								<div class="card-info row">
									<div class="col s12 m6 l3 p0">
										<a href="<?php the_permalink();?>" class="a-d img bg-contain" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>')"></a>
									</div>
									<div class="col s12 m6 l9 p0"><div class="title-card"><?php the_title();?></div></div>
									<div class="col s12 l9 p0">
										<div class="col s12 m6 p0">
											<div class="price-card"><?php
												echo $price.' руб.';
											?></div>
										</div>
										<div class="col s12 m6 bl-count p0">
											<a href="#reduce" class="a-d reduce-count bl-brick">-</a>
											<div class="count bl-brick"><input type="text" class="fi-d" value="<?php echo $_SESSION['basket'][get_the_ID()];?>"></div>
											<a href="#enlerge" class="a-d enlarge-count bl-brick">+</a>
										</div><?php
										if($sale_price):
											?><div class="col s12 m6 p0" style="clear: both;">
												<div class="oldprice-card"><?php echo $oldprice; ?> руб.</div>
											</div><?php
										endif;
									?></div>
								</div>
							</div><?php
						}
						wp_reset_postdata();
					}
					?><div class="total">
						<div class="bl-info sale row">
							<div class="name">Скидка</div>
							<div class="price"><?php echo $sale_total;?> руб.</div>
						</div>
						<div class="bl-info delivery row">
							<div class="name">Стоимость доставки:</div>
							<div class="price"><?php echo ( $delivery_min_price_free > $total ?$delivery:0);?> руб.</div>
						</div>
						<div class="bl-info bl-total row">
							<div class="name">Итого:</div>
							<div class="price"><?php echo ( $delivery_min_price_free > $total ?( $total + $delivery ):$total );?> руб.</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section><?php
get_footer();