<?php
// Register Custom Post Type
function kremlev_recipes() {

	$labels = array(
		'name'                  => 'Рецепты',
		'singular_name'         => 'Рецепт',
		'menu_name'             => 'Рецепты',
		'name_admin_bar'        => 'Рецепты',
		'archives'              => 'Все Рецепты',
		'all_items'             => 'Все Рецепты',
		'add_new_item'          => 'Добавить новую рецепт',
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
		'slug'                  => 'recipes',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => 'Рецепт',
		'description'           => 'Рецепты',
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
		'query_var'             => 'kremlev_recipes',
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'kremlev_recipes', $args );

}
add_action( 'init', 'kremlev_recipes', 0 );