<?php
function get_page_link( $id ){
	return '/polit/';
}
function ot_get_option( $str ){
	switch( $str ){
		case 'main_phone':
			return '8 (800) 200-51-09';
		default:
			return $str;
	}
}
function get_template_directory_uri(){
	return rtrim( cn3bie::get_theme_dir_url(), '/');
}
function get_img_path(){
	return cn3bie::get_img_dir_url();
}
function the_img_path(){
	echo get_img_path();
}
function get_the_post_thumbnail_url($id = 0, $size = ''){
	return rtrim( get_img_path(), '/').'/materials/blog.jpg';
}
function get_the_ID(){
	return 0;
}

function language_attributes(){
	echo '';
}
function bloginfo( $type ){
	switch( $type ){
		case 'charset':echo 'UTF-8';
		default: echo '';
	}
}
function wp_get_nav_menu_items(){
	return [
		['url'=>'/clients/',			'title'=>'Покупателям'],
		['url'=>'/services/',			'title'=>'Акции'],
		['url'=>'/stroim/',				'title'=>'Контакты'],
		['url'=>'/gallery/',			'title'=>'Новости'],
		['url'=>'/reviews/',			'title'=>'Рецепты'],
	];
}
function menu_cn3bie($menu_name,$item, $list = ''){
	$new_menu = '';
	$url = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
	$url_arr = explode('/',trim( $url, '/' ) );

	$menu_items = wp_get_nav_menu_items( );
	foreach( (array) $menu_items as $key => $menu_item ){
		$menu_item_url = trim( parse_url( $menu_item['url'], PHP_URL_PATH ), '/' );
		$new_menu .= str_replace(array('{link}','{title}','{class}'),array($menu_item['url'],$menu_item['title'], ' '. ( strpos($_SERVER['REQUEST_URI'],$menu_item_url) !== false ?' current':'')),$item);
	}
	echo $new_menu;
}


function get_title($title=''){
	return cn3bie::title($title);
}
function the_title($title=''){
	echo get_title($title);
}

function wp_head(){
	echo '<title>'.get_title().'</title>';
	ScriptCSS::echoCSS();
}
function wp_footer(){
	ScriptCSS::echoScript();
}
function get_body_class($class=''){
	return cn3bie::body_class($class);
}
function body_class($class=''){
	echo 'class="'.get_body_class($class).'"';
}
function get_template_part($name,$params=array()){
	cn3bie::shortcodes($name,$params);
}
function get_header(){
	cn3bie::inc(cn3bie::get_theme_dir().'header.php');
}
function get_footer(){
	cn3bie::inc(cn3bie::get_theme_dir().'footer.php');
}

function cn3bie_price_style( $price ){
	return number_format( $price ,0,',',' ' );
}

function is_front_page(){
	return cn3bie::get_url() === '/';
}

function is_home(){
	return cn3bie::get_url() === '/';
}

function Redirect($str='/'){
	if(!headers_sent()) header('Location: '.$str);
	else die('<meta http-equiv="refresh" content="0;'.$str.'">');
	die();
}

function get_krevlev_breadcrumbs($archive_page_slug = 'catalog', $sep = ' - ',$tax = 'kremlev_category'){
?><div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/"><span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Каталог" class="catalog page " href="/catalog/"><span property="name">Каталог</span></a><meta property="position" content="1"></span> - <span property="itemListElement" typeof="ListItem"><span property="name">Черная икра</span><meta property="position" content="2"></span></div><?php
}