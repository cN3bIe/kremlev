<?php
/*
* Template name: Страница Покупателям
*/
$posts = get_posts(array('post_type'=>'kremlev_faq'));
get_header();
?><section class="section clients">
<div class="wr">
	<h1 class="title"><?php the_title();?></h1>
	<div class="row">
		<div class="col p0 s12 m3 wr-control-tab">
			<div class="item-control-tab active link-catalog" data-tab="#delivery">Доставка</div><?php
			if( count( $posts ) ):?><div class="item-control-tab link-catalog" data-tab="#faq">FAQ</div><?php endif;
			?><div class="item-control-tab link-catalog" data-tab="#pay">Оплата</div>
		</div>
		<div class="col p0 s12 m9 wr-tabs">
			<div class="item-tab active" id="delivery">
				<div class="title-tabs">Доставка</div><?php
					get_template_part( 'template/delivery' );
				?></div><?php
				if( count( $posts ) ):
				?><div class="item-tab dn" id="faq">
					<div class="title-tabs">FAQ</div>
					<div class="wr-faq"><?php
					foreach( $posts as $post) { setup_postdata( $post );
						if( get_the_content() ){
							?><div class="item-faq">
								<div class="question before"><?php the_title();?></div>
								<div class="answer"><?php the_content();?></div>
							</div><?php
						}
					}
					?></div>
				</div><?php
				endif;
				?><div class="item-tab dn" id="pay">
					<div class="title-tabs">Оплата</div>
					<div class="title-pay">Доступные способы оплаты:</div>
					<div class="wr-pay">
						<div class="item-pay">Наличными при получении</div>
						<div class="item-pay">Безналичный банковский перевод</div>
						<div class="item-pay">Банковской картой при получении</div>
						<div class="item-pay"><span class="ic visa"></span><span class="ic mastercard"></span><span class="ic mir"></span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section><?php
get_footer();