<?php
/*
* Template name: Шапка
*/
$terms = get_terms( 'kremlev_category' );
global $catalog;
$catalog = array();
if( is_array( $terms ) && count( $terms ) ):
	foreach( $terms as $key=>$term ):
		if( $term->parent !== 0 ){
			if( !isset( $catalog[$term->parent]['children'] ) ) $catalog[$term->parent]['children'] = array();
			array_push($catalog[$term->parent]['children'], $term);
		}else $catalog[$term->term_id]['parent'] = $term;
	endforeach;
endif;

/*Проверка на существование в каталоге самого товара что в корзине*/
if( is_array( $_SESSION['basket'] ) && count( $_SESSION['basket'] ) ){
	$basket = get_posts( array(
		'numberposts' =>-1,
		'post_type' => 'catalog',
		'post_status'=>'publish',
		'include'=>array_keys( $_SESSION['basket'] ),
		'order' => 'ASC',
		'orderby' => 'meta_value_num',
	) );
	$new_basket = [];
	if( is_array( $basket ) && count( $basket ) ):
		foreach( $basket as $item ):
			$new_basket[ $item->ID ] = $_SESSION['basket'][ $item->ID ]?$_SESSION['basket'][ $item->ID ]:'1';
		endforeach;
	endif;
	$_SESSION['basket'] = $new_basket;
}
/*Проверка на существование в каталоге самого товара что в корзине*/
if( is_array( $_SESSION['bookmark'] ) && count( $_SESSION['bookmark'] ) ){
	$bookmark = get_posts( array(
		'numberposts' =>-1,
		'post_type' => 'catalog',
		'post_status'=>'publish',
		'include'=>array_keys( $_SESSION['bookmark'] ),
		'order' => 'ASC',
		'orderby' => 'meta_value_num',
	) );
	$new_bookmark = [];
	if( is_array( $bookmark ) && count( $bookmark ) ):
		foreach( $bookmark as $item ):
			$new_bookmark[ $item->ID ] = $_SESSION['bookmark'][ $item->ID ]?$_SESSION['bookmark'][ $item->ID ]:''.$item->ID;
		endforeach;
	endif;
	$_SESSION['bookmark'] = $new_bookmark;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11"><?php
	wp_head();

	if( ot_get_option( 'header_code_textarea' ) ) echo ot_get_option( 'header_code_textarea' );
	?><script>
		var urlThanks = "<?php echo ( ot_get_option( 'kremlev_thanks_page_select' )?get_page_link( ot_get_option( 'kremlev_thanks_page_select' ) ):'/' );?>";
		var urlBasket = "<?php echo ( ot_get_option( 'kremlev_order_page_select' )?get_page_link( ot_get_option( 'kremlev_order_page_select' ) ):'/' );?>";
		var urlBookmark = "<?php echo ( ot_get_option( 'kremlev_bookmark_page_select' )?get_page_link( ot_get_option( 'kremlev_bookmark_page_select' ) ):'/' );?>";
		var Basket_arr = <?php echo '["'.implode( '","', array_keys( $_SESSION['basket'] ) ).'"]';?>;
		var Bookmark_arr = <?php echo '["'.implode( '","', array_keys( $_SESSION['bookmark'] ) ).'"]';?>;
	</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NPL7VLB');</script>
<!-- End Google Tag Manager -->

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter46141824 = new Ya.Metrika({ id:46141824, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <!-- /Yandex.Metrika counter -->

<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-180796-2oZxl';</script>


<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1071648572943629');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1071648572943629&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


<!-- Global site tag (gtag.js) - Google AdWords: 846996825 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-846996825"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-846996825');
</script>

<meta name="google-site-verification" content="m2iUlvUNom4tX0554vg-nQB9j8I6nUPNsWQQ0c0JAts" />

</head>
<body <?php body_class(); ?> id="main-body">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NPL7VLB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- С -->
<div class="wr-top-fixed">
	<div class="wr row wr-top-line">
		<div class="top-line">
			<div class="bl-wr">
				<button type="button" class="tcon tcon-menu--xcross menu-btn dn" aria-label="toggle menu">
					<span class="tcon-menu__lines" aria-hidden="true"></span>
					<span class="tcon-visuallyhidden">Меню</span>
				</button>
				<div class="search">
					<div class="dn string-search">
						<input type="text" class="fi-d" placeholder="Что будем искать?">
					</div>
					<div class="wr-fetch dn"></div>
					<button type="button" class="tcon tcon-search--xcross search-btn" aria-label="toggle search">
						<span class="tcon-search__item" aria-hidden="true"></span>
						<span class="tcon-visuallyhidden">Поиск</span>
					</button>
				</div><?php
				if(ot_get_option( 'kremlev_bookmark_page_select' )):
					?><a href="<?php echo get_page_link( ot_get_option( 'kremlev_bookmark_page_select' ) );?>" class="ic bookmark control-link" data-linktype="bookmark">
						<span class="badget bookmark-badget"></span>
						<span class="tooltip_html" data-tooltip="#tooltip_bookmark_fixed"></span>
					</a><div class="dn" id="tooltip_bookmark_fixed">Начните покупать и получайте подарки <a href="/catalog/">перейти в каталог</a></div><?php
				endif;
				if(ot_get_option( 'kremlev_order_page_select' )):
					?><a href="<?php echo get_page_link( ot_get_option( 'kremlev_order_page_select' ) );?>" class="ic basket control-link" data-linktype="basket">
						<span class="badget basket-badget"></span>
						<span class="tooltip_html" data-tooltip="#tooltip_basket_fixed"></span>
					</a><div class="dn" id="tooltip_basket_fixed">Начните покупать и получайте подарки <a href="/catalog/">перейти в каталог</a></div><?php
				endif;
				if(ot_get_option( 'main_phone' )):
					?><a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="phone-d"><?php echo ot_get_option( 'main_phone' );?></a><?php
				endif;
			?></div>
			<div class="bl-city">
				<span class="ic marker"></span>Ваш город: <span id="city_fixed" class="select city"><?php echo ( isset( $_SESSION['city'] )?$_SESSION['city']:'Санкт-Петербург');?></span>
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
</div>
<!-- ./С -->
	<header id="main-header" class="main-header">
		<div class="wr">
			<div class="bl-menu">
				<div class="bl-logo"><?php
					if(is_front_page() && is_home()){
						?><img src="<?php echo get_template_directory_uri().'/img/design/kremlev-logo.svg';?>" alt="<?php echo bloginfo( 'name' );?>"><?php
						/*?><img src="<?php echo ot_get_option( 'logo_upload' );?>" alt="<?php echo bloginfo( 'name' );?>"><?php*/
					}else{
						?><a href="/" class="a-d" title="<?php echo bloginfo( 'name' );?>"><img src="<?php echo get_template_directory_uri().'/img/design/kremlev-logo.svg';?>" alt="<?php echo bloginfo( 'name' );?>"></a><?php
						/*if( ot_get_option( 'logo_upload' ) ){
							?><a href="/" class="a-d" title="<?php echo bloginfo( 'name' );?>"><img src="<?php echo ot_get_option( 'logo_upload' );?>" alt="<?php echo bloginfo( 'name' );?>"></a><?php
						}else{
							?><h1 class="title"><a href="/" class="a-d" title="<?php echo bloginfo( 'name' );?>"><?php echo bloginfo( 'name' );?></a></h1><?php
						}*/
					}
				?></div>
				<div class="wr-const-top-line">
					<div class="wr-top-line">
						<div class="wr top-line row">
							<div class="bl-wr">
								<button type="button" class="tcon tcon-menu--xcross menu-btn dn" aria-label="toggle menu">
									<span class="tcon-menu__lines" aria-hidden="true"></span>
									<span class="tcon-visuallyhidden">Меню</span>
								</button>
								<div class="search">
									<div class="dn string-search">
										<input type="text" class="fi-d" placeholder="Что будем искать?">
									</div>
									<div class="wr-fetch dn"></div>
									<button type="button" class="tcon tcon-search--xcross search-btn" aria-label="toggle search">
										<span class="tcon-search__item" aria-hidden="true"></span>
										<span class="tcon-visuallyhidden">Поиск</span>
									</button>
								</div><?php
								if(ot_get_option( 'kremlev_bookmark_page_select' )):
									?><a href="<?php echo get_page_link( ot_get_option( 'kremlev_bookmark_page_select' ) );?>" class="ic bookmark control-link" data-linktype="bookmark">
										<span class="badget bookmark-badget"></span>
										<span class="tooltip_html" data-tooltip="#tooltip_bookmark"></span>
									</a><div class="dn" id="tooltip_bookmark">Начните покупать и получайте подарки <a href="/catalog/">перейти в каталог</a></div><?php
								endif;
								if(ot_get_option( 'kremlev_order_page_select' )):
									?><a href="<?php echo get_page_link( ot_get_option( 'kremlev_order_page_select' ) );?>" class="ic basket control-link" data-linktype="basket">
										<span class="badget basket-badget"></span>
										<span class="tooltip_html" data-tooltip="#tooltip_basket"></span>
									</a><div class="dn" id="tooltip_basket">Начните покупать и получайте подарки<a href="/catalog/">перейти в каталог</a></div><?php
								endif;
								if(ot_get_option( 'main_phone' )):
									?><a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="phone-d"><?php echo ot_get_option( 'main_phone' );?></a><?php
								endif;
							?></div>
							<div class="bl-city">
								<span class="ic marker"></span>Ваш город: <span id="city" class="select city"><?php echo ( isset( $_SESSION['city'] )?$_SESSION['city']:'Санкт-Петербург');?></span>
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
				</div>
				<div class="nav-line">
					<div class="ic close v1 dn"></div>
					<div class="wr-menu">
						<div class="main-item-menu dn"><?php
							if(ot_get_option( 'main_phone' )):
								?><a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="phone-d a-d"><?php echo ot_get_option( 'main_phone' );?></a><?php
							endif;
							?><a href="/" class="a-d link-item-menu">Главная</a>
						</div>
						<div class="list-menu row">
							<div class="item-menu catalog">
								<a href="/catalog/" class="a-d link-item-menu ribe-dark">Каталог продукции</a><?php
								if( is_array( $catalog ) && count( $catalog ) ):
									?><div class="wr-catalog">
										<ul class="ul-d list-catalog lvl-1 row"><?php
											foreach( $catalog as $aid=>$kat ):
												$parent = $kat['parent'];
												?><li class="li-d item-catalog col s12 m6 l4 p0">
													<ul class="ul-d list-catalog lvl-2">
														<li class="li-d title-category before"><a class="a-d link-catalog" href="<?php echo '/catalog/'.$parent->slug.'/';?>"><?php echo $parent->name;?></a></li><?php
														if( is_array( $kat['children'] ) && count( $kat['children'] ) ):
															foreach( $kat['children'] as $oid=>$kot ):
																?><li class="li-d "><a href="<?php echo '/catalog/'.$parent->slug.'/'.$kot->slug.'/';?>" class="a-d ribe-dark"><?php echo $kot->name;?></a></li><?php
															endforeach;
														endif;
														?><li class="li-d"><a href="<?php echo '/catalog/'.$parent->slug.'/';?>" class="a-d ribe-dark">Показать больше<span class="ic down-arrow"></span></a></li><?php
													?></ul>
												</li><?php
											endforeach;
											?></ul>
										</div><?php
									endif;
									?></div>
									<div class="wr-lvl-1 row">
										<div class="wrp-item-menu"><?php menu_cn3bie('main_menu','<div class="item-menu"><a href="{link}" class="a-d link-item-menu{class}">{title}</a></div>');?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
			<!-- ./header -->
			<!-- main -->
			<main class="main">
				<div class="bg-search dn"></div><?php
				if( !is_front_page() ): ?><div class="wr"><?php get_krevlev_breadcrumbs();?></div><?php endif;