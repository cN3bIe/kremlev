<?php
// Register Custom Post Type
function kremlev_faq() {

	$labels = array(
		'name'                  => 'FAQ',
		'singular_name'         => 'FAQ',
		'menu_name'             => 'FAQ',
		'name_admin_bar'        => 'FAQ',
		'archives'              => 'Все FAQ',
		'all_items'             => 'Все FAQ',
		'add_new_item'          => 'Добавить новую FAQ',
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
		'slug'                  => 'faq',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => 'FAQ',
		'description'           => 'FAQ',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', ),
		'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 4,
		'menu_icon'             => 'dashicons-info',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'query_var'             => 'kremlev_faq',
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'kremlev_faq', $args );

}
add_action( 'init', 'kremlev_faq', 0 );