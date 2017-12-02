<?php
// Register Custom Post Type
function kremlev_city() {

	$labels = array(
		'name'                  => 'Город',
		'singular_name'         => 'Город',
		'menu_name'             => 'Город',
		'name_admin_bar'        => 'Город',
		'archives'              => 'Все города',
		'all_items'             => 'Все города',
		'add_new_item'          => 'Добавить новый город',
		'add_new'               => 'Добавить новую',
		'edit_item'             => 'Редактировать',
		'update_item'           => 'Обновить',
		'view_item'             => 'Просмотр',
		'view_items'            => 'Просмотреть все',
		'search_items'          => 'Найти',
		'not_found'             => 'Пусто',
		'not_found_in_trash'    => 'В корзине нету',
	);
	$rewrite = array(
		'slug'                  => 'city',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => 'Город',
		'description'           => 'Город',
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 4,
		'menu_icon'             => 'dashicons-admin-site',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'query_var'             => 'kremlev_city',
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'kremlev_city', $args );

}
add_action( 'init', 'kremlev_city', 0 );