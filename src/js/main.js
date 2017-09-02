var log = console.log;
;(function($){
	console.log('Include is main.js');
	var _w = $(window);




	console.log('Waves init');
	Waves.init();
	Waves.attach('.moveup', ['waves-circle', 'waves-float']);
	Waves.attach('.btn', ['waves-button','waves-light']);
	Waves.attach('.ribe', ['waves-block', 'waves-float']);



	var bookmarkLink;
	var basketLink;


	var numberStep = function(now, tween) {
		var floored_number = Math.floor(now), target = $(tween.elem);
		target.prop('number',floored_number).text( floored_number + ' руб.');
	};


	var bookmarkAJAX = function(id){
		$.get(bookmarkLink+'?ajax&id='+id)
		.done(function(data){
			log('Success bookmark',id);
			return !0;
		}).fail(function(data){
			log('Fail bookmark',id);
			return !1;
		});
	};


	var basketAJAX = function(id,count = 1){
		$.get(basketLink+'?ajax&id=' + id + ( count?'&count='+count:'&del' ) )
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
			return !0;
		}).fail(function(data){
			log('Fail city');
			return !1;
		});
	};
	$(document).ready(function(){
		console.log('Document ready');



		var min_price_for_free_delivery = parseInt( $('.radio-delivery input:checked').parents('label').data('free') ) || 0;


		console.log('SocialShareKit init');
		SocialShareKit.init();



		/*Links by bookmark & basket page*/
		bookmarkLink = $('.top-line .bookmark').attr('href');
		basketLink = $('.top-line .basket').attr('href');



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
		$('.nav-line .close.v1').click(function(){
			$(this).parents('.nav-line').css({'left':'100%'});
			// $('.menu-btn').toggleClass('tcon-transform');
		});
		$('.menu-btn').click(function(){
			$('.nav-line').css({'left':0});
			// $(this).toggleClass('tcon-transform');
		});

		$('.btn-filter').click(function(){
			$('.form-filter').stop().slideToggle();
		});



		/*Search show/hide string*/
		$('.search-btn').click(function(){
			$('.string-search,.bg-search').stop().fadeToggle();
			$('.wr-fetch').fadeOut();
			$(this).toggleClass('tcon-transform');
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
		$('.phone').mask('+7 (000) 000-00-00').click(function(){ if(!$(this).val()) $(this).val('+7 ('); });

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
				// log(ww);
				// log(hw);
				$('.slider').height( hw - h_header );
			},
			handleScroll = function(){
				var sw = $(this).scrollTop();
				if( sw > 200 ){
					$('#moveup').removeClass('scale-out');
					/*Когда ниже прокручиваешь то верхнее меню прилипает и появляется как только добавляеш в закладки*/
					$('.wr-const-top-line').addClass('fixed');
				}else{
					$('#moveup').addClass('scale-out');
					$('.wr-const-top-line').removeClass('fixed');
				}

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
				$('.form-filter input').not(
					$('.form-filter input[checked]')
				).prop('checked',!1);
				log( $('.form-filter input').not(
					$('.form-filter input[checked]')
				) );
				componentHandler.upgradeDom();
				sortF.apply( $('.form-filter input').first()[0] );
			});
		}


		/*textarea init*/
		$('.form-textarea').each(function(index, el){
			var _ = $(el);
			var _h = _.outerHeight();
			_.on('input',function(e){
				var _sc = _[0].scrollHeight;
				// console.log(_h,_sc);
				if( _h !== _sc){
					_.css( 'height', _sc );
					_h=_sc;
				}
			});
		});




		/*Tab init*/
		$('.item-control-tab').click(function(){
			var _ = $(this);
			_.siblings('.item-control-tab').removeClass('active');
			if(_.hasClass('active')) return;
			_.addClass('active');
			$('.item-tab.active').stop().fadeOut(function(){
				$(this).removeClass('active');
				$( _.data('tab') ).stop().fadeIn(function(){
					$(this).addClass('active');
				});
			});
		});




		/*Pay One Click init*/
		$('#pay-one-click').click(function(){
			var _ = $(this);
			var _p = _.parents('.main-info');
			_.add('#add-basket,.main-info .bookmark').stop().fadeOut(function(){
				$('#input-phone,#make-order').stop().fadeIn(function(){});
				_p.find('.close.v1').css('display','inline-block');
			});
		});
		$('.bl-order .close.v1').click(function(){
			var _ = $(this);
			var _p = _.parents('.main-info');
			_.add('#input-phone,#make-order').stop().fadeOut(function(){
				$('#pay-one-click,#add-basket').stop().fadeIn();
				$('.main-info .bookmark').css('display','inline-block');
			});
		});




		/*item-faq init*/
		$('.item-faq').click(function(){
			$(this).toggleClass('active').find('.answer').stop().slideToggle();
		});




		/*#city init*/
		$('.bl-city').click(function(){
			$(this).find('.bl-search-city').stop().fadeIn(function(){$(this).addClass('active');});
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
			/*Убрать из корзины поместиь в закладки"*/
			jq.find('.add-in-bookmark').click(function(e){
				e.preventDefault();
				var _ = $(this).parents('.item-card');
				_.find('.bl-del-select').stop().fadeOut();
				Bookmark.addCard(_.attr('id'));
				bookmarkAJAX(_.attr('id'));
				$('[data-id*="'+_.attr('id')+'"]').find('.btni.bookmark').addClass('active');
				_.find('.del').click();
			});
			/*Убрать из закладок"*/
			jq.find('.del-in-bookmark').click(function(e){
				e.preventDefault();
				var _ = $(this).parents('.item-card');
				_.find('.bl-del-select').stop().fadeOut();
				Bookmark.removeCard(_.attr('id'));
				bookmarkAJAX(_.attr('id'));
				$('[data-id*="'+_.attr('id')+'"]').find('.btni.bookmark').removeClass('active');
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
				var sale_price = parseInt( Basket.getOldTotal() ) - total;
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
			return jq;
		};
		btnInit($('body'));

		/*Функция для изменения верхнего меню*/
		var d;
		var cloneCardTemplate = function(_){
			var _c = $('#template .item-card').clone();
			_c.attr('id',_.id);
			_c.find('.img').css({
				backgroundImage: 'url('+_.img.replace('"','')+')'
			});
			_c.find('.title-card').text(_.title);
			_c.find('.fi-d').val(_.count);
			_c.find('.price-card').text(_.price + ' руб.');
			_c.find('.price-total').text( _.price * _.count + ' руб.');
			_c.find('.oldprice-card').text(_.oldprice + ' руб.');
			if( _.oldprice ) _c.find('.oldprice-card').show();
			else _c.find('.oldprice-card').hide();
			return _c;
		};
		// Bookmark & Basket init functional
		var basketBadget = $('#basket-badget');
		var bookmarkBadget = $('#bookmark-badget');

		Basket.init(function(_){
			_.getCard().forEach(function(el,id,arr){
				$('.bl-card.another-card').append( btnInit( cloneCardTemplate( el ) ) );
			});
			if( !!_.getCountCard() ){
				basketBadget.stop().fadeIn().text( _.getCountCard() );
				basketBadget.parents('.basket').addClass('active');
			}else basketBadget.stop().fadeOut().parents('.basket').removeClass('active');
			_.getCard().forEach(function(el){
				$('[data-id*="'+el.id+'"]').find('.btni.basket').addClass('active');
			});
		});
		Bookmark.init(function(_){
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
				basketBadget.stop().fadeIn().text( Basket.getCountCard() );
				basketBadget.parents('.basket').addClass('active');
			}else{
				basketBadget.stop().fadeOut().parents('.basket').removeClass('active');
				$('.iziModal').iziModal('close');
			}
			if( !!Bookmark.getCountCard() ){
				bookmarkBadget.stop().fadeIn().text( Bookmark.getCountCard() );
				bookmarkBadget.parents('.bookmark').addClass('active');
			}else{
				bookmarkBadget.stop().fadeOut().parents('.bookmark').removeClass('active');
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

		//Additing product in bookmark
		$('.btni.bookmark').click(function(e){
			e.preventDefault();
			var _ = $(this);
			_.find('.like').toggleClass('anim');
			var _p = _.toggleClass('active').parents('.item-card,.main-info');
			if( _p.data('id') ){
				Bookmark.addCard( _p.data('id') );
				bookmarkAJAX( _p.data('id') );
				document.dispatchEvent(BasketBookmark);
			}else{
				log(_, _p);
				throw('ID error');
			}
		});

		$('.btni.bookmark').each(function(id,el){
			var _ = $(el);
			_.find('.like').css({
				top: _.height()/2 - 50,
				left: _.width()/2 - 50
			});
		});

		//Additing product in basket
		$('.btni.basket').click(function(e){
			var _ = $(this).addClass('active').parents('.item-card');
			var el = Basket.nobj(
				_.data('id'),
				_.find('.title-card').text(),
				_.find('.img').css('background-image'),
				1,
				_.find('.price').text(),
				_.find('.old-price').text()
			);
			basketAJAX(_.data('id'));
			if( Basket.addCard(el) ){
				var clone = cloneCardTemplate(el);
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
				_.find('img').attr('src'),
				_.find('.bl-count .count .fi-d').val(),
				_.find('.price').text(),
				_.find('.old-price').text()
			);
			basketAJAX(_.data('id'),el.count);
			// Basket.addCard(el);
			if( Basket.addCard(el) ){
				var clone = cloneCardTemplate(el);
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
			$.get( _.attr('href') + '?ajax&page='+_.data('page')).done(function(data){
				$('.more-bl').append( data );
			}).fail(function(data){
				log('Fail');
			});
		});
		// AJAX поиск товаров
		$query = !1;
		$query_str = '';
		$('.string-search input').on('input',function(e){
			$query_str = $(this).val();
			$query = !0;
		});
		setInterval(function(){
			if( $query ){
				$('.wr-fetch').fadeIn();
				var _ = $('.wr-fetch');
				$.get( '/?s='+$query_str ).done(function(data){
					_.html( data );
				}).fail(function(data){
					log('Fail');
				});
				$query = !1;
			}
		},1000);
		log('Kladr init');
		/*Автозаполнение города*/
		$('#city').parents('.bl-city').find('.fi-d').kladr({
				type: $.kladr.type.city,
				typeCode: $.kladr.typeCode.city,
				select: function(obj){
					LS.set('city',obj.name)
					$('#city').text(obj.name);
					$('.bl-search-city').fadeOut();
					cityAJAX(obj.name);
				}
		});
		var deliveryClick = function(){
			var _ = $(this);
			var total = parseInt( Basket.getTotal() );
			min_price_for_free_delivery = _.data('free');
			var delivery = ( min_price_for_free_delivery > total ? parseInt( _.data('price') ) || 0 : 0);
			if( _.hasClass('delivery-pickup') ){
				$('.form-textarea').stop().fadeOut(function(){
					$('.wr-maps').stop().fadeIn();
				});
			}else{
				$('.wr-maps').stop().fadeOut(function(){
					$('.form-textarea').stop().fadeIn();
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
				}) ) location.href= basketLink;
			};
			$('.wr-card .item-card').each(function(id,el){
				var _ = $(this);
				var el = Basket.nobj(
					_.data('id'),
					_.find('.title-card').text(),
					_.find('.img').css('background-image'),
					1,
					_.find('.price').text(),
					_.find('.old-price').text()
				);
				Basket.addCard(el);
				arr_ajax_request[id] = !1;
				$.get(basketLink+'?ajax&id=' + _.data('id') + '&count=1' )
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



	}); /*end document.ready*/




/*ymaps init*/
ymaps.ready(function(){
	if( !LS.get( 'city' ) ){
		$('#city').text( ymaps.geolocation.city || 'Санкт-Петербург' );
		LS.set( 'city', ymaps.geolocation.city || 'Санкт-Петербург');
		cityAJAX( ymaps.geolocation.city );
	}else $('#city').text( LS.get( 'city' ) );
});

})(jQuery);
