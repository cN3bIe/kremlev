<?php
$citys = get_posts( array(
	'numberposts' =>-1,
	'post_type' => 'kremlev_city',
	'post_status'=>'publish',
	'order' => 'ASC',
	'orderby' => 'meta_value_num',
) );
?><div class="delivery">
	<div class="wr-dev row">
		<div class="col p0 s12 m3">
			<div class="item-dev">
				<div class="img" style="background-image:url('<?php echo get_template_directory_uri();?>/img/design/car.svg')"></div>
				<div class="name">Завод</div>
				<div class="text">Произведённая икра погружается в специальный рефрижератор</div>
			</div>
		</div>
		<div class="col p0 s12 m3">
			<div class="item-dev">
				<div class="img" style="background-image:url('<?php echo get_template_directory_uri();?>/img/design/marker.svg')"></div>
				<div class="name">Транспортировка</div>
				<div class="text">Икра доставляется<span class="br"></span>в Москву.</div>
			</div>
		</div>
		<div class="col p0 s12 m3">
			<div class="item-dev">
				<div class="img" style="background-image:url('<?php echo get_template_directory_uri();?>/img/design/bag.svg')"></div>
				<div class="name">Офис продаж</div>
				<div class="text">Икра хранится в специальных холодильниках, это позволяет ей не портиться</div>
			</div>
		</div>
		<div class="col p0 s12 m3">
			<div class="item-dev">
				<div class="img" style="background-image:url('<?php echo get_template_directory_uri();?>/img/design/star.svg')"></div>
				<div class="name">Покупатель</div>
				<div class="text">Доставка покупателю осуществляется в специальных термоконтейнерах</div>
			</div>
		</div>
	</div>
	<div class="bl-text">
		<div class="title-text before">Способы доставки</div>
		<p class="text">Икра относится к скоропортящимся продуктам, поэтому условиям доставки мы уделяем особое внимание. С производства икра на рефрижераторах доставляется в Московский офис продаж, где хранится в специальных холодильниках. Курьер производит доставку продукции с использованием специального переносного холодильника. Поэтому икра поступает к вам свежей, а главное — сохранившей настоящий вкус Русской икры.</p>
		<ul class="ul-d list-dev"><?php
			if( is_array( $citys ) && count( $citys ) ):
				foreach( $citys as $city ):
					$list_item_delivery = get_post_meta( $city->ID, 'delivery_list', !0 );
					if( is_array( $list_item_delivery ) && count( $list_item_delivery ) ){
						foreach( $list_item_delivery as $key=>$item ){
							?><li class="li-d item-dev">
								<div class="line-1">
									<?php echo $item['title'];?> — <span class="b"><?php echo $item['price_delivery_list'];?> руб.</span> <?php echo $item['time_delivery_list'];?>.
								</div>
								<div class="line-2">— При заказе от <?php echo $item['free_delivery_list'];?> руб. <span class="b">бесплатно</span></div>
							</li><?php
						}
					}
				endforeach;
			endif;?>
		</ul>
		<div class="title-text before">Условия доставки</div>
		<ul class="ul-d list-time">
			<li class="li-d item-time">Время осуществления доставки <span class="b">с 09:00 до 21:00 часов.</span></li>
			<li class="li-d item-time">Доставка осуществляется в срок <span class="b">от 3 часов до 1 дня.</span></li>
			<li class="li-d item-time">Срочная доставка оплачивается <span class="b">по двойному тарифу.</span></li>
		</ul>
		<div class="title-text before">Самовывоз</div>
		<p class="text">Вы можете забрать заказ прямо из нашего офиса, расположенного по адресу — Москва, Огородный проезд, дом 18.</p>
		<a href="#maps" class="a-d clickSlide">Посмотреть на карте</a>
		<div id="maps" class="dn">
			<div class="text"><?php echo ot_get_option( 'main_address' );?></div><?php
			echo ot_get_option( 'maps_textarea' );
		?></div>
		<div class="title-text before collaborate">
			<?php if(ot_get_option( 'main_phone' )):?><a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="a-d">По вопросам сотрудничества звоните:<br><?php echo ot_get_option( 'main_phone' );?></a><?php endif;?>
		</div>
	</div>
</div>