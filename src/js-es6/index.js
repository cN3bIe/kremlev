'use strict';
import Basket from './Basket';
import Bookmark from './Bookmark';
import LS from './LS';

const log = console.log;
;(function($){
	log('Include is main.js');
	let _w = $(window);




	log('Waves init');
	Waves.init();
	Waves.attach('.moveup', ['waves-circle', 'waves-float']);
	Waves.attach('.btn', ['waves-button','waves-light']);
	Waves.attach('.ribe', ['waves-block', 'waves-float']);
	Waves.attach('.link-catalog', ['waves-block']);
	Waves.attach('.ribe-dark', ['waves-block']);
	Waves.attach('.ribe-light', ['waves-block','waves-light']);
	Waves.attach('.ribe-circle', ['waves-circle']);


	let numberStep = (now, tween) => {
		let floored_number = Math.floor(now), target = $(tween.elem);
		target.prop('number',floored_number).text( floored_number + ' руб.');
	};


	let bookmarkAJAX = (id, callback) => {
		$.get(urlBookmark+'?ajax&id='+id)
		.done(function(data){
			log('Success bookmark',id);
			callback(!0);
			return !0;
		}).fail(function(data){
			log('Fail bookmark',id);
			callback(!1);
			return !1;
		});
	};


	let basketAJAX = (id,count = 1) => {
		$.get(urlBasket+'?ajax&id=' + id + ( count?'&count='+count:'&del' ) )
		.done(function(data){
			log('Success basket',id,( count ? count : 'del' ) );
			return !0;
		}).fail(function(data){
			log('Fail basket',id,( count ? count : 'del' ) );
			return !1;
		});
	};


	let cityAJAX = city => {
		$.get('/?ajax&city='+city)
		.done(function(data){
			log('Success city');
			LS.set( 'city', city );
			$('#city,#city_fixed').text( city );
			return !0;
		}).fail(function(data){
			log('Fail city');
			return !1;
		});
	};


	log('SocialShareKit init');
	SocialShareKit.init();



	$(document).ready(function(){
		console.log('Document ready');


		log('%cMaterial Design Lite %cinit',"color:red;","color:white;");
		componentHandler.upgradeDom();

		$('.clickSlide').click(function(e){
			e = e || window.event;
			e.preventDefault();
			$( $(this).attr('href') ).slideToggle();
		});
		$('.btni-download').click(function(e){
			e = e || window.event;
			e.preventDefault();
			let _ = $(this);
			$( _.attr('href') ).click();
		});

		let min_price_for_free_delivery = parseInt( $('.radio-delivery input:checked').parents('label').data('free') ) || 0;


		/*Menu show/hide*/
		$('.item-menu.catalog').hover(function(){
			if( _w.width()>992 ) $(this).find('.wr-catalog').stop().fadeIn();
		},function(){
			if( _w.width()>992 ) $(this).find('.wr-catalog').stop().fadeOut();
		})
		$('.item-menu.catalog>.link-item-menu').click(function(e){
			if( _w.width()< 992){
				e.preventDefault();
				$(this).parents('.catalog').find('.wr-catalog').slideToggle();
			}
		});
		$('.menu-btn').click(function(){
			$('.nav-line').toggleClass('active');
			$(this).toggleClass('tcon-transform');
		});

		$('.btn-filter').click(() => {
			$('.form-filter').stop().slideToggle();
		});



		/*Search show/hide string*/
		$('.search-btn').click(function(){
			let _ = $(this);
			let _p = _.parents('.search');
			_p.find('.string-search').add('.bg-search').stop().fadeToggle();
			_p.find('.wr-fetch').fadeOut();
			_p.find('.string-search input').focus();
			_.toggleClass('tcon-transform');
			if( _.parents('.wr-top-fixed').length ){
				$('body').toggleClass('overflow');
				_.parents('.wr-top-fixed').toggleClass('top0');
			}
		});
		// AJAX поиск товаров
		let $query = !1;
		let $query_str = '';
		$('.string-search input').on('input',function(e){
			$query_str = $(this).val();
			$query = !0;
			let _ = $(this);
			let _featch = _.parents('.search').find('.wr-fetch');
			setInterval(() => {
				if( $query ){
					if( $query_str ){
						_featch.fadeIn();
						$.get( '/?s='+$query_str ).done(function(data){
							_featch.html( data );
						}).fail(function(data){
							log('Fail featch');
						});
						$query = !1;
					}else _featch.fadeOut();
				}
			},1000);
		});


		/*Change hit on sale if they are together */
		let _bn = $('.bl-notice');
		if( _bn.length ){
			_bn.each((index,el) => {
				let _bn = $(el);
				let _bn_bh = _bn.find('.badget-hit');
				let _bn_bs = _bn.find('.badget-sale');
				if( _bn_bh.length && _bn_bs.length ){
					_bn_bs.hide();
					setInterval(function(){
						_bn_bh.add(_bn_bs).fadeToggle();
					},2000);
				}
			});
		}

		/*Mask phone init*/
		// $('.phone').mask('+7 (000) 000-00-00').click(function(){ if(!$(this).val()) $(this).val('+7 ('); });
		$('.phone').inputmask({mask:'+7 (999) 999-99-99'});


		/*Link-move init*/
		$('.link-move').click(function(e){
			$('html,body').animate({'scrollTop':$($(this).data('move')).offset().top-20},"slow");
			e.preventDefault();
		});
		let
			h_header = $('#main-header').outerHeight(),
			handleResize = function(){
				let ww = $(window).width();
				let hw = $(window).height();
				let bl_slider = $('.wr-slider .slid-bl');
				let slideer = $('.slider');
				if( ww > 992 && ( (hw - h_header) > ( bl_slider.height() + 20 ) ) ){
					slideer.height( hw - h_header );
					slideer.css('position','relative');
					bl_slider.css({
						position: 'absolute',
						top: 0,
						bottom: 0,
						right: 'auto',
						left: 'auto',
						margin: 'auto',
						width: '58.33333%',
						height: bl_slider.height()
					});
					bl_slider.parents('.wr-row-slider').height(1);
				}else bl_slider.add(slideer).add(bl_slider.parents('.wr')).removeAttr('style');
				/*Ширина wr-catalog auto*/
				let wr_catalog = $('.nav-line .wr-catalog');
				let width_wr_catalog = wr_catalog.find('.item-catalog').length * $('.nav-line .item-menu.catalog').width();
				if( width_wr_catalog < $('.nav-line .wr-menu').width() ){
					wr_catalog.width( width_wr_catalog );
					wr_catalog.find('.item-catalog').width( $('.nav-line .item-menu.catalog').width() );
				}
			},
			handleScroll = function(){
				let sw = $(this).scrollTop();
				if( sw > 200 ){
					$('#moveup').removeClass('scale-out');
					/*Когда ниже прокручиваешь то верхнее меню прилипает и появляется как только добавляеш в закладки*/
					// $('.wr-const-top-line').addClass('fixed');
				}else{
					$('#moveup').addClass('scale-out');
					// $('.wr-const-top-line').removeClass('fixed');
				}
				$('.wr-top-fixed').css({top: '-100%'});
			};





		/*handleScroll init*/
		handleScroll();
		$(window).scroll(handleScroll);




		/*handleResize init*/
		handleResize();
		$(window).resize(handleResize);



		// let top_line_fixed = function(){

		// };
		/*form-filter change init*/
		/*$('.form-filter input[type="checkbox"]').change(function(){
			let _=$(this);
			$('.filter-popup').stop().fadeOut(function(){
				$(this).css({
					'top': _.parents('.mdl-checkbox').position().top
				}).stop().fadeIn();
			});
		});*/
		if( $('.catalog.catalog-page').length ){
			console.log('Isotop init');
			let $grid = $('.wr-card').isotope({
				itemSelector: '.wr-item-card',
				layoutMode: 'fitRows',
			});
			let _filter = [];

			let sortF = function(){
				let _filt_str = [];
				let _ = $(this);
				let _p = _.parents('.bl-filter');
				let filterName = _p.data('filter-group');
				let filterLvL = _p.data('filter-lvl');
				_p.find('input').each(function(id,el){
					if( $(el).prop("checked") ) _filt_str.push( $(el).parents('label').data('filter') );
				});

				_filter[filterLvL] = _filt_str;
				let _filter_str = _filter.reduce(function(ac,arr){
					if( !ac.length ) return arr;
					if( !arr.length ) return ac;
					else{
						let new_ar = [];
						ac.forEach(function(acV){
							arr.forEach(function(arrV){
								new_ar.push(acV+arrV);
							});
						});
						return new_ar;
					}
				},[]).join();

				$grid.isotope({
					filter: _filter_str
				});
			};
			sortF.apply( $('.form-filter input').first()[0] );
			$('.form-filter input').change(sortF);
			$('.reset').click(function(e){
				e.preventDefault();
				$('.form-filter input').prop('checked',!1).parents('.mdl-checkbox').removeClass('is-checked');
				$grid.isotope({filter: ''});
				// componentHandler.upgradeDom();
				// sortF.apply( $('.form-filter input').first()[0] );
			});
		}


		/*textarea init*/
		$('.form-textarea').each((index, el) => {
			let _ = $(el);
			let _h = _.outerHeight();
			_.on('input',function(e){
				let _sc = _[0].scrollHeight;
				if( _h !== _sc){
					_.css( 'height', _sc );
					_h=_sc;
				}
			});
		});




		/*Tab init*/
		$('.item-control-tab').click(function(){
			let _ = $(this);
			let _tab = $( _.data('tab') );

			_.siblings('.item-control-tab').removeClass('active');
			_.add( _tab ).addClass('active');

			_tab.siblings( '.item-tab' ).removeClass('active').stop().fadeOut(function(){
				_tab.stop().fadeIn();
			});
		});



		let getInfoCardItemForOrder = _ => {
			let info_card = '';
			let title = _.find('.title-card').text();
			let oldprice = _.find('.oldprice-card').text() || _.find('.oldprice').text();
			let specprice = _.find('.specprice-card').text() || _.find('.specprice').text();
			let price = _.find('.price-card').text() || _.find('.price').text();
			let count = _.find('.bl-count .count .fi-d').val();
			return ''
				+(specprice?'Товар по специальной скидке.' + "\n":'')
				+'Название: ' + title + "\n"
				+(oldprice?'Цена без скидки: ' + oldprice + "\n":'')
				+(specprice?'Оригинальная цена: ' + specprice + "\n":'')
				+'Цена: ' + price + "\n"
				+'Кол-во: ' + count + "\n"
				+'Итого: ' + ( parseInt( count ) * parseInt( price ) ) + "\n\n";
		};
		/*Pay One Click init*/
		$('#pay-one-click').click(function(){
			let _ = $(this);
			let _p = _.parents('.main-info');
			_.add('#add-basket,.main-info .bookmark').stop().fadeOut(function(){
				$('#input-phone,#make-order,.bl-politic-conf').stop().fadeIn();
				_p.find('.bl-close,.bl-politic-conf').css('display','inline-block');
			});
			let _f = _p.find('form');
			_f.find('.wpcf7-form-control.wpcf7-hidden.info_products').val( getInfoCardItemForOrder(_p) );
		});
		$('#pay-one-click').parents('.wr-btn').find('form .btn').click(function(){
			let _ = $(this);
			let _p = _.parents('.main-info');
			let _f = _p.find('form');
			_f.find('.wpcf7-form-control.wpcf7-hidden.info_products').val( getInfoCardItemForOrder(_p) );
		});
		$('.bl-order .bl-close').click(function(){
			let _ = $(this);
			let _p = _.parents('.main-info');
			_.add('#input-phone,#make-order, .bl-politic-conf').stop().fadeOut(function(){
				$('#pay-one-click,#add-basket').stop().fadeIn();
				$('.main-info .bookmark').css('display','inline-block');
			});
			let _checkbox = $('.bl-politic-conf');
			if( !_checkbox.find('input').prop('checked') ) _checkbox.click();
		});




		/*item-faq init*/
		$('.item-faq').click(function(){
			$(this).toggleClass('active').find('.answer').stop().slideToggle();
		});






		/*close*/
		$(document).click(function(e){
			e = e || window.event;
			let target = e.target || e.srcElement;
			let _=$(target).parents('.bl-search-city');
			let citySelect = $('.bl-search-city.active');
			if( !_.length && citySelect.length){
				citySelect.stop().fadeOut(function(){ $(this).removeClass('active')});
			}
		});



		if( $('.iziModal').length ){
			console.log('iziModal init');
			$('.iziModal').iziModal({
				width: 1100,
				transitionIn: 'fadeInDown',
				transitionOut: 'bounceOutDown',
			});
			$('.btni.basket,#add-basket').click(function(e){
				e.preventDefault();
				$('.iziModal').iziModal('open');
			});
		}


		let btnInit = function(jq){
			// Увеличивает счетчик товара на 1ед
			jq.find('.enlarge-count').click(function(e){
				e.preventDefault();
				let count = $(this).parents('.bl-count').find('.count .fi-d');
				count.val( parseInt(count.val()) + 1);
			});
			// Уменьшает счетчик товара на 1ед
			jq.find('.reduce-count').click(function(e){
				e.preventDefault();
				let count = $(this).parents('.bl-count').find('.count .fi-d');
				if( parseInt(count.val()) > 1 ) count.val( parseInt(count.val()) - 1);
			});
			/*Открыть блок с выбором "Удалить", "Добавить в закладки"*/
			jq.find('.bl-del').click(function(e){
				e.preventDefault();
				let _ = $(this).parents('.item-card');
				_.find('.bl-del-select').stop().fadeIn();
				if( myBookmark.hasCard(_.attr('id')) ){
					_.find('.del-in-bookmark').css('display','block');
					_.find('.add-in-bookmark').hide();
				}else{
					_.find('.add-in-bookmark').css('display','block');
					_.find('.del-in-bookmark').hide();
				}
			});
			/*Закрыть блок с выбором "Удалить", "Добавить в закладки"*/
			jq.find('.bl-del-select .cancel').click(function(e){
				e.preventDefault();
				$(this).parents('.item-card').find('.bl-del-select').stop().fadeOut();
			});
			let clickBookmark = !0;
			/*Убрать из корзины поместиь в закладки"*/
			jq.find('.add-in-bookmark').click(function(e){
				e.preventDefault();
				if( clickBookmark ){
					clickBookmark = !1;
					let _ = $(this).parents('.item-card');
					_.find('.like').toggleClass('anim');
					_.toggleClass('active');
					if( _.hasClass('active') ) top_fiexd();
					_.find('.bl-del-select').stop().fadeOut();
					bookmarkAJAX(_.attr('id'),function(send){
						if( send ) myBookmark.addCard(_.attr('id'));
						clickBookmark = !0;
					});
					$('[data-id*="'+_.attr('id')+'"]').find('.btni.bookmark').addClass('active');
					_.find('.del').click();
				}
			});
			/*Убрать из закладок"*/
			jq.find('.del-in-bookmark').click(function(e){
				e.preventDefault();
				if( clickBookmark ){
					clickBookmark = !1;
					let _ = $(this).parents('.item-card');
					_.find('.bl-del-select').stop().fadeOut();
					bookmarkAJAX(_.attr('id'),function(send){
						if(send){
							myBookmark.removeCard(_.attr('id'));
							document.dispatchEvent(BasketBookmark);
						}
						clickBookmark = !0;
					});
					$('[data-id*="'+_.attr('id')+'"]').find('.btni.bookmark').removeClass('active');
				}
			});
			// Удалить товар
			jq.find('.del').click(function(e){
				e.preventDefault();
				let _ = $(this);
				let _p = _.parents('.item-card').stop().fadeOut(function(){
					$(this).remove();
					if( $('.bl-card.another-card').children('.item-card').length ) $('.title-another-card').stop().fadeIn();
				});
				myBasket.removeCard(_p.attr('id'));
				basketAJAX(_p.attr('id'),0);
				let sale_price = myBasket.getOldTotal() - myBasket.getTotal();
				$('.total .sale .price')
				.stop().animateNumber({
					number: (sale_price>0?sale_price:0),
					numberStep: numberStep
				});
				$('[data-id*="'+_p.attr('id')+'"]').find('.btni.basket').removeClass('active');
				document.dispatchEvent(BasketBookmark);
			});

			// Изменение счетчика и автоматический расчет
			let totalCard = function(){
				let _ = $(this).parents('.item-card');
				let card = myBasket.changeCard( _.attr('id'), _.find('.bl-count .count .fi-d').val() );
				if(card){
					_.find('.price-total').stop().animateNumber({
						number: card.getTotal(),
						numberStep: numberStep
					});
					basketAJAX(card.id,card.count);
				}
				let total = parseInt( myBasket.getTotal() );
				let delivery = ( min_price_for_free_delivery > total ? parseInt( $('.radio-delivery input:checked').parents('label').data('price') ) || 0 : 0);
				let sale_price = parseInt( myBasket.getSaleTotal() );
				// log('Total: ' + total+';', 'Delivery: ' + delivery + ';','Sale price: ' + sale_price + ';');
				$('.total .sale .price')
				.stop().animateNumber({
					number: (sale_price>0?sale_price:0),
					numberStep: numberStep
				});
				$('.total .bl-total .price').stop().animateNumber({
					number: total + delivery,
					numberStep: numberStep
				});
				$('.total .delivery .price')
				.stop().animateNumber({
					number: delivery,
					numberStep: numberStep
				});
			};
			jq.find('.count .fi-d').on('input change',function(){ totalCard.apply(this); });
			jq.find('.enlarge-count,.reduce-count').click(function(){ totalCard.apply(this); });

			jq.find('.timer').each(function(){
				let _ = $(this);
				let timer = parseInt( _.data('timer') ) || 0;
				if( timer && parseInt( timer ) > Date.now() ){
					_.countdown({
						until: new Date( timer ),
						compact: true,
						format: 'MS',
						onExpiry: function(){
							_.fadeOut();
							if( location.href === urlThanks ) location.href = '/';
						}
					});
				}
			});
			return jq;
		};
		btnInit($('body'));

		/*Функция для изменения верхнего меню*/
		let d;
		let cloneCardTemplate = function(el, _){
			let _c = $('#template .item-card').clone();
			_c.attr('id',el.id);
			_c.find('.img').css({
				backgroundImage: 'url('+el.img.replace('"','')+')'
			});
			_c.find('.title-card').text(el.title);
			_c.find('.fi-d').val(el.count);
			_c.find('.price-card').text(el.price + ' руб.');
			_c.find('.price-total').text( el.price * el.count + ' руб.');
			_c.find('.oldprice-card').text(el.oldprice + ' руб.');
			_c.find('.specprice-card').text(el.specprice + ' руб.');
			_c.find('.a-d').attr('href',el.url);
			if( el.oldprice ) _c.find('.oldprice-card').show();
			else _c.find('.oldprice-card').hide();
			if( el.specprice &&  parseInt( _.getTimer() ) > Date.now() ){
				_c.find('.specprice-card').show();
				_c.find('.timer').data( 'timer', _.getTimer() );
			}else _c.find('.specprice-card').hide();
			return _c;
		};
		// Bookmark & Basket init functional
		let basketBadget = $('.basket-badget');
		let bookmarkBadget = $('.bookmark-badget');



		let myBasket = new Basket( _ =>{
			_.checked( Basket_arr );
			_.getCard().forEach( (el,id,arr) => {
				$('.bl-card.another-card').append( btnInit( cloneCardTemplate( el , _ ) ) );
			});
			if( !!_.getCountCard() ){
				basketBadget.stop().fadeIn().css({display:'inline-block'}).text( _.getCountCard() );
				basketBadget.parents('.basket').addClass('active');
			}else basketBadget.stop().fadeOut().parents('.basket').removeClass('active');
			_.getCard().forEach( el => {
				$('[data-id*="'+el.id+'"]').find('.btni.basket').addClass('active');
			});
		});
		let myBookmark = new Bookmark( _ => {
			_.checked( Bookmark_arr );
			if( !!_.getCountCard() ){
				bookmarkBadget.stop().fadeIn().text( _.getCountCard() );
				bookmarkBadget.parents('.bookmark').addClass('active');
			}else bookmarkBadget.stop().fadeOut().parents('.bookmark').removeClass('active');
			_.getCard().forEach( id => {
				$('[data-id*="'+id+'"]').find('.btni.bookmark').addClass('active').find('.like').addClass('anim');
			});
		});

		// New events BasketBookmark
		let BasketBookmark = new Event('BasketBookmark');
		document.addEventListener('BasketBookmark', e => {
			if( !!myBasket.getCountCard() ){
				basketBadget.stop().fadeIn().css({display:'inline-block'}).text( myBasket.getCountCard() );
				basketBadget.parents('.basket').addClass('active');
			}else{
				basketBadget.stop().fadeOut().parents('.basket').removeClass('active');
				$('.iziModal').iziModal('close');
				if( location.href.search( urlmyBasket.trim() ) !== -1 ) location.href = '/';
			}
			if( !!myBookmark.getCountCard() ){
				bookmarkBadget.stop().fadeIn().text( myBookmark.getCountCard() );
				bookmarkBadget.parents('.bookmark').addClass('active');
			}else{
				bookmarkBadget.stop().fadeOut().parents('.bookmark').removeClass('active');
				if( location.href.search( urlBookmark.trim() ) !== -1 ) location.href = '/';
			}
			let total = parseInt( myBasket.getTotal() );
			let delivery = ( min_price_for_free_delivery > total ? parseInt( $('.radio-delivery input:checked').parents('label').data('price') ) || 0 : 0);
			$('.total .delivery .price')
			.stop().animateNumber({
				number: delivery,
				numberStep: numberStep
			});
			$('.total .bl-total .price')
			.stop().animateNumber({
				number: total + delivery,
				numberStep: numberStep
			});
		}, !1);
		let view_top_fixed = true;
		let top_fiexd = function(){
			if( $(window).width() > 992 && $(window).scrollTop() > $('#main-header').height() ) $('.wr-top-fixed').css({top: 0});
		};

		$('.btni.bookmark').each(function(){
			let clickBookmark = !0;
			let _ = $(this);
			_.click(function(e){
				e.preventDefault();
				if( clickBookmark ){
					clickBookmark = !1;
					_.find('.like').toggleClass('anim');
					let _p = _.toggleClass('active').parents('.item-card,.main-info');
					if( _.hasClass('active') ) top_fiexd();
					if( _p.data('id') ){
						bookmarkAJAX( _p.data('id'), function(send){
							if(send){
								myBookmark.addCard( _p.data('id') );
								document.dispatchEvent(BasketBookmark);
							}
							clickBookmark = !0;
						} );
					}else{
						log(_, _p);
						throw('ID error');
					}
					if( _p.parents('.section.bookmark').length ){
						let total = 0;
						_p.parents('.wr-item-card').fadeOut(function(){
							$(this).remove();
							$('.wr-item-card').not( $(this) ).each(function(){
								total += parseInt( $(this).find('.price').text() );
							});
							$('.bl-total .price')
							.stop().animateNumber({
								number: total,
								numberStep: numberStep
							});
						});
					}
				}
			});
		});

		//Additing product in basket
		$('.btni.basket').click(function(e){
			let _ = $(this).addClass('active').parents('.item-card');
			let el = myBasket.nobj(
				_.data('id'),
				_.find('.title-card').text(),
				_.find('.a-d.title-card').attr('href'),
				_.find('.img').css('background-image'),
				1,
				_.find('.price').text(),
				_.find('.oldprice').text(),
				_.find('.specprice').text()
			);
			basketAJAX(_.data('id'));
			if( myBasket.addCard(el) ){
				let clone = cloneCardTemplate(el, Basket);
				btnInit(clone);
				$('.bl-card.another-card').append( $('.bl-card.current-card').find('.item-card') );
				$('.bl-card.current-card').append( clone );
			}else{
				let cur_el = $('.bl-card.another-card').find('#'+el.id);
				if( cur_el.length ){
					$('.bl-card.another-card').append( $('.bl-card.current-card').find('.item-card') );
					$('.bl-card.current-card').append( cur_el );
				}
			}
			if( $('.bl-card.another-card').children('.item-card').length ) $('.title-another-card').stop().fadeIn();
			else $('.title-another-card').stop().fadeOut();
			document.dispatchEvent(BasketBookmark);
		});
		$('#add-basket').click(function(e){
			let _ = $(this).parents('.main-info');
			let el = myBasket.nobj(
				_.data('id'),
				_.find('.title-card').text(),
				location.href,
				_.find('img').attr('src'),
				_.find('.bl-count .count .fi-d').val(),
				_.find('.price').text(),
				_.find('.oldprice').text(),
				_.find('.specprice').text()
			);
			basketAJAX(_.data('id'),el.count);
			// myBasket.addCard(el);
			if( myBasket.addCard(el) ){
				let clone = cloneCardTemplate(el, Basket);
				btnInit(clone);
				$('.bl-card.another-card').append( $('.bl-card.current-card').find('.item-card') );
				$('.bl-card.current-card').append( clone );
			}else{
				let cur_el = $('.bl-card.another-card').find('#'+el.id);
				if( cur_el.length ){
					$('.bl-card.another-card').append( $('.bl-card.current-card').find('.item-card') );
					$('.bl-card.current-card').append( cur_el );
				}
			}
			if( $('.bl-card.another-card').children('.item-card').length ) $('.title-another-card').stop().fadeIn();
			else $('.title-another-card').stop().fadeOut();
			document.dispatchEvent(BasketBookmark);
		});


		if($('.fotorama').length){
			console.log('Fotorama init');
			$('.fotorama').fotorama({
				'minwidth':'80%',
				'maxwidth':'100%',
				'ratio':'18/15',
				'allowfullscreen':true,//Полноэкранный режим
				'nav':'thumbs',
				'transition':'dissolve',
				'keyboard':true,
				'arrows':'always',
				'fit':'scaledown',
				'thumbheight':85,
				'thumbwidth':85,
				'thumbmargin':40,
				'thumbfit':'scaledown',
			});
		}


		// AJAX подгрузка новостей
		$('.btni.more-blog').click(function(e){
			e.preventDefault();
			let _ = $(this);
			let list_id = '';
			$('.wr-blog .wr-item').each(function(){
				list_id += $(this).attr('id')+'id';
			});
			log(list_id);
			$.get( _.attr('href') + '?ajax&id='+list_id).done(function(data){
				$('.wr-blog').append( data );
			}).fail(function(data){
				_.fadeOut();
			});
		});
		let deliveryClick = function(){
			let _ = $(this);
			let total = parseInt( myBasket.getTotal() );
			min_price_for_free_delivery = _.data('free');
			let delivery = ( min_price_for_free_delivery > total ? parseInt( _.data('price') ) || 0 : 0);
			if( _.hasClass('delivery-pickup') ){
				$('.form-textarea').stop().slideUp(function(){
					$('.wr-maps').stop().slideDown();
				});
			}else{
				$('.wr-maps').stop().slideUp(function(){
					$('.form-textarea').stop().slideDown();
				});
			}
			$('.total .delivery .price')
			.stop().animateNumber({
				number: delivery,
				numberStep: numberStep
			});
			$('.total .bl-total .price').stop().animateNumber({
				number: total + delivery,
				numberStep: numberStep
			});
		};
		let deliveryAJAX = function(city){
			$.get('?city_delivery='+city)
			.done(function(data){
				LS.set('city_delivery',city);
				let wr = $('.wr-delivery');
				wr.stop().slideUp(function(){
					wr.html( data );
					componentHandler.upgradeDom();
					wr.stop().slideDown();
					$('.radio-delivery').click(deliveryClick).first().click();
				});
			}).fail(function(data){
				log('Fail city');
			});
		};

		/*#city init*/
		$('.bl-city').click(function(){
			$(this).find('.bl-search-city').stop().fadeIn(function(){$(this).addClass('active');});
			$(this).find('.list-city').stop().fadeIn();
		});
		$('.bl-city .bl-search-city .wr-fi .fi-d').on('input',function(){
			$('.list-city').stop().fadeOut();
		});


		$('.list-city .item-city').click(function(e){
			e = e || window.event;
			e.stopPropagation ? e.stopPropagation() : (e.cancelBubble=true);
			let par = $(this).parents('.bl-city').find('.select.city');
			par.text( $(this).text() );
			$('.bl-search-city').fadeOut();
			if( par.attr('id') === 'city' || par.attr('id') === 'city_fixed' ) cityAJAX( $(this).text() );
			else deliveryAJAX( $(this).text() );
		});

		log('Kladr init');
		/*Автозаполнение города*/
		$('#city').parents('.bl-city').find('.fi-d').kladr({
				type: $.kladr.type.city,
				typeCode: $.kladr.typeCode.city,
				select: function(obj){
					LS.set('city',obj.name)
					$('.bl-search-city').fadeOut();
					cityAJAX( obj.name );
				}
		});
		$('#city_fixed').parents('.bl-city').find('.fi-d').kladr({
				type: $.kladr.type.city,
				typeCode: $.kladr.typeCode.city,
				select: function(obj){
					LS.set('city',obj.name)
					$('.bl-search-city').fadeOut();
					cityAJAX( obj.name );
				}
		});

		$('#city_delivery').parents('.bl-city').find('.fi-d').kladr({
			type: $.kladr.type.city,
			typeCode: $.kladr.typeCode.city,
			select: function(obj){
				LS.set('city_delivery',obj.name)
				$('#city_delivery').text(obj.name);
				$('.bl-search-city').fadeOut();
				deliveryAJAX(obj.name);
			}
		});

		/*Delivery*/
		$('.radio-delivery').click(deliveryClick);


		$('.order-bookmark').click(function(e){
			e.preventDefault();
			let arr_ajax_request = [];
			let moveLink = function(){
				if( arr_ajax_request.every(function(el){
					return el;
				}) ) location.href= urlBasket;
			};
			$('.wr-card .item-card').each(function(id,el){
				let _ = $(this);
				el = myBasket.nobj(
					_.data('id'),
					_.find('.title-card').text(),
					_.find('.a-d').attr('href'),
					_.find('.img').css('background-image'),
					1,
					_.find('.price').text(),
					_.find('.oldprice').text(),
					_.find('.specprice').text()
				);
				myBasket.addCard(el);
				arr_ajax_request[id] = !1;
				$.get(urlBasket+'?ajax&id=' + _.data('id') + '&count=1' )
				.always(function(){
					arr_ajax_request[id] = !0;
					moveLink();
					Snarl.addNotification({
						title: 'Добавлен товар в корзину!',
						text: 'В корзину добавлен: ' + el.title
					});
					log('Always ' + _.data('id'));
				});
				// myBookmark.removeCard(_.data('id'));
				// bookmarkAJAX(_.data('id'));
			});
			document.dispatchEvent(BasketBookmark);

		});
		$('.form').find('.btn').click(function(e){
			let _ = $(this);
			let _f = _.parents('form');
			let _checkbox = _f.find('.mdl-checkbox');
			e = e || window.event;
			if( !_checkbox.find('input').prop('checked') ){
				e.preventDefault();
				log('Fail polit!');
				_checkbox.addClass('error-polit');
			}else _checkbox.removeClass('error-polit');
		});


		$('.tooltip').tooltipster({
			functionInit:function( instance, helper ){
				let content = $(helper.origin).data('title');
				instance.content(content);
			}
		});

		$('.tooltip_html').tooltipster({
			functionInit:function( instance, helper ){
				instance.content( $($(helper.origin).data('tooltip') ).removeClass('dn').detach() );
			},
			trigger: 'custom',
			triggerClose: {
				click: true,
				scroll: true,
			}
		});
		$('.control-link').click(function(e){
			e = e || window.event;
			let _ = $(this);
			switch( _.data( 'linktype' )){
				case 'bookmark':
					if( !myBookmark.getCountCard() ){
						e.preventDefault();
						_.find('.tooltip_html').tooltipster('open');
					}
					break;
				case 'basket':
					if( !myBasket.getCount() ){
						e.preventDefault();
						_.find('.tooltip_html').tooltipster('open');
					}
					break;
				default: break;
			}
		});


		$('.bl-politic-conf input').change(function(){
			let _ = $(this);
			let _checkbox = _.parents('.mdl-checkbox');
			if( !_.prop('checked') ){
				_checkbox.addClass('error-polit');
				_checkbox.find('.tooltip').tooltipster('open');
			}else{
				_checkbox.removeClass('error-polit');
				_checkbox.find('.tooltip').tooltipster('close');
			}
		});

		$('#btni-order-card').off().click(function(){
			let _fh = $('#bl-order-card');
			let _bl_h = _fh.find('.bl-order-card');
			let _checkbox = _fh.find('.mdl-checkbox');
			_bl_h.find('.city_delivery').val( $('#city_delivery').text() );
			_bl_h.find('.type_delivery').val( $('.wr-delivery .is-checked input').val() );
			_bl_h.find('.address_delivery').val( $('.form-textarea').val() );
			_bl_h.find('.price_delivery').val( $('.total .delivery .price').text() );
			_bl_h.find('.type_pay').val( $('.bl-pay .is-checked input').val() );
			_bl_h.find('.total_sale').val( $('.total .sale .price').text() );
			_bl_h.find('.total').val( $('.form-order .total .bl-total .price').text() );
			let info_card = '';
			$('.wr-info-order .item-card').each(function(){
				info_card += getInfoCardItemForOrder( $(this) );
			});
			_bl_h.find('.info_products').val( info_card );
			if( _checkbox.find('input').prop('checked') ){
				_checkbox.removeClass('error-polit');
				_fh.find('button').click();
			}else{
				_checkbox.addClass('error-polit');
				$('html,body').animate({'scrollTop':_checkbox.offset().top-60},"slow");
				log('Fail polit order!');
			}
		});

	}); /*end document.ready*/




/*ymaps init*/
ymaps.ready( () => {
	if( !LS.get( 'city' ) ){
		cityAJAX( ymaps.geolocation.city || 'Санкт-Петербург' );
	}else{
		$('#city,#city_fixed').text( LS.get( 'city' ) );
		cityAJAX( LS.get( 'city' ) );
	}
});

})(jQuery);
