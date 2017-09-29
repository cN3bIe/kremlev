<?php
$citys = get_posts( array(
	'numberposts' =>-1,
	'post_type' => 'kremlev_city',
	'post_status'=>'publish',
	'order' => 'ASC',
	'orderby' => 'meta_value_num',
) );

$delivery = [
	'factory'=>
	[
		'title'=>'Завод',
		'img'=>get_template_directory_uri().'/img/design/car.svg',
		'text'=>''
	],
	'transportation'=>
	[
		'title'=>'Транспортировка',
		'img'=>get_template_directory_uri().'/img/design/marker.svg',
		'text'=>''
	],
	'sales-office'=>
	[
		'title'=>'Офис продаж',
		'img'=>get_template_directory_uri().'/img/design/bag.svg',
		'text'=>''
	],
	'buyer'=>
	[
		'title'=>'Покупатель',
		'img'=>get_template_directory_uri().'/img/design/star.svg',
		'text'=>''
	]
];
$ways_of_delivery = '';
if( get_the_ID() ){
	$category = get_terms(
		'kremlev_category',
		[
			'object_ids'=>get_the_ID(),
			'parent'=>0
		]
	);
	if( is_array($category) && count($category) ){
		$category = array_shift($category);
		foreach( $delivery as $key=>$item ){
			$delivery[$key]['text'] = types_render_termmeta( $key, array( 'term_id'=>$category->term_id) );
		}
		$ways_of_delivery = types_render_termmeta( 'ways-of-delivery', array( 'term_id'=>$category->term_id) );
	}else{
		$delivery['factory']['text'] =  ot_get_option( 'kremlev_delivery_factory' );
		$delivery['transportation']['text'] =  ot_get_option( 'kremlev_delivery_transportation' );
		$delivery['sales-office']['text'] =  ot_get_option( 'kremlev_delivery_sales_office' );
		$delivery['buyer']['text'] =  ot_get_option( 'kremlev_delivery_buyer' );
		$ways_of_delivery = ot_get_option( 'kremlev_delivery_ways_of_delivery' );
	}
}
?><div class="delivery"><?php
	if( is_array( $delivery ) && count( $delivery ) ):
		?><div class="wr-dev row"><?php
			foreach( $delivery as $key=>$item ):
				if( $item['text'] ){
					?><div class="col p0 s12 m3">
						<div class="item-dev">
							<div class="img" style="background-image:url('<?php echo $item['img'];?>')"></div>
							<div class="name"><?php echo $item['title'];?></div>
							<div class="text"><?php echo $item['text'];?></div>
						</div>
					</div><?php
				}
			endforeach;
		?></div><?php
	endif;
	?><div class="bl-text"><?php
		if( ( is_array( $citys ) && count( $citys ) ) || $ways_of_delivery ):
			?><div class="title-text before">Способы доставки</div><?php
			if( $ways_of_delivery ){
				?><p class="text"><?php echo $ways_of_delivery;?></p><?php
			}
			?><ul class="ul-d list-dev"><?php
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
				endif;
				$list_item_delivery = ot_get_option( 'op_delivery_list' );
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
			?></ul><?php
		endif;
		?><div class="title-text before">Условия доставки</div>
		<ul class="ul-d list-time">
			<li class="li-d item-time">Время осуществления доставки <span class="b">с 09:00 до 21:00 часов.</span></li>
			<li class="li-d item-time">Доставка осуществляется в срок <span class="b">от 3 часов до 1 дня.</span></li>
			<li class="li-d item-time">Срочная доставка оплачивается <span class="b">по двойному тарифу.</span></li>
		</ul>
		<div class="title-text before">Самовывоз</div>
		<p class="text">Вы можете забрать заказ прямо из нашего офиса, расположенного по адресу — Москва, Огородный проезд, дом 18.</p>
		<a href="#maps" class="a-d clickSlide">Посмотреть на карте <span class="ic down-arrow-fill"></span></a>
		<div id="maps" class="dn">
			<div class="text"><?php echo ot_get_option( 'main_address' );?></div><?php
			echo ot_get_option( 'maps_textarea' );
		?></div>
		<div class="title-text before collaborate"><?php
			if(ot_get_option( 'main_phone' )):?><a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="a-d">По вопросам сотрудничества звоните:<br><?php echo ot_get_option( 'main_phone' );?></a><?php endif;
		?></div>
	</div>
</div>