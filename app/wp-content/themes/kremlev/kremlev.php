<?php
 /*
 * Template name: Главная страница
 */
get_header();
/*Количество выводимых постов*/
$quantity_card = get_post_meta( get_the_ID(), 'main_card_quantity', !0 );
$quantity_blog = get_post_meta( get_the_ID(), 'main_blog_quantity', !0 );

$baner_link = get_post_meta( get_the_ID(), 'baner_link', !0 );
$baner = get_post_meta( get_the_ID(), 'baner_upload', !0 );

$baner2_img = get_post_meta( get_the_ID(), 'baner_2_upload', !0 );
$baner2_text = str_replace( "\n",'<br>',get_post_meta( get_the_ID(), 'baner_2_text', !0 ) );
/*Выборка карточек товаров и статей*/
/*Хиты продаж*/
$card_hit_sale = get_posts( array(
	'numberposts'=>$quantity_card,
	'post_type'=>'catalog',
	'meta_query'         => array(
		array(
			'key' => 'hit_on_off',
			'value' => 'on',
		),
	),
) );
/*Скидка*/
$card_sale = get_posts( array(
	'numberposts'=>$quantity_card,
	'post_type'=>'catalog',
	'meta_query'         => array(
		array(
			'key' => 'catalog_sale',
			'value' => '',
			'compare' => '!=',
		),
	),
) );
/*Последнии новости*/
$blog_news = get_posts( array(
	'numberposts'=>$quantity_blog,
	'post_type'=>'kremlev_news',
) );
/*Последнии статьи рецептов*/
$blog_recipes = get_posts( array(
	'numberposts'=>$quantity_blog,
	'post_type'=>'kremlev_recipes',
) );
if( $baner ):
	?><section class="section slider"><?php
		if( $baner_link ):
			?><a href="<?php echo $baner_link;?>" class="wr a-d"><img src="<?php echo $baner;?>" alt="" /></a><?php
		else:
			?><div class="wr"><img src="<?php echo $baner;?>" alt="" /></div><?php
		endif;
	?></section><?php
endif;
if( count( $card_hit_sale ) ):
	?><section class="section hit-sale">
		<div class="wr">
			<h2 class="title">Хиты продаж</h2>
			<div class="wr-card">
				<div class="row"><?php
					foreach( $card_hit_sale as $post){ setup_postdata( $post );
						get_template_part( 'template/catalog', 'item' );
					}
					wp_reset_postdata();
				?></div>
			</div>
		</div>
	</section><?php
endif;
if( $baner2_img || $baner2_text):
?><section class="section sertificate">
	<div class="wr bg-cover" <?php if( $baner2_img ) echo 'style="background-image:url('.$baner2_img.');"';?>><?php
		if( $baner2_text ) echo '<h2 class="title-sertificate">'.$baner2_text.'</h2>';
	?></div>
</section><?php
endif;
if( count( $card_sale ) ):
	?><section class="section sale">
		<div class="wr">
			<h2 class="title">Скидки</h2>
			<div class="wr-card">
				<div class="row"><?php
					foreach( $card_sale as $post){ setup_postdata( $post );
						get_template_part( 'template/catalog', 'item' );
					}
					wp_reset_postdata();
				?></div>
			</div>
		</div>
	</section><?php
endif;
?><section class="section about">
	<div class="wr wr-about bg-contain">
		<h2 class="title">Торговый Дом Кремлев</h2>
		<div class="wr-achievement">
			<ul class="ul-d list-achievement row">
				<li class="li-d item-achievement col s12 m6 l3 sl3">
					<div class="img ic heart"></div>
					<div class="title-achievement">Традиции качества</div>
					<div class="text">Вся продукция имеет сертификаты и ветеринарные свидетельства</div>
				</li>
				<li class="li-d item-achievement col s12 m6 l3 sl3">
					<div class="img ic people"></div>
					<div class="title-achievement">Доверие</div>
					<div class="text">Мы поставляем продукцию первым лицам государства</div>
				</li>
				<li class="li-d item-achievement col s12 m6 l3 sl3">
					<div class="img ic marker"></div>
					<div class="title-achievement">Расширяем границы</div>
					<div class="text">За 2016 год доставили в 73 региона России</div>
				</li>
				<li class="li-d item-achievement col s12 m6 l3 sl3">
					<div class="img ic gift"></div>
					<div class="title-achievement">Лояльность</div>
					<div class="text">Постоянным клиентам действует система скидок и бонусов</div>
				</li>
			</ul>
		</div>
	</div>
</section><?php
if( count( $blog_news ) ):
	?><section class="section last-news">
		<div class="wr">
			<h2 class="title">Последние новости</h2>
			<div class="wr-blog row"><?php
				foreach( $blog_news as $post){ setup_postdata( $post );
					get_template_part( 'template/blog', 'item' );
				}
				wp_reset_postdata();
			?></div>
		</div>
	</section><?php
endif;
if( count( $blog_recipes ) ):
	?><section class="section recipe">
		<div class="wr">
			<h2 class="title">Рецепты</h2>
				<div class="wr-blog row"><?php
				foreach( $blog_recipes as $post){ setup_postdata( $post );
					get_template_part( 'template/blog', 'item' );
				}
				wp_reset_postdata();
			?></div>
		</div>
	</section><?php
endif;
get_footer();