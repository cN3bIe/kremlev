<?php
// Register Custom Post Type
function kremlev_reviews() {

	$labels = array(
		'name'                  => 'Отзывы',
		'singular_name'         => 'Отзыв',
		'menu_name'             => 'Отзывы',
		'name_admin_bar'        => 'Отзывы',
		'archives'              => 'Все Отзывы',
		'all_items'             => 'Все Отзывы',
		'add_new_item'          => 'Добавить новую отзыв',
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
		'slug'                  => 'reviews',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => 'Отзыв',
		'description'           => 'Отзывы',
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'taxonomies'            => array( 'kremlev_category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 4,
		'menu_icon'             => 'dashicons-welcome-comments',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'query_var'             => 'kremlev_reviews',
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'kremlev_reviews', $args );

}
add_action( 'init', 'kremlev_reviews', 0 );