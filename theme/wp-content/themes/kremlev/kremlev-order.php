<?php
/*
* Template name: Страница оформления заказа
*/
if( isset($_GET['ajax'] ) ){
	if( isset( $_GET['del'] ) ) unset( $_SESSION['basket'][$_GET['id']] );
	else $_SESSION['basket'][$_GET['id']] = $_GET['count'];
	if( isset( $_GET['clear_basket'] ) ){
		unset( $_SESSION['basket'] );
	}
	if( isset( $_GET['timer'] ) ){
		$_SESSION['timer'] = ( time() + 600 ) * 1000;
		echo $_SESSION['timer'];
		die();
	}
	if( !count( $_SESSION['basket']) ) unset( $_SESSION['basket'] );
	var_dump($_SESSION);
	die();
}
service_page( !count( $_SESSION['basket'] ), '/catalog/' );

$posts = null;
if( isset( $_SESSION['basket'] ) && count( $_SESSION['basket'] ) ) $posts = get_posts( [
	'numberposts' =>-1,
	'post_type' => 'catalog',
	'post_status'=>'publish',
	'order'=>'ASC',
	'orderby'=>'meta_value_num',
	'post__in'=>array_keys( $_SESSION['basket'] )
] );

if( isset($_GET['city_delivery']) ) $_SESSION['city_delivery'] = $_GET['city_delivery'];

$city_string = isset($_GET['city_delivery'])?$_GET['city_delivery']:$_SESSION['city_delivery'];

