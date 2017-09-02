<?php
/*
* Template name: Шапка
*/
$terms = get_terms( 'kremlev_category' );
$catalog = array();
if( is_array( $terms ) && count( $terms ) ):
	foreach( $terms as $key=>$term ):
		if( $term->parent !== 0 ){
			if( !isset( $catalog[$term->parent]['children'] ) ) $catalog[$term->parent]['children'] = array();
			array_push($catalog[$term->parent]['children'], $term);
		}else $catalog[$term->term_id]['parent'] = $term;
	endforeach;
endif;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!-- favicon -->
	<link rel="shortcut icon" href="//cdn.cn3bie.ru/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="//cdn.cn3bie.ru/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="//cdn.cn3bie.ru/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="//cdn.cn3bie.ru/img/favicon/apple-touch-icon-114x114.png">
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#000">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#000">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#000">
	<!-- ./favicon -->
	<meta name="yandex-verification" content="0a9ffa043d1a2184" /><?php
	wp_head();
?></head>
<body <?php body_class(); ?>>
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
									?><a href="<?php echo get_page_link( ot_get_option( 'kremlev_bookmark_page_select' ) );?>" class="ic bookmark"><span id="bookmark-badget" class="badget"></span></a><?php
								endif;
								if(ot_get_option( 'kremlev_order_page_select' )):
									?><a href="<?php echo get_page_link( ot_get_option( 'kremlev_order_page_select' ) );?>" class="ic basket"><span id="basket-badget" class="badget"></span></a><?php
								endif;
								if(ot_get_option( 'main_phone' )):
									?><a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="phone"><?php echo ot_get_option( 'main_phone' );?></a><?php
								endif;
							?></div>
							<div class="bl-city">
								<span class="ic marker"></span>Ваш город: <span id="city" class="select city"><?php echo ( isset( $_SESSION['city'] )?$_SESSION['city']:'Санкт-Петербург');?></span>
								<div class="bl-search-city">
									<div class="wr-fi">
										<input type="text" class="fi-d" placeholder="Поиск города">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="nav-line">
					<div class="ic close v1 dn"></div>
					<div class="wr-menu">
						<div class="list-menu row">
							<div class="item-menu catalog">
								<a href="/catalog/" class="a-d link-item-menu">Каталог продукции</a><?php
								if( is_array( $catalog ) && count( $catalog ) ):
									?><div class="wr-catalog">
										<ul class="ul-d list-catalog lvl-1 row"><?php
											foreach( $catalog as $aid=>$kat ):
												$parent = $kat['parent'];
												?><li class="li-d item-catalog col s12 m6 l4 p0">
													<ul class="ul-d list-catalog lvl-2">
														<li class="li-d title-category before"><a class="a-d" href="<?php echo '/catalog/'.$parent->slug.'/';?>"><?php echo $parent->name;?></a></li><?php
														if( is_array( $kat['children'] ) && count( $kat['children'] ) ):
															foreach( $kat['children'] as $oid=>$kot ):
																?><li class="li-d"><a href="<?php echo '/catalog/'.$parent->slug.'/'.$kot->slug.'/';?>" class="a-d"><?php echo $kot->name;?></a></li><?php
															endforeach;
														endif;
														?><li class="li-d"><a href="<?php echo '/catalog/'.$parent->slug.'/';?>" class="a-d">Показать больше<span class="ic down-arrow"></span></a></li><?php
													?></ul>
												</li><?php
											endforeach;
											?></ul>
										</div><?php
									endif;
									?></div>
									<div class="wr-lvl-1 row">
										<div class="wrp-item-menu"><?php menu_cn3bie('main_menu','<div class="item-menu"><a href="{link}" class="a-d link-item-menu">{title}</a></div>');?></div>
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