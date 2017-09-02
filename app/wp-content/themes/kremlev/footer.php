			</main>
			<!-- ./main -->
			<!-- footer -->
			<footer class="main-footer">
				<div class="wr">
					<div class="wr-nav">
						<nav class="nav">
							<ul class="ul-d list-nav row">
								<li class="li-d item-nav"><?php
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
									<a href="/catalog/" class="a-d link-nav title-nav">Каталог продукции</a>
									<ul class="ul-d">
										<li class="li-d"><a href="/catalog/" class="a-d">Черная икра</a></li>
										<li class="li-d"><a href="/catalog/" class="a-d">Красная икра</a></li>
										<li class="li-d"><a href="/catalog/" class="a-d">Рыба</a></li>
										<li class="li-d"><a href="/catalog/" class="a-d">Крабы</a></li>
									</ul>
								</li>
								<li class="li-d item-nav">
									<a href="/clients/" class="a-d link-nav title-nav">Покупателям</a>
									<ul class="ul-d">
										<li class="li-d"><a href="/clients/#delivery" class="a-d">Доставка</a></li>
										<li class="li-d"><a href="/clients/#faq" class="a-d">FAQ</a></li>
										<li class="li-d"><a href="/clients/#pay" class="a-d">Оплата</a></li>
										<li class="li-d"><a href="/polit/" class="a-d">Политика конфиденциальности</a></li>
									</ul>
								</li><?php
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
		<a id="moveup" class="moveup link-move scale-transition scale-out" href="#" data-move="#main-header"></a>
		<!-- ./footer --><?php
		get_template_part( 'template/catalog', 'online' );
		wp_footer();
		global $reset_LS;
		if( $reset_LS ){
			?><script>LS.clear();</script><?php
		}
	?></body>
</html>
