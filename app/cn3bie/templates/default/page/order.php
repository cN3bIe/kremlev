<?php
get_header();
?><section class="section order">
	<div class="wr">
		<h1 class="title">Оформление заказа</h1>
		<div class="wr-order">
			<form action="" class="form form-order row">
				<div class="wr-info wr-info-order col s12 m6 bl-card">
					[snp tpl="card-order-item.html" title="Икра стерляди Горкунов, 50 г" price="20 руб." id="1 " count="1 " img="/img/product-0.png"]
					[snp tpl="card-order-item.html" title="Икра стерляди Горкунов, 50 г" price="20 руб." id="2 " count="1 " img="/img/product-0.png"]
					[snp tpl="card-order-item.html" title="Икра стерляди Горкунов, 50 г" price="20 руб." id="3 " count="1 " img="/img/product-0.png"]
					[snp tpl="card-order-item.html" title="Икра стерляди Горкунов, 50 г" price="20 руб." id="4 " count="1 " img="/img/product-0.png"]
					[snp tpl="card-order-item.html" title="Икра стерляди Горкунов, 50 г" price="20 руб." id="5 " count="1 " img="/img/product-0.png"]
					<div class="total">
						<div class="bl-info sale row">
							<div class="name">Скидка</div>
							<div class="price">500 руб.</div>
						</div>
						<div class="bl-info delivery row">
							<div class="name">Стоимость доставки:</div>
							<div class="price">250 руб.</div>
						</div>
						<div class="bl-info bl-total row">
							<div class="name">Итого:</div>
							<div class="price">3100 руб.</div>
						</div>
					</div>
				</div>
				<div class="wr-info wr-info-client col s12 m6">
					<div class="bl-info row">
						<div class="number bl-brick">1</div>
						<div class="info">
							<div class="bl-city">
								Ваш город: <span id="city_delivery" class="select city">Санкт-Петербург</span>
								<div class="bl-search-city"><div class="wr-fi"><input type="text" class="fi-d" placeholder="Поиск города"></div></div>
							</div>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">2</div>
						<div class="info">
							<div class="title-info">Контактная информация:</div>
							<span class="dib wr-it"><input class="it fi-d name" type="text" name="name" placeholder="Ваше имя"></span>
							<span class="dib wr-it"><input class="it fi-d phone" type="text" name="phone" placeholder="Ваш телефон"></span>
							<span class="dib wr-it"><input class="it fi-d email" type="text" name="email" placeholder="Ваш E-mail"></span>
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect bl-politic-conf" for="politic-conf-2">
								<input type="checkbox" id="politic-conf-2" class="mdl-checkbox__input" name="politic-conf" checked="checked">
								<span class="mdl-checkbox__label">Согласен(на) на обработку персональных данных (<a href="/politic-conf/">соглашение</a>)</span>
							</label>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">3</div>
						<div class="info">
							<div class="title-info">Выберите способ доставки:</div>
							[snp tpl="snippets/radio-delivery-on.html"  price="200" free="4000" label="Доставка по Москве (в пределах МКАД)" time="с 09:00 до 21:00 часов" id="delivery-1" name="delivery" value="1"]
							[snp tpl="snippets/radio-delivery-off.html" price="300" free="5000" label="Доставка по Московской области (до 20 км от МКАД)" time="с 09:00 до 21:00 часов" id="delivery-2" name="delivery" value="2"]
							[snp tpl="snippets/radio-delivery-off.html" price="000" free="0000" label="Самовывоз" time="с 10:00 до 18:00 часов" id="delivery-3" name="delivery" value="3"]
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">4</div>
						<div class="info">
							<div class="title-info">Адрес доставки:</div>
							<textarea class="form-textarea" placeholder="Укажите улицу, дом, корпус, квартиру"></textarea>
						</div>
					</div>
					<div class="bl-info row">
						<div class="number bl-brick">5</div>
						<div class="info">
							<div class="title-info">Выберите способ оплаты:</div>
							[snp tpl="snippets/radio-on.html" label="Наличными при получении" id="pay-1" name="pay" value="1"]
							[snp tpl="snippets/radio-off.html" label="Банковской картой при получении" id="pay-2" name="pay" value="2"]
							<div class="wr-bank">
								<span class="ic visa"></span><span class="ic mastercard"></span><span class="ic mir"></span>
							</div>
						</div>
					</div>
					<button type="submit" class="btn">Оформить заказ</button>
				</div>
			</form>
		</div>
	</div>
</section><?php
get_footer();