$citys =  get_posts( [
	'numberposts' =>1,
	'name' => $city_string,
	'post_type' => 'kremlev_city',
	'post_status'=>'publish',
	'order' => 'ASC',
	'orderby' => 'meta_value_num'
] );

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
	$_SESSION['city_delivery'] = $_GET['city_delivery'];
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
			<div class="form form-order row">
				<div class="wr-info wr-info-order col s12 m6 bl-card"><?php
					if( is_array( $posts ) && count( $posts ) ){
						foreach( $posts as $post){ setup_postdata( $post );
							$hit_on_off = get_post_meta( get_the_ID(), 'hit_on_off', !0 );
							$price = get_post_meta( get_the_ID(), 'catalog_price', !0 );
							$sale = get_post_meta( get_the_ID(), 'catalog_sale', !0 );
							$count = $_SESSION['basket'][get_the_ID()];

							$spec_sale_on_off = get_post_meta( get_the_ID(), 'sale_on_off', !0 );
							$spec_sale = 0;
							$add_spec_price = !1;
							if( $_SESSION['timer'] > time()*1000 && $spec_sale_on_off === 'on'){
								$spec_sale = 20;
								$add_spec_price = !0;
							}

							$oldprice = kremlev_oldprice($price,$sale);
							$specprice = $price;
							$price = kremlev_price( $specprice,$spec_sale );

							$sale_price = $sale?ceil( $oldprice - $price):0;
							$total += $price;
							$sale_total += $sale_price * $count;
							?><div class="item-card row" id="<?php the_ID();?>"><?php
								if( $add_spec_price ) echo '<div class="timer" data-timer="'.$_SESSION['timer'].'"></div>';
								?><input class="sale" type="hidden" value="<?php echo ($sale_price?$sale_price:0);?>">
								<a href="#del" class="a-d ribe bl-del ic close v1"></a>
								<div class="bl-del-select row dn">
									<div class="bl-bookmark col s6 p0">
										<a href="#" class="del-in-bookmark dn"><div class="ic bookmark v1 active"></div>Находится<br>в списке желаний</a>
										<a href="#" class="add-in-bookmark dn"><div class="ic bookmark v1"><span class="like"></span></div>Переместить<br>в список желаний</a>
									</div>
									<a href="#" class="col s6 del close v1 p0 link-catalog"><div class="ic close v2"></div>Удалить<br>без сохранения</a>
									<a href="#" class="col s12 cancel p0 link-catalog">Отмена</a>
								</div>
								<div class="card-info row">
									<div class="col s12 m6 l3 p0">
										<a href="<?php the_permalink();?>" class="a-d img bg-contain" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>')"></a>
									</div>
									<div class="col s12 m6 l9 p0 title-card"><?php the_title();?></div>
									<div class="col s12 l9 p0">
										<div class="col s12 m6 p0">
											<div class="price-card"><?php echo $price;?> руб.</div>
										</div>
										<div class="col s12 m6 bl-count p0">
											<button class="reduce-count bl-brick ribe-light">-</button>
											<div class="count bl-brick"><input type="text" class="fi-d" value="<?php echo $count;?>"></div>
											<button class="enlarge-count bl-brick ribe-light">+</button>
										</div><?php
										if($sale_price):
											?><div class="col s12 m6 p0" style="clear: both;">
												<div class="oldprice-card"><?php echo $oldprice; ?> руб.</div>
											</div><?php
										endif;
										if($add_spec_price):
											?><div class="col s12 m6 p0">
												<div class="specprice-card"><?php echo $specprice; ?> руб.</div>
											</div><?php
										endif;
									?></div>
								</div>
							</div><?php
						}
						wp_reset_postdata();
					}
					if( is_array( $list_item_delivery ) && count( $list_item_delivery ) ):
						$item = $list_item_delivery[0];
						$delivery = $item['price_delivery_list'];
						$delivery_min_price_free = ceil( $item['free_delivery_list'] );
					endif;
					$delivery = $delivery_min_price_free > $total ?$delivery:0;
					?><div class="total">
						<div class="bl-info sale row">
							<div class="name">Скидка</div>
							<div class="price"><?php echo $sale_total;?> руб.</div>
						</div>
						<div class="bl-info delivery row">
							<div class="name">Стоимость доставки:</div>
							<div class="price"><?php echo $delivery;?> руб.</div>
						</div>
						<div class="bl-info bl-total row">
							<div class="name">Итого:</div>
							<div class="price"><?php echo ($total + $delivery);?> руб.</div>
						</div>
					</div>
				</div>
				<div class="wr-info wr-info-client col s12 m6">
					<div class="bl-info row">
						<div class="number bl-brick">1</div>
						<div class="info">
							<div class="bl-city">
								Город доставки: <span id="city_delivery" class="select city"><?php echo isset($_SESSION['city_delivery'])?$_SESSION['city_delivery']:'Санкт-Петербург';?></span>
								<div class="bl-search-city">
									<div class="wr-fi">
										<input type="text" class="fi-d" placeholder="Поиск города">
									</div>
									<ul class="ul-d list-city dn">
										<li class="li-d item-city">Москва</li>
										<li class="li-d item-city">Санкт-Петербург</li>
										<li class="li-d item-city">Новосибирск</li>
										<li class="li-d item-city">Екатеринбург</li>
										<li class="li-d item-city">Нижний Новгород</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">2</div>
						<div class="info">
							<div class="title-info">Контактная информация:</div><?php
								echo do_shortcode('[contact-form-7 id="555" title="Заказ" html_id="bl-order-card" html_class="form"]');
							/*<div class="form-input"><input class="fi-d name" type="text" name="name" placeholder="Ваше имя"></div>
							<div class="form-input"><input class="fi-d phone" type="text" name="phone" placeholder="Ваш телефон"></div>
							<div class="form-input"><input class="fi-d email" type="text" name="email" placeholder="Ваш E-mail"></div>
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect bl-politic-conf" for="politic-conf">
								<input type="checkbox" id="politic-conf" class="mdl-checkbox__input" name="politic-conf" checked="checked">
								<span class="mdl-checkbox__label">Согласен(на) на обработку персональных данных (<a href="<?php echo get_page_link( ot_get_option( 'kremlev_politconf_page_select' ) );?>">соглашение</a>)</span>
							</label>*/
						?></div>
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
					<div class="bl-info row bl-pay">
						<div class="number bl-brick">5</div>
						<div class="info">
							<div class="title-info">Выберите способ оплаты:</div>
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="pay-1">
								<input type="radio" id="pay-1" class="mdl-radio__button" name="pay" value="Наличными при получении" checked="checked">
								<span class="mdl-radio__label">Наличными при получении</span>
							</label>
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="pay-2">
								<input type="radio" id="pay-2" class="mdl-radio__button" name="pay" value="Безналичный банковский перевод">
								<span class="mdl-radio__label">Безналичный банковский перевод</span>
							</label>
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="pay-3">
								<input type="radio" id="pay-3" class="mdl-radio__button" name="pay" value="Банковской картой при получении">
								<span class="mdl-radio__label">Банковской картой при получении</span>
							</label>
							<div class="wr-bank"><span class="ic visa"></span><span class="ic mastercard"></span><span class="ic mir"></span></div>
						</div>
					</div>
					<button type="submit" class="btn" id="btni-order-card">Оформить заказ</button>
				</div>
			</div>
		</div>
	</div>
</section><?php
get_footer();