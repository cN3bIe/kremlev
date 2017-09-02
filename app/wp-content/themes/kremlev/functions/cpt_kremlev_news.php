<?php
// Register Custom Post Type
function kremlev_news() {

	$labels = array(
		'name'                  => 'Новости',
		'singular_name'         => 'Новость',
		'menu_name'             => 'Новости',
		'name_admin_bar'        => 'Новости',
		'archives'              => 'Все новости',
		'all_items'             => 'Все новости',
		'add_new_item'          => 'Добавить новую новость',
		'add_new'               => 'Добавить новую',
		'new_item'              => 'Новый пункт',
		'edit_item'             => 'Редактировать',
		'update_item'           => 'Обновить',
		'view_item'             => 'Просмотр',
		'view_items'            => 'Просмотреть все',
		'search_items'          => 'Найти',
		'not_found'             => 'Пусто',
		'not_found_in_trash'    => 'В корзине нету',
	);
	$rewrite = array(
		'slug'                  => 'news',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => 'Новость',
		'description'           => 'Новости',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', ),
		// 'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 4,
		'menu_icon'             => 'dashicons-megaphone',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'query_var'             => 'kremlev_news',
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'kremlev_news', $args );

}
add_action( 'init', 'kremlev_news', 0 );