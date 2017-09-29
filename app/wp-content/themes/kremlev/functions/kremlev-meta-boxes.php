<?php
add_action( 'admin_init', 'custom_meta_boxes' );

function custom_meta_boxes() {
	$news_meta_box = array(
		'id'          => 'news_meta_box',
		'title'       => 'Доп. поля',
		'desc'        => '',
		'pages'       => array( 'kremlev_news' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'id'          => 'additional_block',
				'label'       => 'Дополнительнео поле',
				'desc'        => '',
				'std'         => '',
				'type'        => 'textarea-simple',
				)
		)
	);
	$city_meta_box = array(
		'id'          => 'city_meta_box',
		'title'       => 'Информация для страны',
		'desc'        => '',
		'pages'       => array( 'kremlev_city' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'id'          => 'delivery_list',
				'label'       => 'Доставка',
				'desc'        => '',
				'std'         => '',
				'type'        => 'list-item',
				'settings'    => array(
					array(
						'label'       => 'Время',
						'id'          => 'time_delivery_list',
						'type'        => 'text',
						'desc'        => ''
					),
					array(
						'label'       => 'Стоимость доставки',
						'id'          => 'price_delivery_list',
						'type'        => 'text',
						'desc'        => ''
					),
					array(
						'label'       => 'Минимальная цена заказа',
						'id'          => 'free_delivery_list',
						'type'        => 'text',
						'desc'        => 'Минимальная цена заказа от которой будет доставка бесплатной'
					),
				),
			),
			array(
				'id'          => 'pickup_on_off',
				'label'       => 'Самовывоз',
				'desc'        => 'На странице заказа появляется пункт доставки "Самовывоз"',
				'std'         => 'off',
				'type'        => 'on-off',
			),
		)
	);
	$catalog_meta_box = array(
		'id'          => 'catalog_meta_box',
		'title'       => 'Настройки товара',
		'desc'        => '',
		'pages'       => array( 'catalog' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'label'       => 'Основное',
				'id'          => 'tab_catalog_main',
				'type'        => 'tab'
			),
			array(
				'id'          => 'hit_on_off',
				'label'       => 'Хит-продаж',
				'desc'        => 'У товара появляется значёк "Хит-продаж"',
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'id'          => 'recoment_on_off',
				'label'       => 'Рекомендуем',
				'desc'        => 'Товар появляется в блоке "Рекомендуем"',
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'id'          => 'sale_on_off',
				'label'       => 'По спец скидке',
				'desc'        => 'Товар добавится в список со специальной скидкой',
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'label'       => 'Цена',
				'id'          => 'catalog_price',
				'type'        => 'text',
				'desc'        => 'Цена на товар'
			),
			array(
				'label'       => 'Скидка',
				'id'          => 'catalog_sale',
				'type'        => 'text',
				'desc'        => ''
			),
			array(
				'id'          => 'catalog_gallery',
				'label'       => 'Галерея',
				'desc'        => '',
				'std'         => '',
				'type'        => 'gallery',
				),
			array(
				'id'          => 'catalog_gallery_certificate_1',
				'label'       => 'Вертикальные сертификаты',
				'desc'        => '',
				'std'         => '',
				'type'        => 'gallery',
			),
			array(
				'id'          => 'catalog_gallery_certificate_2',
				'label'       => 'Горизонтальные сертификаты',
				'desc'        => '',
				'std'         => '',
				'type'        => 'gallery',
			),
			array(
				'label'       => 'Характеристики',
				'id'          => 'tab_catalog_characteristics',
				'type'        => 'tab'
			),
			array(
				'id'          => 'characteristics_list',
				'label'       => 'Характеристики',
				'desc'        => '',
				'std'         => '',
				'type'        => 'list-item',
				'settings'    => array(
					array(
						'id'          => 'textarea_characteristics_list',
						'label'       => 'Описание',
						'desc'        => '',
						'std'         => '',
						'type'        => 'textarea-simple',
						)
					)
			),
		)
	);
	$reviews_page_meta_box = array(
		'id'          => 'reviews_page_meta_box',
		'title'       => 'Настройки главной страницы',
		'desc'        => '',
		'pages'       => array( 'kremlev_reviews' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'id'          => 'reviews_taxonomy_select',
				'label'       => 'Выбор подкатегории',
				'desc'        => '',
				'std'         => '',
				'type'        => 'taxonomy-select',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => 'kremlev_category',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'reviews_list',
				'label'       => 'Отзывы',
				'desc'        => '',
				'std'         => '',
				'type'        => 'list-item',
				'settings'    => array(
					array(
						'id'          => 'textarea_minus_reviews_list',
						'label'       => 'Минус',
						'desc'        => '',
						'std'         => '',
						'type'        => 'textarea-simple',
					),
					array(
						'id'          => 'textarea_plus_reviews_list',
						'label'       => 'Плюс',
						'desc'        => '',
						'std'         => '',
						'type'        => 'textarea-simple',
					),
					array(
						'id'          => 'textarea_reviews_list',
						'label'       => 'Отзыв',
						'desc'        => '',
						'std'         => '',
						'type'        => 'textarea-simple',
					),
					array(
						'id'          => 'reviews_gallery',
						'label'       => 'Фотографии',
						'desc'        => '',
						'std'         => '',
						'type'        => 'gallery',
					),
				)
			),
		)
	);
	$main_page_meta_box = array(
		'id'          => 'main_page_meta_box',
		'title'       => 'Настройки главной страницы',
		'desc'        => '',
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'label'       => 'Настройки',
				'id'          => 'main_settings_tab',
				'type'        => 'tab'
				),
			array(
				'id'          => 'main_card_quantity',
				'label'       => 'Количество карточек товаров',
				'desc'        => 'Количество карточек товаров на главной странице.<br>Значение <strong>"-1"</strong> выведутся все товары.',
				'std'         => '3',
				'type'        => 'numeric-slider',
				'min_max_step'=> '-1,30,1',
				),
			array(
				'id'          => 'main_blog_quantity',
				'label'       => 'Количество постов',
				'desc'        => 'Количество постов на главной странице.<br>Значение <strong>"-1"</strong> выведутся все.',
				'std'         => '3',
				'type'        => 'numeric-slider',
				'min_max_step'=> '-1,30,1',
			),
			array(
				'label'       => 'Банеры',
				'id'          => 'baner_tab',
				'type'        => 'tab'
			),
			array(
				'label'       => 'Ссылка для верхнего банера',
				'id'          => 'baner_link',
				'type'        => 'text',
				'desc'        => 'Ссылка для первого банера'
			),
			array(
				'id'          => 'baner_upload',
				'label'       => 'Верхний банер на главную',
				'desc'        => 'Загрузка картинки на главную страницу сайта',
				'type'        => 'upload'
			),
			array(
				'id'          => 'baner_2_upload',
				'label'       => 'Второй банер с текстом',
				'desc'        => 'Загрузите картинку',
				'type'        => 'upload'
			),
			array(
				'id'          => 'baner_2_text',
				'label'       => 'Текст во второй банер',
				'desc'        => 'Текст который будер отображаться во втором банере',
				'desc'        => '',
				'std'         => '',
				'type'        => 'textarea-simple',
				'section'     => 'common',
				'rows'        => '15',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			/*
			array(
				'label'       => 'Слайдер',
				'id'          => 'main_slider_tab',
				'type'        => 'tab'
			),
			array(
				'label'       => 'Показать слайдер',
				'id'          => 'main_slider_show',
				'type'        => 'on-off',
				'desc'        => '',
				'std'         => 'off'
				),
			array(
				'id'          => 'main_slider_list',
				'label'       => 'Слайдер',
				'desc'        => '',
				'std'         => '',
				'type'        => 'list-item',
				'condition'   => 'main_slider_show:is(on)',
				'operator'    => 'and',
				'settings'    => array(
					array(
						'label'       => 'Заголовок',
						'id'          => 'main_slider_list_title',
						'type'        => 'text',
						'desc'        => 'Заголовок слайда'
						),
					array(
						'label'       => 'Изображение',
						'id'          => 'main_slider_list_upload',
						'desc'        => 'Загрузка картинки для слайдера',
						'type'        => 'upload'
						)
					)
				),
				*/
			)
		);
	if ( function_exists( 'ot_register_meta_box' ) ){
		// ot_register_meta_box( $reviews_meta_box );
		ot_register_meta_box( $news_meta_box );
		ot_register_meta_box( $catalog_meta_box );
		ot_register_meta_box( $city_meta_box );
		ot_register_meta_box( $reviews_page_meta_box );
		$post_id = isset( $_GET['post'] ) ? $_GET['post'] : ( isset( $_POST['post_ID'] ) ? $_POST['post_ID'] : 0 );
		$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
		if ( $template_file == 'kremlev.php' ){
			ot_register_meta_box( $main_page_meta_box  );
		}
	}
}