<?php
/*
*	Header
*/
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<!-- favicon -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/img/design/favicon.png" type="image/x-icon">
	<link rel="icon" href="<?php echo get_template_directory_uri();?>/img/design/favicon.png" type="image/x-icon">
	<!-- ./favicon -->
	<script>
		var urlThanks = "<?php echo ( ot_get_option( 'kremlev_thanks_page_select' )?get_page_link( ot_get_option( 'kremlev_thanks_page_select' ) ):'/' );?>";
		var urlBasket = "<?php echo ( ot_get_option( 'kremlev_order_page_select' )?get_page_link( ot_get_option( 'kremlev_order_page_select' ) ):'/' );?>";
		var urlBookmark = "<?php echo ( ot_get_option( 'kremlev_bookmark_page_select' )?get_page_link( ot_get_option( 'kremlev_bookmark_page_select' ) ):'/' );?>";
		var Basket_arr = [""];
		var Bookmark_arr = [""];
	</script><?php
	wp_head();
?></head>
<body <?php body_class(); ?> id="main-body">

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