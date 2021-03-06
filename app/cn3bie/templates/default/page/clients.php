<?php
get_header();
?><section class="section clients">
	<div class="wr">
		<h1 class="title">Покупателям</h1>
		<div class="row">
			<div class="col p0 s12 m3 wr-control-tab">
				<div class="item-control-tab active" data-tab="#delivery">Доставка</div>
				<div class="item-control-tab" data-tab="#faq">FAQ</div>
				<div class="item-control-tab" data-tab="#pay">Оплата</div>
			</div>
			<div class="col p0 s12 m9 wr-tabs">
				<div class="item-tab active" id="delivery">
					<div class="title-tabs">Доставка</div>
					[snp tpl="tab-item-delivery.html" id="delivery" class="active" ]
				</div>
				<div class="item-tab" id="faq">
					<div class="title-tabs">FAQ</div>
					[snp tpl="tab-item-faq.html" id="delivery" class="active" ]
				</div>
				<div class="item-tab" id="pay">
					<div class="title-tabs">Оплата</div>
					<div class="title-pay">Доступные способы оплаты:</div>
					<div class="wr-pay">
						<div class="item-pay">Наличными при получении</div>
						<div class="item-pay">Банковской картой при получении</div>
						<div class="item-pay"><span class="ic visa"></span><span class="ic mastercard"></span><span class="ic mir"></span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section><?php
get_footer();