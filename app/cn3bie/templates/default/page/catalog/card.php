<?php
get_header();
get_template_part( 'template/breadcrumbs');
?><section class="section card">
	<div class="wr">
		<div class="main-info row" data-id="123">
			<div class="col s12 m7 p0">
				<div class="bl-gallery fotorama">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-1.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-2.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-3.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-1.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-2.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-3.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-1.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-2.png" alt="Thumbnail">
					<img class="item-img-gallery" src="<?php echo get_template_directory_uri();?>/img/product-3.png" alt="Thumbnail">
				</div>
			</div>
			<div class="col s12 m5 p0">
				<div class="bl-order">
					<div class="bl-bookmark">
						<a href="#bookmark" class="ic bookmark btni"><span class="like"></span></a>
						<div class="bl-close dn ribe-circle"><a href="#close" class="ic close v1"></a></div>
					</div>
					<div class="title-card">Икра стерляди Горкунов, 100 г</div>
					<div class="name">Цена:</div>
					<div class="price">3800 руб.</div>
					<div class="oldprice">4800 руб.</div>
					<div class="name">Количество:</div>
					<div class="bl-count row">
						<div class="col s3 p0"><a href="#reduce" class="a-d reduce-count bl-brick">-</a></div>
						<div class="col s6 p0"><div class="count bl-brick"><input type="text" class="fi-d" value="1"></div></div>
						<div class="col s3 p0"><a href="#enlerge" class="a-d enlarge-count bl-brick">+</a></div>
					</div>
					<div class="wr-btn">
						<div id="add-bascket" class="btn">Добавить в корзину</div>
						<div id="pay-one-click" class="btn v1">Купить в один клик</div>
						<div id="input-phone" class="wr-phone"><input type="text" class="fi-d phone" placeholder="Введите ваш телефон"></div>
						<div id="make-order" class="btn">Заказать товар</div>
						<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect bl-politic-conf dn" for="politic-conf">
							<input type="checkbox" id="politic-conf" class="mdl-checkbox__input" name="politic-conf" checked="checked">
							<span class="mdl-checkbox__label">Согласен(на) на обработку персональных данных (<a href="/politic-conf/">соглашение</a>)</span>
						</label>
					</div>
				</div>
				<div class="bl-share">
					<div class="title-share">Делитесь с друзьями:</div>
					<div class="ssk-group">
						<a href="" class="ssk ssk-icon ssk-facebook" data-ssk-ready="true"></a>
						<a href="" class="ssk ssk-icon ssk-twitter" data-ssk-ready="true"></a>
						<a href="" class="ssk ssk-icon ssk-google-plus" data-ssk-ready="true"></a>
						<a href="" class="ssk ssk-icon ssk-vk" data-ssk-ready="true"></a>
					</div>
				</div>
			</div>
		</div>
		<div class="more-detailed">
			<div class="wr-control-tab">
				<span class="item-control-tab active" data-tab="#description">Описание</span>
				<span class="item-control-tab" data-tab="#sertificat">Сертификаты</span>
				<span class="item-control-tab" data-tab="#delivery">Доставка</span>
			</div>
			<div class="wr-tabs">
				<div id="description" class="item-tab active"><?php
					get_template_part( 'template/tab-item-description');
				?></div>
				<div id="sertificat" class="item-tab"><?php
					get_template_part( 'template/tab-item-sertificat');
				?></div>
				<div id="delivery" class="item-tab"><?php
					get_template_part( 'template/tab-item-delivery');
				?></div>
			</div>
		</div>
	</div>
</section><?php
get_template_part( 'template/recomend-section');
get_footer();