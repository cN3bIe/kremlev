<?php


add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );

include(  get_stylesheet_directory(). '/option-tree/ot-loader.php' );
function theme_options_parent($parent ) {
	$parent = '';
	return $parent;
}
add_filter( 'ot_theme_options_parent_slug', 'theme_options_parent',20 );

/*Включение сессии*/
$reset_LS = !1;
if( !function_exists('kremlev_init_session')):
	function kremlev_init_session(){
		session_start();
		$cur_reset_stamp = '1sаsghdfffd';
		if( isset( $_GET['ajax'] ) && isset( $_GET['city'] ) ){
			$_SESSION['city'] = $_GET['city'];
			var_dump($_SESSION);
			exit();
		}
		if( $_SESSION['stamp_reset'] !== $cur_reset_stamp || isset( $_GET['reset'] ) ){
			unset( $_SESSION['city'] );
			unset( $_SESSION['basket'] );
			unset( $_SESSION['bookmark'] );
			$_SESSION['stamp_reset'] = $cur_reset_stamp;
			global $reset_LS;
			$reset_LS = !0;
		}
	}
	add_action('init', 'kremlev_init_session', 1);
endif;
if ( ! function_exists( 'kremlev_setup' ) ) :
	function kremlev_setup() {
		load_theme_textdomain( 'kremlev', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array(
			'main_menu' => 'Главное меню',
			) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			) );
		add_theme_support( 'custom-background', apply_filters( 'kremlev_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
			) ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
			) );

		require get_template_directory() . '/functions/kremlev-functions.php';
		require get_template_directory() . '/functions/kremlev-meta-boxes.php';
		require get_template_directory() . '/functions/kremlev-theme-options.php';
		// Кастомный тип новостей
		require get_template_directory() . '/functions/cpt_kremlev_news.php';
		require get_template_directory() . '/functions/cpt_kremlev_faq.php';
		require get_template_directory() . '/functions/cpt_kremlev_recipes.php';
		require get_template_directory() . '/functions/cpt_kremlev_city.php';
	}
	endif;
	add_action( 'after_setup_theme', 'kremlev_setup' );

	function kremlev_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'kremlev_content_width', 640 );
	}
	add_action( 'after_setup_theme', 'kremlev_content_width', 0 );
