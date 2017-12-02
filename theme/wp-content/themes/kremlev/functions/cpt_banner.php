<?php
function banner() {

	$labels = array(
		'name'                  => 'Баннер',
		'singular_name'         => 'Баннер',
		'menu_name'             => 'Баннер',
		'name_admin_bar'        => 'Баннер',
		'archives'              => 'Все баннеры',
		'all_items'             => 'Все баннеры',
		'add_new_item'          => 'Добавить банер',
		'add_new'               => 'Добавить банер',
		'edit_item'             => 'Редактировать',
		'update_item'           => 'Обновить',
		'view_item'             => 'Просмотр',
		'view_items'            => 'Просмотреть все',
		'search_items'          => 'Найти',
		'not_found'             => 'Пусто',
		'not_found_in_trash'    => 'В корзине нету',
	);
	$rewrite = array(
		'slug'                  => 'banner',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => 'Баннер',
		'description'           => 'Баннер',
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 4,
		'menu_icon'             => 'dashicons-images-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'query_var'             => 'banner',
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'banner', $args );

}
add_action( 'init', 'banner', 0 );