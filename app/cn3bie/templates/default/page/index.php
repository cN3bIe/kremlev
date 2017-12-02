<?php
get_header();
?><section class="section slider">
	<div class="wr-slider bg-cover" style="background-image: url('<?php echo get_template_directory_uri();?>/img/bg-1.jpg');">
		<div class="wr row wr-row-slider">
			<div class="col s12 l8 p0 slid-bl">
				<h2 class="title">Хотите купить<span class="br"></span>свежие продукты?</h2>
				<div class="text">6 лет торговый дом Кремлев доставляет самые свежие продукты первым лицам государства, артистам, певцам и всем тем, кто следит за здоровым питанием</div>
				<div class="wr-form">
					<div class="text">Получите 500 рублей на первую покупку</div>
					<form action="" class="form">
						<span class="dib wr-it">
							<input type="text" class="fi-d it v1" placeholder="Введите ваш E-mail">
						</span>
						<button class="btn">Получить</button>
						<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect bl-politic-conf" for="politic-conf">
							<input type="checkbox" id="politic-conf" class="mdl-checkbox__input" name="politic-conf" checked="checked">
							<span class="mdl-checkbox__label">Согласен(на) на обработку персональных данных (<a href="<?php echo get_page_link( ot_get_option( 'kremlev_politconf_page_select' ) );?>">соглашение</a>)</span>
						</label>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="section hit-sale">
	<div class="wr">
		<h2 class="title">Хиты продаж</h2><?php
			get_template_part( 'template/card-item-6' );
	?></div>
</section>
<section class="section sertificate">
	<div class="wr bg-cover row" style="background-image:url('<?php echo get_template_directory_uri();?>/img/bg-500.jpg');">
		<div class=" col s12 m6 offset-m6 bl-sertificate">
			<h2 class="title-sertificate">Получите 500 рублей<span class="br"></span>на первую покупку</h2>
			<div class="wr-form">
				<form action="" class="form">
					<span class="dib wr-it">
						<input class="it v1 fi-d" type="text" placeholder="Введите ваш E-mail">
					</span>
					<button class="btn v2">Получить</button>
					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect bl-politic-conf v-white" for="politic-conf-2">
						<input type="checkbox" id="politic-conf-2" class="mdl-checkbox__input" name="politic-conf" checked="checked">
						<span class="mdl-checkbox__label">Согласен(на) на обработку персональных данных (<a href="/politic-conf/">соглашение</a>)</span>
					</label>
				</form>
			</div>
		</div>
	</div>
</section>
<section class="section sale">
	<div class="wr">
		<h2 class="title">Скидки</h2><?php
			get_template_part( 'template/card-item-6' );
	?></div>
</section>
<section class="section about">
	<div class="wr wr-about bg-contain">
		<h2 class="title">Торговый Дом Кремлев</h2>
		<div class="wr-achievement">
			<ul class="ul-d list-achievement row">
				<li class="li-d item-achievement col s12 m6 l3">
					<div class="wr-heart">
						<div class="img ic heart"></div>
						<div class="title-achievement">Традиции качества</div>
						<div class="text">Вся продукция имеет сертификаты и ветеринарные свидетельства</div>
					</div>
				</li>
				<li class="li-d item-achievement col s12 m6 l3">
					<div class="wr-people">
						<div class="img ic people"></div>
						<div class="title-achievement">Доверие</div>
						<div class="text">Мы поставляем продукцию первым лицам государства</div>
					</div>
				</li>
				<li class="li-d item-achievement col s12 m6 l3">
					<div class="wr-marker">
						<div class="img ic marker"></div>
						<div class="title-achievement">Расширяем границы</div>
						<div class="text">За 2016 год доставили в 73 региона России</div>
					</div>
				</li>
				<li class="li-d item-achievement col s12 m6 l3">
					<div class="wr-gift">
						<div class="img ic gift"></div>
						<div class="title-achievement">Лояльность</div>
						<div class="text">Постоянным клиентам действует система скидок и бонусов</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</section>
<section class="section last-news">
	<div class="wr">
		<h2 class="title">Последние новости</h2><?php
			get_template_part( 'template/blog-preview-line' );
	?></div>
</section>
<section class="section recipe">
	<div class="wr">
		<h2 class="title">Рецепты</h2><?php
			get_template_part( 'template/blog-preview-line' );
	?></div>
</section><?php
get_footer();