/*
	function kremlev_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'kremlev' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'kremlev' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			) );
	}
	add_action( 'widgets_init', 'kremlev_widgets_init' );
*/
	function kremlev_scripts() {
		wp_enqueue_style( 'kremlev-style', get_stylesheet_uri() );
		wp_enqueue_style( 'kremlev-libs-css', get_template_directory_uri() . '/css/libs.min.css' );
		wp_enqueue_style( 'kremlev-main-css', get_template_directory_uri() . '/css/main.css' );
		wp_enqueue_script( 'kremlev-libs-js', get_template_directory_uri() . '/js/libs.min.js', array(), '', true );
		wp_enqueue_script( 'kremlev-ls', get_template_directory_uri() . '/js/LS.js', array(), '', true );
		wp_enqueue_script( 'kremlev-basket', get_template_directory_uri() . '/js/Basket.js', array(), '', true );
		wp_enqueue_script( 'kremlev-bookmark', get_template_directory_uri() . '/js/Bookmark.js', array(), '', true );
		wp_enqueue_script( 'kremlev-ymaps-js', 'https://api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU', array(), '', true );
		wp_enqueue_script( 'kremlev-main-js', get_template_directory_uri() . '/js/main.js', array(), '', true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'kremlev_scripts' );

	// Фильтруем ссылки для пользовательских категорий
	function kremlev_permalink($permalink, $post_id, $leavename) {
		if( strpos($permalink, '%kremlev_category%') === !1) return $permalink;
		$post = get_post($post_id);
		if (!$post) return $permalink;

		$terms = array();
		$path = array();
		// echo '<xmp>';
		if( count( $terms = wp_get_object_terms($post->ID,'kremlev_category',array('orderby'=>'term_id','order'=>'DESC')) ) ){
			$terms = array_shift( $terms );
			while( $terms->parent ){
				$path[] = $terms->slug;
				$terms = get_term_by('id', $terms->parent, 'kremlev_category');
			}
			$path[] = $terms->slug;
		}
		$path = count( $path )?implode( array_reverse( $path ),'/' ):'common';
		// var_dump($path);
		// echo '</xmp>';
		// exit();
		return str_replace('%kremlev_category%', $path, $permalink);
	}
	add_filter('post_link', 'kremlev_permalink', 10, 3);
	add_filter('post_type_link', 'kremlev_permalink', 10, 3);
	function kremlev_taxonomy_hierarchy($args) {
		if( isset($args->query_vars['name']) && get_term_by('slug',$args->query_vars['name'],'kremlev_category') ) $args->query_vars = array('kremlev_category'=>$args->query_vars['name']);
		// echo '<xmp>';
		// var_dump($args->query_vars);
		// var_dump($args->request);
		// var_dump($args->matched_query);
		// echo '</xmp>';
		// exit();
	}
	add_action('parse_request', 'kremlev_taxonomy_hierarchy');

	function cn3bie_ikra_permalink(){
		flush_rewrite_rules();
	}
	add_action( 'after_switch_theme', 'cn3bie_ikra_permalink' );
// Изменение длины обрезаемого текста
	function new_excerpt_length($length) {
		return 21;
	}
	add_filter('excerpt_length', 'new_excerpt_length');
// Удаление конструкции [...] на конце.
	add_filter('excerpt_more', function($more) {
		return '...';
	});
// Функция создает дубликат поста в виде черновика и редиректит на его страницу редактирования
	function true_duplicate_post_as_draft(){
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'true_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('Нечего дублировать!');
		}

	// получаем ID оригинального поста
		$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	// а затем и все его данные
		$post = get_post( $post_id );

	/*
	 * если вы не хотите, чтобы текущий автор был автором нового поста
	 * тогда замените следующие две строчки на: $new_post_author = $post->post_author;
	 * при замене этих строк автор будет копироваться из оригинального поста
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	// если пост существует, создаем его дубликат
	if (isset( $post ) && $post != null) {

		// массив данных нового поста
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft', // черновик, если хотите сразу публиковать - замените на publish
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
			);

		// создаем пост при помощи функции wp_insert_post()
		$new_post_id = wp_insert_post( $args );

		// присваиваем новому посту все элементы таксономий (рубрики, метки и т.д.) старого
		$taxonomies = get_object_taxonomies($post->post_type); // возвращает массив названий таксономий, используемых для указанного типа поста, например array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}

		// дублируем все произвольные поля
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
		// и наконец, перенаправляем пользователя на страницу редактирования нового поста
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Ошибка создания поста, не могу найти оригинальный пост с ID=: ' . $post_id);
	}
}
add_action( 'admin_action_true_duplicate_post_as_draft', 'true_duplicate_post_as_draft' );

// Добавляем ссылку дублирования поста для post_row_actions
function true_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="admin.php?action=true_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Дублировать этот пост" rel="permalink">Дублировать</a>';
	}
	return $actions;
}

add_filter( 'post_row_actions', 'true_duplicate_post_link', 10, 2 );




function kremlev_mymy($args){
	return str_replace('Архивы:','',$args);
}
add_filter( 'get_the_archive_title', 'kremlev_mymy' );




function menu_cn3bie($menu_name,$item, $list = ''){
	$locations = get_nav_menu_locations();
	$new_menu = '';
	if( $locations && isset($locations[ $menu_name ]) ){
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach( (array) $menu_items as $key => $menu_item ) $new_menu .= str_replace(array('{link}','{title}'),array($menu_item->url,$menu_item->title),$item);
	}
	echo $new_menu;
}




/*Хлебные крошки*/
class cN3bIe_Breadcrumbs{
	private $breadcrumbs = array();
	private $arr_item = array();
	private $item = null;
	private $index = 0;
	private $last = 0;
	private $path = '/';
	private function getItemName(){
		$this->item['template'] = '<span property="name">' . $this->item['name'] . '</span>';
		return $this;
	}
	private function getItemLink(){
		if( $this->index !== $this->last && $this->item['link'] ){
			$this->path .= $this->item['link'].'/';
			$temp = '<a property="item" typeof="WebPage"';
			if( $this->item['title'] ) $temp .= ' title="'.$this->item['title'].'"';
			if( $this->item['class_link'] ) $temp .= ' class="'.$this->item['class_link'].'"';
			$temp .= ' href="'.$this->path. '">' . $this->item['template'].'</a>';
			$this->item['template'] = $temp;
		}
		return $this;
	}
	private function getItemElement(){
		$this->item['template'] = '<span property="itemListElement" typeof="ListItem">'.$this->item['template'].'<meta property="position" content="'. ($this->index + 1).'">'.'</span>';
		return $this;
	}
	private function item( &$item ){
		$this->item = &$item;
		$this->getItemName()->getItemLink()->getItemElement();
		return $this->item['template'];
	}
	public function creat($sep){
		$items = array();
		if( is_array( $this->arr_item ) && count( $this->arr_item ) ):
			foreach( $this->arr_item as $key=>$item ):
				$this->index = $key;
				$items[] = $this->item($this->arr_item[$key]);
			endforeach;
		endif;
		return '<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">' . implode( $sep, $items ) . '</div>';
	}
	public function getBreadcrumbs( &$arr_item, $sep = ' - ' ){
		$this->arr_item = &$arr_item;
		$this->last = count( $this->arr_item ) - 1;
		return $this->creat($sep);
	}
}

function get_krevlev_breadcrumbs($archive_page_slug = 'catalog', $sep = ' - ',$tax = 'kremlev_category'){
	$cur_obj = get_queried_object();
	if( is_a( $cur_obj, 'WP_Term' ) )
		$cur_term = $cur_obj;
	elseif( count( $cur_term = wp_get_object_terms($cur_obj->ID,$tax,array('orderby'=>'term_id','order'=>'DESC')) ) )
		$cur_term = array_shift( $cur_term );
	if( has_term( $cur_term, $tax ) ){

		$page_archive = get_page_by_path($archive_page_slug);
		$arr_item = array();
		if( is_tax($tax) ){
			array_unshift($arr_item,array(
				'name' => $cur_term->name,
				'link' => $cur_term->slug,
				'title' => $cur_term->name,
				'class_link' => $cur_term->slug.' '.$cur_term->taxonomy.' ',
			));
			while( $cur_term->parent ){
				$cur_term = get_term_by('id', $cur_term->parent, 'kremlev_category');
				array_unshift($arr_item,array(
					'name' => $cur_term->name,
					'link' => $cur_term->slug,
					'title' => $cur_term->name,
					'class_link' => $cur_term->slug.' '.$cur_term->taxonomy.' ',
				));
			}
		}elseif(is_single()){
			array_unshift($arr_item,array(
				'name' => $cur_obj->post_title,
				'link' => $cur_obj->slug,
				'title' => $cur_obj->post_title,
				'class_link' => $cur_obj->slug.' '.$cur_obj->post_type.' ',
			));
			array_unshift($arr_item,array(
				'name' => $cur_term->name,
				'link' => $cur_term->slug,
				'title' => $cur_term->name,
				'class_link' => $cur_term->slug.' '.$cur_term->taxonomy.' ',
			));
			while( $cur_term->parent ){
				$cur_term = get_term_by('id', $cur_term->parent, 'kremlev_category');
				array_unshift($arr_item,array(
					'name' => $cur_term->name,
					'link' => $cur_term->slug,
					'title' => $cur_term->name,
					'class_link' => $cur_term->slug.' '.$cur_term->taxonomy.' ',
				));
			}
		}
		array_unshift($arr_item,array(
			'name' => $page_archive->post_title,
			'link' => $archive_page_slug,
			'title' => $page_archive->post_title,
			'class_link' => $archive_page_slug.' '.$page_archive->post_type.' ',
		));
		$krevlev_breadcrumbs = new cN3bIe_Breadcrumbs;
		echo $krevlev_breadcrumbs->getBreadcrumbs($arr_item);
	}else{
		if(function_exists('bcn_display')){
			echo '<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';
			bcn_display();
			echo '</div>';
		}
	}
}

//исключение страниц из результатов поиска start
function wph_exclude_pages($query) {
	if ($query->is_search) {
		$query->set('post_type', 'catalog');
	}
	return $query;
}
add_filter('pre_get_posts','wph_exclude_pages');
//исключение страниц из результатов поиска end






