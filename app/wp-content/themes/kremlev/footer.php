<?php

// $terms = get_terms( 'kremlev_category' );
// $catalog = array();
// if( is_array( $terms ) && count( $terms ) ):
// 	foreach( $terms as $key=>$term ):
// 		if( $term->parent !== 0 ){
// 			if( !isset( $catalog[$term->parent]['children'] ) ) $catalog[$term->parent]['children'] = array();
// 			array_push($catalog[$term->parent]['children'], $term);
// 		}else $catalog[$term->term_id]['parent'] = $term;
// 	endforeach;
// endif;
global $catalog;
// echo '<xmp>';
// var_dump($catalog);
// echo '</xmp>';
// exit();
?>
			</main>
			<!-- ./main -->
			<!-- footer -->
			<footer class="main-footer">
				<div class="wr">
					<div class="wr-nav">
						<nav class="nav">
							<ul class="ul-d list-nav row">
								<li class="li-d item-nav logo"><?php
									if(is_front_page() && is_home()){
										?><img src="<?php echo get_template_directory_uri().'/img/design/kremlev-logo.svg';?>" alt="<?php echo bloginfo( 'name' );?>"><?php
										/*?><img src="<?php echo ot_get_option( 'logo_upload' );?>" alt="?php echo bloginfo( 'name' );?>"><?php*/
									}else{
										?><a href="/" class="a-d" title="<?php echo bloginfo( 'name' );?>"><img src="<?php echo get_template_directory_uri().'/img/design/kremlev-logo.svg';?>" alt="<?php echo bloginfo( 'name' );?>"></a><?php
										/*?><a href="/" class="a-d" title="<?php echo bloginfo( 'name' );?>"><img src="<?php echo ot_get_option( 'logo_upload' );?>" alt="<?php echo bloginfo( 'name' );?>"></a><?php*/
										/*if( ot_get_option( 'logo_upload' ) ){
											?><a href="/" class="a-d" title="<?php echo bloginfo( 'name' );?>"><img src="<?php echo ot_get_option( 'logo_upload' );?>" alt="<?php echo bloginfo( 'name' );?>"></a><?php
										}else{
											?><h1 class="title"><a href="/" class="a-d" title="<?php echo bloginfo( 'name' );?>"><?php echo bloginfo( 'name' );?></a></h1><?php
										}*/
									}
								?></li>
								<li class="li-d item-nav">
									<a href="/catalog/" class="a-d link-nav title-nav">Каталог продукции</a><?php
									if( is_array( $catalog ) && count( $catalog ) ):
										?><ul class="ul-d"><?php
											foreach( $catalog as $aid=>$kat ):
												?><li class="li-d"><a href="<?php echo '/catalog/'.$kat['parent']->slug.'/';?>" class="a-d"><?php echo $kat['parent']->name;?></a></li><?php
											endforeach;
										?></ul><?php
									endif;
							?></li><?php
							menu_cn3bie('main_menu','<li class="li-d item-nav"><a href="{link}" class="a-d link-nav title-nav">{title}</a></li>','<ul class="ul-d">{list}</ul>');
							?></ul>
						</nav>
					</div>
				</div>
			<div class="bottom-line">
				<div class="wr">
					<div class="copyright fl">&copy; <?php echo date('Y').' '.(ot_get_option( 'copyright' )?ot_get_option( 'copyright' ):'Все права защищены');?></div>
					<a href="//landingart.ru/" class="a-d fr wr-logoart">
						<img class="logoart" src="<?php echo get_template_directory_uri() . '/img/design/logoart.png';?>" alt="Разработка сайта LandingArt">
						<span class="text">Разработка сайта</span>
					</a>
					<div class="wr-bank"><span class="ic visa"></span><span class="ic mastercard"></span><span class="ic mir"></span></div>
				</div>
			</div>
		</footer>
		<a id="moveup" class="moveup link-move scale-transition scale-out" href="#" data-move="#main-body"></a>
		<!-- ./footer --><?php
		get_template_part( 'template/catalog', 'online' );
		wp_footer();
		if( ot_get_option( 'footer_code_textarea' ) ) echo ot_get_option( 'footer_code_textarea' );
		?><script>
			LS.set('city',"<?php echo isset($_SESSION['city'])?$_SESSION['city']:'Санкт-Петербург';?>");
			LS.set('city_delivery',"<?php echo isset($_SESSION['city_delivery'])?$_SESSION['city_delivery']:'Санкт-Петербург';?>");
			var move_on_thanks_page = function(get = ''){
				location.href = '<?php echo ot_get_option( 'kremlev_thanks_page_select' )?get_page_link( ot_get_option( 'kremlev_thanks_page_select' ) ):'/';?>' + get;
			};
			var order_order = function(){
				Basket.clear();
				$.get('<?php echo ot_get_option( 'kremlev_order_page_select' )?get_page_link( ot_get_option( 'kremlev_order_page_select' ) ):'/';?>?ajax&clear_basket&timer' )
				.done(function(data){
					log( 'Success clear basket' );
					Basket.setTimer(data);
					return !0;
				}).fail(function(data){
					log( 'Fail clear basket' );
					return !1;
				});
				$('.badget.basket-badget').fadeOut();
			};
		</script>
	</body>
</html>
