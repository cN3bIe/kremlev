var log = console.log;
;(function($){
	log('Include is main.js');
	var _w = $(window);




	log('Waves init');
	Waves.init();
	Waves.attach('.moveup', ['waves-circle', 'waves-float']);
	Waves.attach('.btn', ['waves-button','waves-light']);
	Waves.attach('.ribe', ['waves-block', 'waves-float']);
	Waves.attach('.link-catalog', ['waves-block']);
	Waves.attach('.ribe-dark', ['waves-block']);
	Waves.attach('.ribe-light', ['waves-block','waves-light']);
	Waves.attach('.ribe-circle', ['waves-circle']);


	var numberStep = function(now, tween) {
		var floored_number = Math.floor(now), target = $(tween.elem);
		target.prop('number',floored_number).text( floored_number + ' руб.');
	};


	var bookmarkAJAX = function(id, callback){
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


	var basketAJAX = function(id,count = 1){
		$.get(urlBasket+'?ajax&id=' + id + ( count?'&count='+count:'&del' ) )
		.done(function(data){
			log('Success basket',id,( count ? count : 'del' ) );
			return !0;
		}).fail(function(data){
			log('Fail basket',id,( count ? count : 'del' ) );
			return !1;
		});
	};


	var cityAJAX = function(city){
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



	$(document).ready(function(){
		console.log('Document ready');

		log('SocialShareKit init');
		SocialShareKit.init();

		log('%cMaterial Design Lite %cinit',"color:red;","color:white;");
		componentHandler.upgradeDom();

		$('.clickSlide').click(function(e){
			e = e || window.event;
			e.preventDefault();
			$( $(this).attr('href') ).slideToggle();
		});


		var min_price_for_free_delivery = parseInt( $('.radio-delivery input:checked').parents('label').data('free') ) || 0;


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

		$('.btn-filter').click(function(){
			$('.form-filter').stop().slideToggle();
		});



		/*Search show/hide string*/
		$('.search-btn').click(function(){
			var _ = $(this);
			var _p = _.parents('.search');
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
		$query = !1;
		$query_str = '';
		$('.string-search input').on('input',function(e){
			$query_str = $(this).val();
			$query = !0;
			var _ = $(this);
			var _featch = _.parents('.search').find('.wr-fetch');
			setInterval(function(){
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
		var _bn = $('.bl-notice');
		if( _bn.length ){
			_bn.each(function(index,el){
				var _bn = $(el);
				var _bn_bh = _bn.find('.badget-hit');
				var _bn_bs = _bn.find('.badget-sale');
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
		var
			h_header = $('#main-header').outerHeight(),
			handleResize = function(){
				var ww = $(window).width();
				var hw = $(window).height();
				var bl_slider = $('.wr-slider .slid-bl');
				var slideer = $('.slider');
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
				var wr_catalog = $('.nav-line .wr-catalog');
				var width_wr_catalog = wr_catalog.find('.item-catalog').length * $('.nav-line .item-menu.catalog').width();
				if( width_wr_catalog < $('.nav-line .wr-menu').width() ){
					wr_catalog.width( width_wr_catalog );
					wr_catalog.find('.item-catalog').width( $('.nav-line .item-menu.catalog').width() );
				}
			},
			handleScroll = function(){
				var sw = $(this).scrollTop();
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



		// var top_line_fixed = function(){

		// };
		/*form-filter change init*/
		/*$('.form-filter input[type="checkbox"]').change(function(){
			var _=$(this);
			$('.filter-popup').stop().fadeOut(function(){
				$(this).css({
					'top': _.parents('.mdl-checkbox').position().top
				}).stop().fadeIn();
			});
		});*/
		if( $('.catalog.catalog-page').length ){
			console.log('Isotop init');
			var $grid = $('.wr-card').isotope({
				itemSelector: '.wr-item-card',
				layoutMode: 'fitRows',
			});
			var _filter = [];

			var sortF = function(){
				var _filt_str = [];
				var _ = $(this);
				var _p = _.parents('.bl-filter');
				var filterName = _p.data('filter-group');
				var filterLvL = _p.data('filter-lvl');
				_p.find('input').each(function(id,el){
					if( $(el).prop("checked") ) _filt_str.push( $(el).parents('label').data('filter') );
				});

				_filter[filterLvL] = _filt_str;
				_filter_str = _filter.reduce(function(ac,arr){
					if( !ac.length ) return arr;
					if( !arr.length ) return ac;
					else{
						var new_ar = [];
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
		$('.form-textarea').each(function(index, el){
			var _ = $(el);
			var _h = _.outerHeight();
			_.on('input',function(e){
				var _sc = _[0].scrollHeight;
				if( _h !== _sc){
					_.css( 'height', _sc );
					_h=_sc;
				}
			});
		});




		/*Tab init*/
		$('.item-control-tab').click(function(){
			var _ = $(this);
			var _tab = $( _.data('tab') );

			_.siblings('.item-control-tab').removeClass('active');
			_.add( _tab ).addClass('active');

			_tab.siblings( '.item-tab' ).removeClass('active').stop().fadeOut(function(){
				_tab.stop().fadeIn();
			});
		});



		var getInfoCardItemForOrder = function(_){
			var info_card = '';
			var title = _.find('.title-card').text();
			var oldprice = _.find('.oldprice-card').text() || _.find('.oldprice').text();
			var specprice = _.find('.specprice-card').text() || _.find('.specprice').text();
			var price = _.find('.price-card').text() || _.find('.price').text();
			var count = _.find('.bl-count .count .fi-d').val();
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
			var _ = $(this);
			var _p = _.parents('.main-info');
			_.add('#add-basket,.main-info .bookmark').stop().fadeOut(function(){
				$('#input-phone,#make-order,.bl-politic-conf').stop().fadeIn();
				_p.find('.bl-close,.bl-politic-conf').css('display','inline-block');
			});
			var _f = _p.find('form');
			_f.find('.wpcf7-form-control.wpcf7-hidden.info_products').val( getInfoCardItemForOrder(_p) );
		});
		$('#pay-one-click').parents('.wr-btn').find('form .btn').click(function(){
			var _ = $(this);
			var _p = _.parents('.main-info');
			var _f = _p.find('form');
			_f.find('.wpcf7-form-control.wpcf7-hidden.info_products').val( getInfoCardItemForOrder(_p) );
		});
		$('.bl-order .bl-close').click(function(){
			var _ = $(this);
			var _p = _.parents('.main-info');
			_.add('#input-phone,#make-order, .bl-politic-conf').stop().fadeOut(function(){
				$('#pay-one-click,#add-basket').stop().fadeIn();
				$('.main-info .bookmark').css('display','inline-block');
			});
			var _checkbox = $('.bl-politic-conf');
			if( !_checkbox.find('input').prop('checked') ) _checkbox.click();
		});




		/*item-faq init*/
		$('.item-faq').click(function(){
			$(this).toggleClass('active').find('.answer').stop().slideToggle();
		});






		/*close*/
		$(document).click(function(e){
			e = e || window.event;
			target = e.target || e.srcElement;
			var _=$(target).parents('.bl-search-city');
			var citySelect = $('.bl-search-city.active');
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


		var btnInit = function(jq){
			// Увеличивает счетчик товара на 1ед
			jq.find('.enlarge-count').click(function(e){
				e.preventDefault();
				var count = $(this).parents('.bl-count').find('.count .fi-d');
				count.val( parseInt(count.val()) + 1);
			});
			// Уменьшает счетчик товара на 1ед
			jq.find('.reduce-count').click(function(e){
				e.preventDefault();
				var count = $(this).parents('.bl-count').find('.count .fi-d');
				if( parseInt(count.val()) > 1 ) count.val( parseInt(count.val()) - 1);
			});
			/*Открыть блок с выбором "Удалить", "Добавить в закладки"*/
			jq.find('.bl-del').click(function(e){
				e.preventDefault();
				var _ = $(this).parents('.item-card');
				_.find('.bl-del-select').stop().fadeIn();
				if( Bookmark.hasCard(_.attr('id')) ){
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
			var clickBookmark = !0;
			/*Убрать из корзины поместиь в закладки"*/
			jq.find('.add-in-bookmark').click(function(e){
				e.preventDefault();
				if( clickBookmark ){
					clickBookmark = !1;
					var _ = $(this).parents('.item-card');
					_.find('.like').toggleClass('anim');
					_.toggleClass('active');
					if( _.hasClass('active') ) top_fiexd();
					_.find('.bl-del-select').stop().fadeOut();
					bookmarkAJAX(_.attr('id'),function(send){
						if( send ) Bookmark.addCard(_.attr('id'));
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
					var _ = $(this).parents('.item-card');
					_.find('.bl-del-select').stop().fadeOut();
					bookmarkAJAX(_.attr('id'),function(send){
						if(send){
							Bookmark.removeCard(_.attr('id'));
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
				var _ = $(this);
				var _p = _.parents('.item-card').stop().fadeOut(function(){
					$(this).remove();
					if( $('.bl-card.another-card').children('.item-card').length ) $('.title-another-card').stop().fadeIn();
				});
				Basket.removeCard(_p.attr('id'));
				basketAJAX(_p.attr('id'),0);
				var sale_price = Basket.getOldTotal() - Basket.getTotal();
				$('.total .sale .price')
				.stop().animateNumber({
					number: (sale_price>0?sale_price:0),
					numberStep: numberStep
				});
				$('[data-id*="'+_p.attr('id')+'"]').find('.btni.basket').removeClass('active');
				document.dispatchEvent(BasketBookmark);
			});

			// Изменение счетчика и автоматический расчет
			var totalCard = function(){
				var _ = $(this).parents('.item-card');
				var card = Basket.changeCard( _.attr('id'), _.find('.bl-count .count .fi-d').val() );
				if(card){
					_.find('.price-total').stop().animateNumber({
						number: card.getTotal(),
						numberStep: numberStep
					});
					basketAJAX(card.id,card.count);
				}
				var total = parseInt( Basket.getTotal() );
				var delivery = ( min_price_for_free_delivery > total ? parseInt( $('.radio-delivery input:checked').parents('label').data('price') ) || 0 : 0);
				var sale_price = parseInt( Basket.getSaleTotal() );
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
				var _ = $(this);
				var timer = parseInt( _.data('timer') ) || 0;
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
		var d;
		var cloneCardTemplate = function(el, _){
			var _c = $('#template .item-card').clone();
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
		var basketBadget = $('.basket-badget');
		var bookmarkBadget = $('.bookmark-badget');



		Basket.init(function(_){
			_.checked( Basket_arr );
			_.getCard().forEach(function(el,id,arr){
				$('.bl-card.another-card').append( btnInit( cloneCardTemplate( el , _ ) ) );
			});
			if( !!_.getCountCard() ){
				basketBadget.stop().fadeIn().css({display:'inline-block'}).text( _.getCountCard() );
				basketBadget.parents('.basket').addClass('active');
			}else basketBadget.stop().fadeOut().parents('.basket').removeClass('active');
			_.getCard().forEach(function(el){
				$('[data-id*="'+el.id+'"]').find('.btni.basket').addClass('active');
			});
		});
		Bookmark.init(function(_){
			_.checked( Bookmark_arr );
			if( !!_.getCountCard() ){
				bookmarkBadget.stop().fadeIn().text( _.getCountCard() );
				bookmarkBadget.parents('.bookmark').addClass('active');
			}else bookmarkBadget.stop().fadeOut().parents('.bookmark').removeClass('active');
			_.getCard().forEach(function(id){
				$('[data-id*="'+id+'"]').find('.btni.bookmark').addClass('active').find('.like').addClass('anim');
			});
		});

		// New events BasketBookmark
		var BasketBookmark = new Event('BasketBookmark');
		document.addEventListener('BasketBookmark', function (e) {
			if( !!Basket.getCountCard() ){
				basketBadget.stop().fadeIn().css({display:'inline-block'}).text( Basket.getCountCard() );
				basketBadget.parents('.basket').addClass('active');
			}else{
				basketBadget.stop().fadeOut().parents('.basket').removeClass('active');
				$('.iziModal').iziModal('close');
				if( location.href.search( urlBasket.trim() ) !== -1 ) location.href = '/';
			}
			if( !!Bookmark.getCountCard() ){
				bookmarkBadget.stop().fadeIn().text( Bookmark.getCountCard() );
				bookmarkBadget.parents('.bookmark').addClass('active');
			}else{
				bookmarkBadget.stop().fadeOut().parents('.bookmark').removeClass('active');
				if( location.href.search( urlBookmark.trim() ) !== -1 ) location.href = '/';
			}
			var total = parseInt( Basket.getTotal() );
			var delivery = ( min_price_for_free_delivery > total ? parseInt( $('.radio-delivery input:checked').parents('label').data('price') ) || 0 : 0);
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
		var view_top_fixed = true;
		var top_fiexd = function(){
			if( $(window).width() > 992 && $(window).scrollTop() > $('#main-header').height() ) $('.wr-top-fixed').css({top: 0});
		};

		$('.btni.bookmark').each(function(){
			var clickBookmark = !0;
			var _ = $(this);
			_.click(function(e){
				e.preventDefault();
				if( clickBookmark ){
					clickBookmark = !1;
					_.find('.like').toggleClass('anim');
					var _p = _.toggleClass('active').parents('.item-card,.main-info');
					if( _.hasClass('active') ) top_fiexd();
					if( _p.data('id') ){
						bookmarkAJAX( _p.data('id'), function(send){
							if(send){
								Bookmark.addCard( _p.data('id') );
								document.dispatchEvent(BasketBookmark);
							}
							clickBookmark = !0;
						} );
					}else{
						log(_, _p);
						throw('ID error');
					}
					if( _p.parents('.section.bookmark').length ){
						var total = 0;
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
			var _ = $(this).addClass('active').parents('.item-card');
			var el = Basket.nobj(
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
			if( Basket.addCard(el) ){
				var clone = cloneCardTemplate(el, Basket);
				btnInit(clone);
				$('.bl-card.another-card').append( $('.bl-card.current-card').find('.item-card') );
				$('.bl-card.current-card').append( clone );
			}else{
				var cur_el = $('.bl-card.another-card').find('#'+el.id);
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
			var _ = $(this).parents('.main-info');
			var el = Basket.nobj(
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
			// Basket.addCard(el);
			if( Basket.addCard(el) ){
				var clone = cloneCardTemplate(el, Basket);
				btnInit(clone);
				$('.bl-card.another-card').append( $('.bl-card.current-card').find('.item-card') );
				$('.bl-card.current-card').append( clone );
			}else{
				var cur_el = $('.bl-card.another-card').find('#'+el.id);
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
			var _ = $(this);
			var list_id = '';
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
		var deliveryClick = function(){
			var _ = $(this);
			var total = parseInt( Basket.getTotal() );
			min_price_for_free_delivery = _.data('free');
			var delivery = ( min_price_for_free_delivery > total ? parseInt( _.data('price') ) || 0 : 0);
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
		var deliveryAJAX = function(city){
			$.get('?city_delivery='+city)
			.done(function(data){
				LS.set('city_delivery',city);
				var wr = $('.wr-delivery');
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
			var par = $(this).parents('.bl-city').find('.select.city');
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
			var arr_ajax_request = [];
			var moveLink = function(){
				if( arr_ajax_request.every(function(el){
					return el;
				}) ) location.href= urlBasket;
			};
			$('.wr-card .item-card').each(function(id,el){
				var _ = $(this);
				var el = Basket.nobj(
					_.data('id'),
					_.find('.title-card').text(),
					_.find('.a-d').attr('href'),
					_.find('.img').css('background-image'),
					1,
					_.find('.price').text(),
					_.find('.oldprice').text(),
					_.find('.specprice').text()
				);
				Basket.addCard(el);
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
				// Bookmark.removeCard(_.data('id'));
				// bookmarkAJAX(_.data('id'));
			});
			document.dispatchEvent(BasketBookmark);

		});
		$('.form').find('.btn').click(function(e){
			var _ = $(this);
			var _f = _.parents('form');
			var _checkbox = _f.find('.mdl-checkbox');
			e = e || window.event;
			if( !_checkbox.find('input').prop('checked') ){
				e.preventDefault();
				log('Fail polit!');
				_checkbox.addClass('error-polit');
			}else _checkbox.removeClass('error-polit');
		});


		$('.tooltip').tooltipster({
			functionInit:function( instance, helper ){
				var content = $(helper.origin).data('title');
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
		$('#link_bookmark').click(function(e){
			if( !Bookmark.getCountCard() ){
				e = e || window.event;
				e.preventDefault();
				$(this).find('.tooltip_html').tooltipster('open');
			}
		});
		$('#link_basket').click(function(e){
			if( !Basket.getCount() ){
				e = e || window.event;
				e.preventDefault();
				$(this).find('.tooltip_html').tooltipster('open');
			}
		});


		$('.bl-politic-conf input').change(function(){
			var _ = $(this);
			var _checkbox = _.parents('.mdl-checkbox');
			if( !_.prop('checked') ){
				_checkbox.addClass('error-polit');
				_checkbox.find('.tooltip').tooltipster('open');
			}else{
				_checkbox.removeClass('error-polit');
				_checkbox.find('.tooltip').tooltipster('close');
			}
		});

		$('#btni-order-card').off().click(function(){
			var _fh= $('#bl-order-card');
			var _bl_h = _fh.find('.bl-order-card');
			var _checkbox = _fh.find('.mdl-checkbox');
			_bl_h.find('.city_delivery').val( $('#city_delivery').text() );
			_bl_h.find('.type_delivery').val( $('.wr-delivery .is-checked input').val() );
			_bl_h.find('.address_delivery').val( $('.form-textarea').val() );
			_bl_h.find('.price_delivery').val( $('.total .delivery .price').text() );
			_bl_h.find('.type_pay').val( $('.bl-pay .is-checked input').val() );
			_bl_h.find('.total_sale').val( $('.total .sale .price').text() );
			_bl_h.find('.total').val( $('.form-order .total .bl-total .price').text() );
			var info_card = '';
			$('.wr-info-order .item-card').each(function(){
				info_card += getInfoCardItemForOrder( $(this) );
			});
			_bl_h.find('.info_products').val( info_card );
			if( _checkbox.find('input').prop('checked') ){
				_checkbox.removeClass('error-polit');
				_fh.find('button').click();
			}else{
				_checkbox.addClass('error-polit');
				log('Fail polit order!');
			}
		});

	}); /*end document.ready*/




/*ymaps init*/
ymaps.ready(function(){
	if( !LS.get( 'city' ) ){
		cityAJAX( ymaps.geolocation.city || 'Санкт-Петербург' );
	}else{
		$('#city,#city_fixed').text( LS.get( 'city' ) );
		cityAJAX( LS.get( 'city' ) );
	}
});

})(jQuery);
