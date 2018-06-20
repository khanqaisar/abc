(function($) {
	'use strict';

	var martfury = martfury || {};
	martfury.init = function() {
		martfury.$body = $(document.body),
			martfury.$window = $(window),
			martfury.$header = $('#site-header');

		// Preloader
		this.preLoader();
		this.newLetterPopup();
		// Header
		this.stickyHeader();
		this.productSearchLabel();
		this.headerMenu();
		this.instanceSearch();
		this.topPromotion();
		this.mobileMenu();

		// Page Header
		this.pageHeaderParallax();

		// Blog
		this.postEntryFormat();
		this.singleEntryFormat();
		this.blogLoadingAjax();
		this.relatedPost();
		this.blogLayout();

		// Lazy Load
		this.lazyLoad();
		this.backToTop();

		// Catalog
		this.recentlyViewedProducts();
		this.catalogBanners();
		this.productsTopCarousel();
		this.productCategoriesWidget();
		this.toolTipIcon();
		this.searchLayeredNav();
		this.productAttribute();
		this.shopView();
		this.addWishlist();
		this.addCompare();
		this.productQuickView();
		this.variationImagesCarousel();
		this.productTopCategories();
		this.filterAjax();

		// Single Product
		this.hoverProductTabs();
		this.productQuantity();
		this.productThumbnail();
		this.productGallery();
		this.productDegree();
		this.singleProductCarousel();
		this.fbtProduct();
		this.fbtAddToCartAjax();
		this.fbtAddToWishlistAjax();
		this.instagramCarousel();
		this.productVatiation();
		this.addToCartAjax();

		$(document.body).on('martfury_get_products_ajax_success', function() {
			martfury.toolTipIcon();
		});

	};

	// preloader
	martfury.preLoader = function() {

		if ( !martfury.$body.hasClass('mf-preloader') ) {
			return;
		}

		NProgress.start();
		martfury.$window.on('load', function() {
			NProgress.done();
			$('#page').addClass('fade-in');
		});
	};

	// Sticky Header
	martfury.stickyHeader = function() {

		if ( !martfury.$body.hasClass('sticky-header') ) {
			return;
		}

		var scrollTop = 0,
			$hmain = martfury.$header.find('.header-main-wapper'),
			heightMain = $hmain.outerHeight() - 18,
			$promotion = $('#top-promotion'),
			hPromotion = $promotion.length > 0 ? $promotion.outerHeight(true) : 0,
			$topbar = $('#topbar'),
			hTopbar = $topbar.length > 0 ? $topbar.outerHeight(true) : 0,
			hHeader = martfury.$header.outerHeight(true);

		scrollTop = hTopbar + hPromotion + hHeader;
		martfury.$window.on('scroll', function() {
			if ( $promotion.length > 0 && $promotion.hasClass('invisible') ) {
				scrollTop = hHeader + hTopbar;
			}
			if ( martfury.$window.scrollTop() > scrollTop ) {
				martfury.$header.addClass('minimized');
				$hmain.css({
					'padding-top': heightMain
				});
			} else {
				martfury.$header.removeClass('minimized');
				$hmain.removeAttr('style');
			}
		});

	};

	martfury.topPromotion = function() {

		var $topPromotion = $('#top-promotion');

		if ( $topPromotion.length < 1 ) {
			return;
		}
		// Toggle promotion
		$topPromotion.on('click', '.close', function(e) {
			e.preventDefault();

			$topPromotion.slideUp().addClass('invisible');
		});

	};

	/**
	 * Off canvas cart toggle
	 */
	martfury.mobileMenu = function() {
		var $mobileMenu = $('#primary-mobile-nav');
		martfury.$header.on('click', '#mf-toggle-menu', function(e) {
			e.preventDefault();
			martfury.$body.toggleClass('display-mobile-menu');
		});

		$mobileMenu.find('.menu .menu-item-has-children > a').prepend('<span class="toggle-menu-children"><i class="icon-plus"></i> </span>');


		$mobileMenu.on('click', '.menu-item-has-children > a', function(e) {
			e.preventDefault();
			var $el = $(this);
			$el.closest('li').siblings().find('ul').slideUp();
			$el.closest('li').siblings().removeClass('active');
			$el.closest('li').siblings().find('li').removeClass('active');

			$el.closest('li').children('ul').slideToggle();
			$el.closest('li').toggleClass('active');

		});


		$mobileMenu.on('click', '.close-canvas-mobile-panel', function(e) {
			e.preventDefault();
			martfury.$body.removeClass('display-mobile-menu');
		});

		$('#mf-off-canvas-layer').on('click', function(e) {
			e.preventDefault();
			martfury.$body.removeClass('display-mobile-menu');
		});

		martfury.$window.on('resize', function() {
			if ( martfury.$window.width() > 1200 ) {
				martfury.$body.removeClass('display-mobile-menu');
			}
		});

	};


	// Newsletter popup

	martfury.newLetterPopup = function() {
		var $modal = $('#mf-newsletter-popup'),
			days = parseInt(martfuryData.nl_days),
			seconds = parseInt(martfuryData.nl_seconds);

		if ( $modal.length < 1 ) {
			return;
		}

		martfury.$window.on('load', function() {
			setTimeout(function() {
				$modal.addClass('open');
			}, seconds * 1000);
		});

		$modal.on('click', '.close-modal', function(e) {
			e.preventDefault();
			closeNewsLetter(days);
			$modal.removeClass('open');
			$modal.fadeOut();
		});

		$modal.on('click', '.n-close', function(e) {
			e.preventDefault();
			closeNewsLetter(30);
			$modal.removeClass('open');
			$modal.fadeOut();
		});

		$modal.find('.mc4wp-form').submit(function() {
			closeNewsLetter(days);
		});

		function closeNewsLetter(days) {
			var date = new Date(),
				value = date.getTime();

			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

			document.cookie = 'mf_newletter=' + value + ';expires=' + date.toGMTString() + ';path=/';
		}
	};

	// Back to top scroll
	martfury.backToTop = function() {
		var $scrollTop = $('#scroll-top');
		martfury.$window.scroll(function() {
			if ( martfury.$window.scrollTop() > martfury.$window.height() ) {
				$scrollTop.addClass('show-scroll');
			} else {
				$scrollTop.removeClass('show-scroll');
			}
		});

		// Scroll effect button top
		$scrollTop.on('click', function(event) {
			event.preventDefault();
			$('html, body').stop().animate({
					scrollTop: 0
				},
				800
			);
		});
	};

	martfury.headerMenu = function() {
		if ( martfury.$header.find('.products-cats-menu').length > 0 ) {
			var leftDep = martfury.$header.find('.products-cats-menu').position().left;
			martfury.$header.find('.toggle-product-cats').css({
				left: leftDep * -1
			});
		}


		martfury.$header.find('.primary-nav .menu-item.is-mega-menu').each(function() {
			var wsubWidth = $(this).children('.dropdown-submenu').width(),
				parentWidth = $(this).closest('.col-header-menu').width(),
				wWidth = $(this).outerWidth(),
				offsetLeft = $(this).position().left + (wWidth / 2),
				offsetRight = (parentWidth - $(this).position().left) + (wWidth / 2),
				left = offsetLeft - (wsubWidth / 2),
				right = offsetRight - (wsubWidth / 2);

			if ( right < 0 ) {
				$(this).removeClass('has-width').addClass('align-right');
			} else if ( left < 0 ) {
				$(this).removeClass('has-width').addClass('align-left');
			}

		});

	};

	// Product Search
	martfury.productSearchLabel = function() {
		martfury.$header.on('change', '#product_cat', function() {
			var value = $(this).find('option:selected').text().trim();
			martfury.$header.find('.product-cat-label').html(value);
		});
	};


	// post format
	martfury.postEntryFormat = function() {
		if ( !martfury.$body.hasClass('mf-blog-page') ) {
			return;
		}

		var $entryFormat = $('.blog-wapper').find('.entry-format');

		$entryFormat.find('.slides').not('.slick-initialized').slick({
			slidesToShow  : 1,
			slidesToScroll: 1,
			infinite      : false,
			prevArrow     : '<span class="ion-ios-arrow-left slick-prev-arrow"></span>',
			nextArrow     : '<span class="ion-ios-arrow-right slick-next-arrow"></span>'
		});

		$('.blog-wapper').find('.entry-format').fitVids({customSelector: 'iframe, video'});


	};


	// tooltip icon
	martfury.toolTipIcon = function() {

		$('.catalog-sidebar').find('[data-rel=tooltip]').tooltip({
			classes     : {'ui-tooltip': 'martfury-tooltip'},
			tooltipClass: 'martfury-tooltip',
			position    : {my: 'center bottom', at: 'center top-13'},
			create      : function() {
				$('.ui-helper-hidden-accessible').remove();
			}
		});

		$('.mf-product-thumbnail, .mf-single-product:not(.mf-product-layout-3)').find('[data-rel=tooltip]').tooltip({
			classes     : {'ui-tooltip': 'martfury-tooltip'},
			tooltipClass: 'martfury-tooltip',
			position    : {my: 'center bottom', at: 'center top-13'},
			create      : function() {
				$('.ui-helper-hidden-accessible').remove();
			}
		});

		$('.mf-product-thumbnail, .mf-single-product:not(.mf-product-layout-3)').find('.compare').tooltip({
			content     : function() {
				return $(this).html();
			},
			classes     : {'ui-tooltip': 'martfury-tooltip'},
			tooltipClass: 'martfury-tooltip',
			position    : {my: 'center bottom', at: 'center top-13'},
			create      : function() {
				$('.ui-helper-hidden-accessible').remove();
			}
		});

		$(document.body).on('added_to_cart', function() {
			$('.mf-product-thumbnail').find('.added_to_cart').tooltip({
				offsetTop   : -15,
				content     : function() {
					return $(this).html();
				},
				classes     : {'ui-tooltip': 'martfury-tooltip'},
				tooltipClass: 'martfury-tooltip',
				position    : {my: 'center bottom', at: 'center top-13'},
				create      : function() {
					$('.ui-helper-hidden-accessible').remove();
				}
			});
		});
	};

	// add compare
	martfury.variationImagesCarousel = function() {
		var $variation = $('.woocommerce ul.products li.product').find('.mf-attr-swatches-slick');
		$variation.not('.slick-initialized').slick({
			slidesToShow  : 3,
			slidesToScroll: 3,
			infinite      : false,
			prevArrow     : '<span class="icon-chevron-left slick-prev-arrow"></span>',
			nextArrow     : '<span class="icon-chevron-right  slick-next-arrow"></span>'
		});
	};

	// add wishlist
	martfury.addWishlist = function() {
		$('ul.products li.product .yith-wcwl-add-button').on('click', 'a', function() {
			$(this).addClass('loading');
		});

		martfury.$body.on('added_to_wishlist', function() {
			$('ul.products li.product .yith-wcwl-add-button a').removeClass('loading');
		});

		// update wishlist count
		martfury.$body.on('added_to_wishlist removed_from_wishlist', function() {
			$.ajax({
				url     : martfuryData.ajax_url,
				dataType: 'json',
				method  : 'post',
				data    : {
					action: 'update_wishlist_count'
				},
				success : function(data) {
					martfury.$header.find('.menu-item-wishlist .mini-item-counter').html(data);
				}
			});
		});

	};

	// add compare
	martfury.addCompare = function() {

		martfury.$body.on('click', 'a.compare:not(.added)', function() {
			var $el = $(this);
			$el.addClass('loading');

			$el.closest('.product-inner').find('.compare:not(.loading)').trigger('click');
		});

	};


	/**
	 * Change product quantity
	 */
	martfury.productQuantity = function() {
		martfury.$body.on('click', '.quantity .increase, .quantity .decrease', function(e) {
			e.preventDefault();

			var $this = $(this),
				$qty = $this.siblings('.qty'),
				current = parseInt($qty.val(), 10),
				min = parseInt($qty.attr('min'), 10),
				max = parseInt($qty.attr('max'), 10);

			min = min ? min : 1;
			max = max ? max : current + 1;

			if ( $this.hasClass('decrease') && current > min ) {
				$qty.val(current - 1);
				$qty.trigger('change');
			}
			if ( $this.hasClass('increase') && current < max ) {
				$qty.val(current + 1);
				$qty.trigger('change');
			}
		});
	};

	/**
	 * Change product quantity
	 */
	martfury.productThumbnail = function() {
		var $gallery = $('.woocommerce-product-gallery');
		var $video = $gallery.find('.woocommerce-product-gallery__image.mf-product-video');
		var $thumbnail = $gallery.find('.flex-control-thumbs');
		$gallery.imagesLoaded(function() {
			setTimeout(function() {
				if ( $thumbnail.length < 1 ) {
					return;
				}
				var columns = $gallery.data('columns');
				var count = $thumbnail.find('li').length;
				if ( count > columns ) {
					if ( !$('.mf-single-product').hasClass('mf-product-sidebar') ) {
						$thumbnail.not('.slick-initialized').slick({
							slidesToShow  : columns,
							slidesToScroll: 1,
							focusOnSelect : true,
							vertical      : true,
							infinite      : false,
							prevArrow     : '<span class="icon-chevron-up slick-prev-arrow"></span>',
							nextArrow     : '<span class="icon-chevron-down slick-next-arrow"></span>'
						});

						$thumbnail.find('li.slick-current').trigger('click');
					} else {
						$thumbnail.not('.slick-initialized').slick({
							slidesToShow  : columns,
							focusOnSelect : true,
							slidesToScroll: 1,
							infinite      : false,
							prevArrow     : '<span class="icon-chevron-left slick-prev-arrow"></span>',
							nextArrow     : '<span class="icon-chevron-right slick-next-arrow"></span>'
						});
					}
				} else {
					$thumbnail.addClass('no-slick');
				}

				if ( $video.length > 0 ) {
					$('.woocommerce-product-gallery').addClass('has-video');
					$thumbnail.find('li').last().append('<i class="i-video fa fa-play"></i>');
				}
			}, 100);

		});

		if ( $video.length < 1 ) {
			return;
		}

		var found = false,
			last = false;

		$thumbnail.on('click', 'li', function() {

			var $video = $gallery.find('.mf-product-video');

			var thumbsCount = $(this).siblings().length;

			last = true;
			if ( $(this).index() == thumbsCount ) {
				last = false;
				found = false;
			}

			if ( !found && last ) {
				var $iframe = $video.find('iframe'),
					$wp_video = $video.find('video.wp-video-shortcode');

				if ( $iframe.length > 0 ) {
					$iframe.attr('src', $iframe.attr('src'));
				}
				if ( $wp_video.length > 0 ) {
					$wp_video[0].pause();
				}
				found = true;
			}

			return false;

		});

		$thumbnail.find('li').on('click', '.i-video', function(e) {
			e.preventDefault();
			$(this).closest('li').find('img').trigger('click');
		});
	};

	/**
	 * Show photoSwipe lightbox
	 */
	martfury.productGallery = function() {
		var $images = $('.woocommerce-product-gallery');

		if ( !$images.length ) {
			return;
		}

		$images.find('.woocommerce-product-gallery__image').hover(function() {
			$(this).closest('.woocommerce-product-gallery').find('.ms-image-view').removeClass('hide');
			$(this).closest('.woocommerce-product-gallery').find('.ms-image-zoom').addClass('hide');
		}, function() {
			$(this).closest('.woocommerce-product-gallery').find('.ms-image-view').addClass('hide');
			$(this).closest('.woocommerce-product-gallery').find('.ms-image-zoom').removeClass('hide');
		});

		$images.on('click', '.woocommerce-product-gallery__image', function(e) {
			e.preventDefault();

			if ( $(this).hasClass('mf-product-video') ) {
				return false;
			}

			var items = [];
			var $links = $(this).closest('.woocommerce-product-gallery').find('.woocommerce-product-gallery__image');
			$links.each(function() {
				var $el = $(this);
				if ( $el.hasClass('mf-product-video') ) {
					items.push({
						html: $el.children('a').attr('href')
					});

				} else {
					items.push({
						src: $el.children('a').attr('href'),
						w  : $el.find('img').attr('data-large_image_width'),
						h  : $el.find('img').attr('data-large_image_height')
					});
				}

			});

			var index = $links.index($(this)),
				options = {
					index              : index,
					bgOpacity          : 0.85,
					showHideOpacity    : true,
					mainClass          : 'pswp--minimal-dark',
					barsSize           : {top: 0, bottom: 0},
					captionEl          : false,
					fullscreenEl       : false,
					shareEl            : false,
					tapToClose         : true,
					tapToToggleControls: false
				};

			var lightBox = new PhotoSwipe(document.getElementById('pswp'), window.PhotoSwipeUI_Default, items, options);
			lightBox.init();

			lightBox.listen('close', function() {
				$('.mf-video-wrapper').find('iframe').each(function() {
					$(this).attr('src', $(this).attr('src'));
				});

				$('.mf-video-wrapper').find('video').each(function() {
					$(this)[0].pause();
				});
			});
		});
	};

	/**
	 * Show product 360 degree
	 */
	martfury.productDegree = function() {
		var $product_degrees = $('.woocommerce-product-gallery .product-degree-images');

		if ( $product_degrees.length < 1 ) {
			return;
		}

		if ( martfuryData.product_degree.length < 1 ) {
			return;
		}
		var degree = '',
			$pswp = $('#product-degree-pswp');
		$product_degrees.on('click', function(e) {
			e.preventDefault();
			martfury.openModal($pswp);
			if ( $pswp.hasClass('init') ) {
				return;
			}
			$pswp.addClass('init');
			var imgArray = martfuryData.product_degree.split(','),
				images = [];

			for ( var i = 0; i < imgArray.length; i++ ) {
				images.push(imgArray[i]);
			}
			degree = $pswp.find('.mf-product-gallery-degree').ThreeSixty({
				totalFrames : images.length, // Total no. of image you have for 360 slider
				endFrame    : images.length, // end frame for the auto spin animation
				currentFrame: 1, // This the start frame for auto spin
				imgList     : $pswp.find('.product-degree-images'), // selector for image list
				progress    : '.mf-gallery-degree-spinner', // selector to show the loading progress
				imgArray    : images, // path of the image assets
				height      : 500,
				width       : 830,
				navigation  : false
			});

			$pswp.find('.product-degree-images').imagesLoaded(function() {
				$pswp.find('.nav_bar').removeClass('hide');
			});

			$pswp.find('.nav_bar_previous').on('click', function() {
				degree.previous();
			});

			$pswp.find('.nav_bar_next').on('click', function() {
				degree.next();
			});

			$pswp.find('.nav_bar_play').on('click', function() {
				if ( $(this).hasClass('play') ) {
					degree.stop();
					$(this).removeClass('play');
				} else {
					degree.play();
					$(this).addClass('play');
				}

			});

			$pswp.on('click', '.degree-pswp-close, .degree-pswp-bg', function() {
				degree.stop();
				$(this).removeClass('play');
			});


		});

		$pswp.on('click', '.degree-pswp-close, .degree-pswp-bg', function() {
			martfury.closeModal($pswp);
		});

	};

	/**
	 * Open modal
	 *
	 * @param $modal
	 */
	martfury.openModal = function($modal) {
		$modal.fadeIn();
		$modal.addClass('open');
	};

	/**
	 * Close modal
	 */
	martfury.closeModal = function($modal) {
		$modal.fadeOut(function() {
			$(this).removeClass('open');
		});
	};

	/**
	 * Change product quantity
	 */
	martfury.hoverProductTabs = function() {
		var $el, leftPos, newWidth, $origWidth, childWidth,
			$mainNav = $('.mf-single-product .woocommerce-tabs').find('ul.wc-tabs');

		if ( $mainNav.length < 1 ) {
			return;
		}

		$mainNav.append('<li id="tl-wc-tab" class="tl-wc-tab"></li>');
		var $magicLine = $('#tl-wc-tab');

		childWidth = $mainNav.children('li.active').outerWidth();
		$magicLine
			.width(childWidth)
			.css('left', $mainNav.children('li.active').position().left)
			.data('origLeft', $magicLine.position().left)
			.data('origWidth', $magicLine.width());

		$origWidth = $magicLine.data('origWidth');

		$mainNav.children('li').hover(function() {
			$el = $(this);
			newWidth = $el.outerWidth();
			leftPos = $el.position().left;
			$magicLine.stop().animate({
				left : leftPos,
				width: newWidth
			});

		}, function() {
			$magicLine.stop().animate({
				left : $magicLine.data('origLeft'),
				width: $origWidth
			});
		});

		$mainNav.on('click', 'li', function() {
			$el = $(this);
			$origWidth = newWidth = $el.outerWidth();
			leftPos = $el.position().left;
			$magicLine.stop().animate({
				left : leftPos,
				width: newWidth
			});
			$magicLine
				.data('origLeft', leftPos)
				.data('origWidth', newWidth);

		});
	};

	martfury.searchLayeredNav = function() {

		var $widgets = $('.mf-widget-layered-nav');

		if ( $widgets.length < 1 ) {
			return;
		}

		$widgets.find('.mf-widget-layered-nav-scroll').each(function() {
			var heightUL = $(this).data('height');
			if ( $(this).height() > parseInt(heightUL) ) {
				$(this).slimScroll({
					height       : heightUL,
					railVisible  : true,
					alwaysVisible: true,
					size         : '6px',
					color        : '#666',
					railColor    : '#ccc',
					railOpacity  : 1
				});
			}
		});


		$widgets.on('keyup', '.mf-input-search-nav', function(e) {
			var valid = false;

			if ( typeof e.which == 'undefined' ) {
				valid = true;
			} else if ( typeof e.which == 'number' && e.which > 0 ) {
				valid = !e.ctrlKey && !e.metaKey && !e.altKey;
			}

			if ( !valid ) {
				return;
			}

			var filter = $(this).val().toUpperCase(),
				widget = $(this).closest('.mf-widget-layered-nav'),
				ul = widget.find('.woocommerce-widget-layered-nav-list'),
				items = ul.children('.wc-layered-nav-term');

			items.each(function() {
				var a = $(this).find('a').data('title').toUpperCase();
				if ( a.indexOf(filter) > -1 ) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
			var heightUL = ul.data('height');
			if ( ul.height() < parseInt(heightUL) ) {
				widget.addClass('no-scroll');
			} else {
				widget.removeClass('no-scroll');
			}
		});

	};

	/**
	 * Product instance search
	 */
	martfury.instanceSearch = function() {

		var xhr = null,
			searchCache = {},
			$form = martfury.$header.find('.products-search');

		$form.on('keyup', '.search-field', function(e) {
			var valid = false;

			if ( typeof e.which == 'undefined' ) {
				valid = true;
			} else if ( typeof e.which == 'number' && e.which > 0 ) {
				valid = !e.ctrlKey && !e.metaKey && !e.altKey;
			}

			if ( !valid ) {
				return;
			}

			if ( xhr ) {
				xhr.abort();
			}

			var $currentForm = $(this).closest('.products-search'),
				$search = $currentForm.find('input.search-field');

			if ( $search.val().length < 2 ) {
				$currentForm.removeClass('searching searched actived found-products found-no-product invalid-length');
			}

			search($currentForm);
		}).on('change', '#product_cat', function() {
			if ( xhr ) {
				xhr.abort();
			}

			var $currentForm = $(this).closest('.products-search');

			search($currentForm);
		}).on('focusout', '.search-field', function() {
			var $currentForm = $(this).closest('.products-search'),
				$search = $currentForm.find('input.search-field');
			if ( $search.val().length < 2 ) {
				$currentForm.removeClass('searching searched actived found-products found-no-product invalid-length');
			}
		});


		$(document).on('click', function(e) {
			if ( !$form.hasClass('actived') ) {
				return;
			}
			var target = e.target;

			if ( $(target).closest('.products-search').length < 1 ) {
				$form.removeClass('searching searched actived found-products found-no-product invalid-length');
			}
		});


		/**
		 * Private function for search
		 */
		function search($currentForm) {
			var $search = $currentForm.find('input.search-field'),
				keyword = $search.val(),
				cat = 0,
				$results = $currentForm.find('.search-results');

			if ( $currentForm.find('#product_cat').length > 0 ) {
				cat = $currentForm.find('#product_cat').val();
			}


			if ( keyword.length < 2 ) {
				$currentForm.removeClass('searching found-products found-no-product').addClass('invalid-length');
				return;
			}

			$currentForm.removeClass('found-products found-no-product').addClass('searching');

			var keycat = keyword + cat;

			if ( keycat in searchCache ) {
				var result = searchCache[keycat];

				$currentForm.removeClass('searching');

				$currentForm.addClass('found-products');

				$results.html(result.products);

				$(document.body).trigger('martfury_ajax_search_request_success', [$results]);

				$currentForm.removeClass('invalid-length');

				$currentForm.addClass('searched actived');
			} else {
				xhr = $.ajax({
					url     : martfuryData.ajax_url,
					dataType: 'json',
					method  : 'post',
					data    : {
						action     : 'martfury_search_products',
						nonce      : martfuryData.nonce,
						term       : keyword,
						cat        : cat,
						search_type: martfuryData.search_content_type
					},
					success : function(response) {
						var $products = response.data;

						$currentForm.removeClass('searching');


						$currentForm.addClass('found-products');

						$results.html($products);

						$currentForm.removeClass('invalid-length');

						$(document.body).trigger('martfury_ajax_search_request_success', [$results]);

						// Cache
						searchCache[keycat] = {
							found   : true,
							products: $products
						};


						$currentForm.addClass('searched actived');
					}
				});
			}
		}
	};


	// single entry thumbnail
	martfury.singleEntryFormat = function() {
		if ( !martfury.$body.hasClass('single-post') ) {
			return;
		}

		$('.single-post-header.layout-2').find('.featured-image').parallax('50%', 0.6);

		var $entryFormat = $('#mf-single-entry-format');

		$entryFormat.find('.slides').not('.slick-initialized').slick({
			slidesToShow  : 1,
			slidesToScroll: 1,
			infinite      : false,
			prevArrow     : '<span class="ion-ios-arrow-left slick-prev-arrow"></span>',
			nextArrow     : '<span class="ion-ios-arrow-right slick-next-arrow"></span>'
		});

		$entryFormat.fitVids({customSelector: 'iframe, video'});

	};

	// Blog isotope
	martfury.blogLayout = function() {
		if ( !martfury.$body.hasClass('blog-layout-masonry') ) {
			return;
		}
		martfury.$body.imagesLoaded(function() {
			martfury.$body.find('.mf-post-list').isotope({
				itemSelector: '.blog-wapper',
				layoutMode  : 'masonry'
			});

		});
	};

	// Related Post
	martfury.relatedPost = function() {
		if ( !martfury.$body.hasClass('single-post') ) {
			return;
		}

		var $related = $('#mf-related-posts').find('.related-posts-list');

		$related.not('.slick-initialized').slick({
			slidesToShow  : 3,
			slidesToScroll: 1,
			dots          : true,
			infinite      : false,
			arrows        : false,
			responsive    : [
				{
					breakpoint: 768,
					settings  : {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 480,
					settings  : {
						slidesToShow: 1
					}
				}
			]
		});

		$related.on('afterChange', function() {
			martfury.lazyLoad();
		});
	};

	// Loading Ajax
	martfury.blogLoadingAjax = function() {

		martfury.$window.on('scroll', function() {
			if ( martfury.$body.find('#mf-infinite-loading').is(':in-viewport') ) {
				martfury.$body.find('#mf-infinite-loading').trigger('click');
			}

		}).trigger('scroll');

		// Blog page
		martfury.$body.on('click', '#mf-infinite-loading', function(e) {
			e.preventDefault();

			if ( $(this).data('requestRunning') ) {
				return;
			}

			$(this).data('requestRunning', true);


			var $postList = martfury.$body.find('.mf-post-list'),
				$pagination = $(this).parents('.navigation');

			$.get(
				$(this).closest('.page-numbers').attr('href'),
				function(response) {
					var content = $(response).find('.mf-post-list').children('.blog-wapper'),
						$pagination_html = $(response).find('.navigation').html();

					$pagination.html($pagination_html);

					$postList.append(content);
					$pagination.find('a').data('requestRunning', false);

					martfury.lazyLoad();
					martfury.postEntryFormat();

				}
			);
		});

	};

	martfury.pageHeaderParallax = function() {

		if ( !$('.page-header').hasClass('page-header-sliders') ) {
			return;
		}

		var $pageHeader = $('.page-header-sliders'),
			speed = $pageHeader.data('speed'),
			autoplay = $pageHeader.data('auto');
		$pageHeader.find('ul').not('.slick-initialized').slick({
			slidesToShow  : 1,
			slidesToScroll: 1,
			infinite      : true,
			autoplaySpeed : speed,
			autoplay      : autoplay,
			arrows        : false
		});

		$pageHeader.on('click', '.slick-prev-arrow', function() {
			$pageHeader.find('ul').slick('slickPrev');
		});

		$pageHeader.on('click', '.slick-next-arrow', function() {
			$pageHeader.find('ul').slick('slickNext');
		});
	};

	/**
	 * LazyLoad
	 */
	martfury.lazyLoad = function() {
		martfury.$body.find('img.lazy').lazyload({
			load: function() {
				$(this).removeClass('lazy');
			}
		});

		martfury.$window.on('load', function() {
			$('.mf-products-list-carousel').find('img.lazy').lazyload({
				load: function() {
					$(this).removeClass('lazy');
				}
			}).trigger('appear');
		})
	};

	// Recently Viewed Products
	martfury.recentlyViewedProducts = function() {
		footerRecentlyProducts();
		footerBotRecentlyProducts();
		headerRecentlyProducts();

		function footerRecentlyProducts() {
			var $recently = $('#footer-recently-viewed');
			if ( $recently.length <= 0 ) {
				return;
			}

			if ( !$recently.hasClass('load-ajax') ) {
				return;
			}

			if ( $recently.hasClass('loaded') ) {
				return;
			}

			$.ajax({
				url     : martfuryData.ajax_url,
				dataType: 'json',
				method  : 'post',
				data    : {
					action: 'martfury_footer_recently_viewed',
					nonce : martfuryData.nonce
				},
				success : function(response) {
					$recently.html(response.data);
					if ( $recently.find('.product-list').hasClass('no-products') ) {
						$recently.addClass('no-products');
					}
					martfury.lazyLoad();
					recentlyCarousel($recently);
					$recently.addClass('loaded');
				}
			});
		}

		function footerBotRecentlyProducts() {
			var $history = $('#footer-history-products'),
				found = true,
				$recently = $('#footer-recently-viewed'),
				$layer = $('#mf-off-canvas-layer');

			if ( $history.length <= 0 ) {
				return;
			}

			$history.on('click', '.recently-title', function(e) {
				e.preventDefault();
				$recently.addClass('load-ajax');
				$layer.toggleClass('opened');
				$recently.slideToggle(400, function() {
					if ( found ) {
						footerRecentlyProducts();
						found = false;
					}
				});
				$(this).toggleClass('active');

			});

			$layer.on('click', function() {
				$layer.removeClass('opened');
				$history.find('.recently-title').removeClass('active');
				$recently.slideUp(400);
			});
		}


		function headerRecentlyProducts() {
			var $recently = $('#header-recently-viewed');
			if ( $recently.length <= 0 ) {
				return;
			}

			martfury.$window.on('load', function() {
				$.ajax({
					url     : martfuryData.ajax_url,
					dataType: 'json',
					method  : 'post',
					data    : {
						action: 'martfury_header_recently_viewed',
						nonce : martfuryData.nonce
					},
					success : function(response) {
						$recently.html(response.data);
						if ( $recently.find('.product-list').hasClass('no-products') ) {
							$recently.addClass('no-products');
						}
						martfury.lazyLoad();
						recentlyCarousel($recently);
					}
				});
			});
		}

		function recentlyCarousel($recently) {
			if ( !$recently.find('.product-list').hasClass('no-products') ) {
				$recently.find('.product-list').not('.slick-initialized').slick({
					slidesToShow  : 8,
					slidesToScroll: 8,
					arrows        : true,
					infinite      : false,
					prevArrow     : '<span class="ion-ios-arrow-left slick-prev-arrow"></span>',
					nextArrow     : '<span class="ion-ios-arrow-right slick-next-arrow"></span>',
					responsive    : [
						{
							breakpoint: 1200,
							settings  : {
								slidesToShow  : 6,
								slidesToScroll: 6
							}
						},
						{
							breakpoint: 800,
							settings  : {
								slidesToShow  : 4,
								slidesToScroll: 4
							}
						},
						{
							breakpoint: 600,
							settings  : {
								slidesToShow  : 2,
								slidesToScroll: 2
							}
						}
					]
				});
			}
		}
	};

	// Catalog Banners Carousel
	martfury.catalogBanners = function() {
		var $banners = $('#mf-catalog-banners');

		if ( $banners.length <= 0 ) {
			return;
		}

		var number = $banners.data('columns'),
			autoplay = $banners.data('autoplay'),
			infinite = false,
			speed = 1000;

		if ( autoplay > 0 ) {
			infinite = true;
			speed = autoplay;
			autoplay = true;
		} else {
			autoplay = false;
		}
		$banners.not('.slick-initialized').slick({
			slidesToShow  : 1,
			slidesToScroll: 1,
			autoplaySpeed : speed,
			autoplay      : autoplay,
			infinite      : infinite,
			prevArrow     : '<span class="icon-chevron-left slick-prev-arrow"></span>',
			nextArrow     : '<span class="icon-chevron-right slick-next-arrow"></span>'
		});

		$banners.on('afterChange', function() {
			martfury.lazyLoad();
		});
	};

	// Products Top Carousel
	martfury.productsTopCarousel = function() {
		var $products = $('.mf-products-top-carousel');

		if ( $products.length <= 0 ) {
			return;
		}

		$products.each(function() {
			var number = $(this).data('columns'),
				autoplay = $(this).data('autoplay'),
				infinite = false,
				speed = 1000;

			if ( autoplay > 0 ) {
				infinite = true;
				speed = autoplay;
				autoplay = true;
			} else {
				autoplay = false;
			}
			$(this).find('ul.products').not('.slick-initialized').slick({
				slidesToShow  : number,
				slidesToScroll: number,
				autoplaySpeed : speed,
				autoplay      : autoplay,
				infinite      : infinite,
				dots          : true,
				prevArrow     : $(this).find('.slick-prev-arrow'),
				nextArrow     : $(this).find('.slick-next-arrow'),
				responsive    : [
					{
						breakpoint: 992,
						settings  : {
							slidesToShow  : parseInt(number) > 3 ? 3 : number,
							slidesToScroll: parseInt(number) > 3 ? 3 : number
						}
					},
					{
						breakpoint: 767,
						settings  : {
							slidesToShow  : 2,
							slidesToScroll: 2
						}
					}
				]
			});

			$(this).on('afterChange', function() {
				martfury.lazyLoad();
			});
		});
	};

	// Product Categories
	martfury.productCategoriesWidget = function() {
		var $categories = $('.mf_widget_product_categories, .wcv.widget_product_categories');

		if ( $categories.length <= 0 ) {
			return;
		}

		$categories.find('ul.children').closest('li').prepend('<span class="cat-menu-close"><i class="icon-chevron-down"></i> </span>');

		$categories.find('li.current-cat-parent, li.current-cat, li.current-cat-ancestor').addClass('opened').children('.children').show();

		$categories.on('click', '.cat-menu-close', function(e) {
			e.preventDefault();
			$(this).closest('li').children('.children').slideToggle();
			$(this).closest('li').toggleClass('opened');

		})

	};

	// Product Categories
	martfury.productTopCategories = function() {
		var $categories = $('.mf-catalog-top-categories');

		if ( $categories.length <= 0 ) {
			return;
		}

		$categories.on('click', '.cat-menu-close', function(e) {
			e.preventDefault();
			$(this).closest('li').children('.sub-categories').slideToggle();
			$(this).closest('li').toggleClass('opened');

		})

	};

	// Product Attribute
	martfury.productAttribute = function() {
		var oImgSrc = '',
			oImgSrcSet = '';
		martfury.$body.on('mouseover', '.mf-swatch-image', function(e) {
			e.preventDefault();
			var $mainImages = $(this).closest('li.product').find('.mf-product-thumbnail'),
				$oriImage = $mainImages.find('img');

			oImgSrc = $oriImage.attr('src');
			oImgSrcSet = $oriImage.attr('srcset');

			var imgSrc = $(this).find('img').attr('src'),
				imgSrcSet = $(this).find('img').attr('srcset');

			$oriImage.attr('src', imgSrc);

			if ( imgSrcSet ) {
				$oriImage.attr('srcset', imgSrcSet);
			}

		}).on('mouseout', '.mf-swatch-image', function(e) {
			e.preventDefault();
			var $mainImages = $(this).closest('li.product').find('.mf-product-thumbnail'),
				$oriImage = $mainImages.find('img');

			if ( oImgSrc ) {
				$oriImage.attr('src', oImgSrc);
			}

			if ( oImgSrcSet ) {
				$oriImage.attr('srcset', oImgSrcSet);
			}

		});

		martfury.$body.on('mouseover', '.mf-attr-swatches', function(e) {
			e.preventDefault();
			var $mainImages = $(this).closest('li.product').find('.mf-product-thumbnail');
			$mainImages.addClass('hover-swatch');
		}).on('mouseout', '.mf-attr-swatches', function(e) {
			e.preventDefault();
			var $mainImages = $(this).closest('li.product').find('.mf-product-thumbnail');
			$mainImages.removeClass('hover-swatch');
		});
	};

	/**
	 * Shop view toggle
	 */
	martfury.shopView = function() {

		martfury.$body.on('click', '.mf-shop-view', function(e) {
			e.preventDefault();
			var $el = $(this),
				view = $el.data('view');

			if ( $el.hasClass('current') ) {
				return;
			}

			martfury.$body.find('.mf-shop-view').removeClass('current');
			$el.addClass('current');
			martfury.$body.removeClass('shop-view-grid shop-view-list').addClass('shop-view-' + view);

			document.cookie = 'shop_view=' + view + ';domain=' + window.location.host + ';path=/';

			$(document.body).trigger('martfury_shop_view_after_change');

		});

		$(document.body).on('martfury_shop_view_after_change', function() {
			martfury.lazyLoad();
		});
	};

	//related & upsell slider
	martfury.singleProductCarousel = function() {

		var $upsells = martfury.$body.find('.up-sells ul.products'),
			$related = martfury.$body.find('.related.products ul.products');

		if ( $upsells.length <= 0 && $related.length <= 0 ) {
			return
		}

		var upsells_columns = $upsells.closest('.up-sells').data('columns');

		// Product thumnails and featured image slider
		$upsells.not('.slick-initialized').slick({
			slidesToShow  : parseInt(upsells_columns),
			slidesToScroll: parseInt(upsells_columns),
			arrows        : true,
			dots          : true,
			infinite      : false,
			prevArrow     : '<span class="icon-chevron-left slick-prev-arrow"></span>',
			nextArrow     : '<span class="icon-chevron-right slick-next-arrow"></span>',
			responsive    : [
				{
					breakpoint: 1200,
					settings  : {
						slidesToShow  : parseInt(upsells_columns) > 4 ? 4 : parseInt(upsells_columns),
						slidesToScroll: parseInt(upsells_columns) > 4 ? 4 : parseInt(upsells_columns)
					}
				},
				{
					breakpoint: 992,
					settings  : {
						slidesToShow  : 3,
						slidesToScroll: 3
					}
				},
				{
					breakpoint: 767,
					settings  : {
						slidesToShow  : 2,
						slidesToScroll: 2
					}
				}
			]
		});

		$upsells.on('afterChange', function() {
			martfury.lazyLoad();
		});

		var related_columns = $related.closest('.related').data('columns');
		$related.not('.slick-initialized').slick({
			rtl           : (martfuryData.rtl === 'true'),
			slidesToShow  : parseInt(related_columns),
			slidesToScroll: parseInt(related_columns),
			arrows        : true,
			dots          : true,
			infinite      : false,
			prevArrow     : '<span class="icon-chevron-left slick-prev-arrow"></span>',
			nextArrow     : '<span class="icon-chevron-right slick-next-arrow"></span>',
			responsive    : [
				{
					breakpoint: 1200,
					settings  : {
						slidesToShow  : parseInt(related_columns) > 4 ? 4 : parseInt(related_columns),
						slidesToScroll: parseInt(related_columns) > 4 ? 4 : parseInt(related_columns)
					}
				},
				{
					breakpoint: 992,
					settings  : {
						slidesToShow  : 3,
						slidesToScroll: 3
					}
				},
				{
					breakpoint: 767,
					settings  : {
						slidesToShow  : 2,
						slidesToScroll: 2
					}
				}
			]
		});

		$related.on('afterChange', function() {
			martfury.lazyLoad();
		});
	};

	martfury.fbtProduct = function() {
		var $fbtProducts = $('#mf-product-fbt');

		if ( $fbtProducts.length <= 0 ) {
			return;
		}

		var $priceAt = $fbtProducts.find('.mf-total-price .woocommerce-Price-amount'),
			$button = $fbtProducts.find('.mf_add_to_cart_button'),
			totalPrice = parseFloat($fbtProducts.find('#mf-data_price').data('price')),
			currency = martfuryData.currency_symbol,
			thousand = martfuryData.thousand_sep,
			decimal = martfuryData.decimal_sep,
			price_decimals = martfuryData.price_decimals,
			currency_pos = martfuryData.currency_pos;

		$fbtProducts.find('.products-list').on('click', 'a', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			$(this).closest('li').toggleClass('uncheck');
			var currentPrice = parseFloat($(this).closest('li').find('.s-price').data('price'));
			if ( $(this).closest('li').hasClass('uncheck') ) {
				$fbtProducts.find('#fbt-product-' + id).addClass('un-active');
				totalPrice -= currentPrice;

			} else {
				$fbtProducts.find('#fbt-product-' + id).removeClass('un-active');
				totalPrice += currentPrice;
			}

			var $product_ids = '0';
			$fbtProducts.find('.products-list li').each(function() {
				if ( !$(this).hasClass('uncheck') ) {
					$product_ids += ',' + $(this).find('a').data('id');
				}
			});

			$button.attr('value', $product_ids);

			$priceAt.html(formatNumber(totalPrice));
		});


		function formatNumber(number) {
			var n = number;
			if ( parseInt(price_decimals) > 0 ) {
				number = number.toFixed(price_decimals) + '';
				var x = number.split('.');
				var x1 = x[0],
					x2 = x.length > 1 ? decimal + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while ( rgx.test(x1) ) {
					x1 = x1.replace(rgx, '$1' + thousand + '$2');
				}

				n = x1 + x2
			}


			switch ( currency_pos ) {
				case 'left' :
					return currency + n;
					break;
				case 'right' :
					return n + currency;
					break;
				case 'left_space' :
					return currency + ' ' + n;
					break;
				case 'right_space' :
					return n + ' ' + currency;
					break;
			}
		}

	};

	// Add to cart ajax
	martfury.fbtAddToCartAjax = function() {
		var $fbtProducts = $('#mf-product-fbt');

		if ( $fbtProducts.length <= 0 ) {
			return;
		}

		$fbtProducts.on('click', '.mf_add_to_cart_button.ajax_add_to_cart', function(e) {
			e.preventDefault();

			var $singleBtn = $(this);
			$singleBtn.addClass('loading');

			var currentURL = window.location.href;

			$.ajax({
				url     : martfuryData.ajax_url,
				dataType: 'json',
				method  : 'post',
				data    : {
					action     : 'martfury_fbt_add_to_cart',
					nonce      : martfuryData.nonce,
					product_ids: $singleBtn.attr('value')
				},
				error   : function() {
					window.location = currentURL;
				},
				success : function(response) {
					if ( typeof wc_add_to_cart_params !== 'undefined' ) {
						if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
							window.location = wc_add_to_cart_params.cart_url;
							return;
						}
					}

					$(document.body).trigger('updated_wc_div');
					$(document.body).on('wc_fragments_refreshed', function() {
						$singleBtn.removeClass('loading');
					});

				}
			});

		});

	};

	// Add to wishlist  ajax
	martfury.fbtAddToWishlistAjax = function() {
		var $fbtProducts = $('#mf-product-fbt'),
			i = 0;

		if ( $fbtProducts.length <= 0 ) {
			return;
		}

		var product_ids = getProductIds();

		if ( product_ids.length == 0 ) {
			$fbtProducts.find('.btn-view-to-wishlist').addClass('showed');
			$fbtProducts.find('.btn-add-to-wishlist').addClass('hided');
		}

		$fbtProducts.on('click', '.btn-add-to-wishlist', function(e) {
			e.preventDefault();

			var $singleBtn = $(this);
			product_ids = getProductIds();

			if ( product_ids.length == 0 ) {
				return;
			}

			$singleBtn.addClass('loading');
			wishlistCallBack(product_ids[i]);
			martfury.$body.on('added_to_wishlist', function() {
				if ( product_ids.length > i ) {
					wishlistCallBack(product_ids[i]);
				} else if ( product_ids.length == i ) {
					$fbtProducts.find('.btn-view-to-wishlist').addClass('showed');
					$fbtProducts.find('.btn-add-to-wishlist').addClass('hided');
					$singleBtn.removeClass('loading');
				}
			});

		});

		function getProductIds() {
			var product_ids = [];
			$fbtProducts.find('li.product').each(function() {
				if ( !$(this).hasClass('un-active') && !$(this).hasClass('product-buttons') && !$(this).find('.yith-wcwl-add-button').hasClass('hide') ) {
					if ( product_ids.indexOf($(this).data('id')) == -1 ) {
						product_ids.push($(this).data('id'));
					}
				}

			});

			return product_ids;
		}

		function wishlistCallBack(id) {
			var $product = $fbtProducts.find('.add-to-wishlist-' + id);
			$product.find('.yith-wcwl-add-button.show .add_to_wishlist').trigger('click');
			i++;
			return i;
		}

	};

	//Instagram slider
	martfury.instagramCarousel = function() {

		var $instagram = martfury.$body.find('.mf-product-instagram ul.products'),
			columns = $instagram.data('columns'),
			autoplay = $instagram.data('auto'),
			infinite = false,
			speed = 1000;

		if ( $instagram.length < 1 ) {
			return;
		}

		if ( autoplay > 0 ) {
			infinite = true;
			speed = autoplay;
			autoplay = true;
		} else {
			autoplay = false;
		}

		$instagram.not('.slick-initialized').slick({
			rtl           : (martfuryData.rtl === 'true'),
			slidesToShow  : columns,
			slidesToScroll: columns,
			autoplaySpeed : speed,
			autoplay      : autoplay,
			infinite      : infinite,
			dots          : true,
			prevArrow     : '<span class="icon-chevron-left slick-prev-arrow"></span>',
			nextArrow     : '<span class="icon-chevron-right slick-next-arrow"></span>',
			responsive    : [
				{
					breakpoint: 1200,
					settings  : {
						slidesToShow  : parseInt(columns) > 4 ? 4 : parseInt(columns),
						slidesToScroll: parseInt(columns) > 4 ? 4 : parseInt(columns)
					}
				},
				{
					breakpoint: 992,
					settings  : {
						slidesToShow  : 3,
						slidesToScroll: 3
					}
				},
				{
					breakpoint: 767,
					settings  : {
						slidesToShow  : 2,
						slidesToScroll: 2
					}
				}
			]
		});

		$instagram.on('afterChange', function() {
			martfury.lazyLoad();
		});

	};


	/**
	 * Toggle product quick view
	 */
	martfury.productQuickView = function() {
		var $modal = $('#mf-quick-view-modal'),
			$product = $modal.find('.product-modal-content');

		martfury.$body.on('click', '.mf-product-quick-view', function(e) {
			e.preventDefault();

			var $a = $(this),
				id = $a.data('id');

			$product.hide().html('');
			$modal.addClass('loading').removeClass('loaded');
			martfury.openModal($modal);

			$.ajax({
				url     : martfuryData.ajax_url,
				dataType: 'json',
				method  : 'post',
				data    : {
					action    : 'martfury_product_quick_view',
					nonce     : martfuryData.nonce,
					product_id: id
				},
				success : function(response) {
					$product.show().append(response.data);
					$modal.removeClass('loading').addClass('loaded');
					var $gallery = $product.find('.woocommerce-product-gallery'),
						$variation = $('.variations_form');
					$gallery.removeAttr('style');
					$gallery.find('img.lazy').lazyload().trigger('appear');
					$gallery.imagesLoaded(function() {
						$gallery.find('.woocommerce-product-gallery__wrapper').not('.slick-initialized').slick({
							slidesToShow  : 1,
							slidesToScroll: 1,
							infinite      : false,
							prevArrow     : '<span class="icon-chevron-left slick-prev-arrow"></span>',
							nextArrow     : '<span class="icon-chevron-right slick-next-arrow"></span>'
						});
					});

					$gallery.find('.woocommerce-product-gallery__image').on('click', function(e) {
						e.preventDefault();
					});

					if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
						$variation.each(function() {
							$(this).wc_variation_form();
						});
					}

					if ( typeof $.fn.tawcvs_variation_swatches_form !== 'undefined' ) {
						$variation.tawcvs_variation_swatches_form();
					}

					martfury.productVatiation();
					if ( typeof tawcvs !== 'undefined' ) {
						if ( tawcvs.tooltip === 'yes' ) {
							$variation.find('.swatch').tooltip({
								classes     : {'ui-tooltip': 'martfury-tooltip'},
								tooltipClass: 'martfury-tooltip qv-tool-tip',
								position    : {my: 'center bottom', at: 'center top-13'},
								create      : function() {
									$('.ui-helper-hidden-accessible').remove();
								}
							});
						}
					}

					$product.find('.compare').tooltip({
						content     : function() {
							return $(this).html();
						},
						classes     : {'ui-tooltip': 'martfury-tooltip'},
						tooltipClass: 'martfury-tooltip qv-tooltip',
						position    : {my: 'center bottom', at: 'center top-13'},
						create      : function() {
							$('.ui-helper-hidden-accessible').remove();
						}
					});

					$product.find('[data-rel=tooltip]').tooltip({
						classes     : {'ui-tooltip': 'martfury-tooltip'},
						tooltipClass: 'martfury-tooltip qv-tooltip',
						position    : {my: 'center bottom', at: 'center top-13'},
						create      : function() {
							$('.ui-helper-hidden-accessible').remove();
						}
					});
				}
			});
		});

		$modal.on('click', '.close-modal, .mf-modal-overlay', function(e) {
			e.preventDefault();
			martfury.closeModal($modal);
		})

	};

	martfury.productVatiation = function() {

		martfury.$body.on('tawcvs_initialized', function() {
			$('.variations_form').unbind('tawcvs_no_matching_variations');
			$('.variations_form').on('tawcvs_no_matching_variations', function(event, $el) {
				event.preventDefault();

				$('.variations_form').find('.woocommerce-variation.single_variation').show();
				if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
					$('.variations_form').find('.single_variation').slideDown(200).html('<p>' + wc_add_to_cart_variation_params.i18n_no_matching_variations_text + '</p>');
				}
			});

		});

		$('.variations_form td.value').on('change', 'select', function() {
			var value = $(this).find('option:selected').text();
			$(this).closest('tr').find('td.label .mf-attr-value').html(value);
		});
	};

	// Add to cart ajax
	martfury.addToCartAjax = function() {

		if ( martfuryData.add_to_cart_ajax == '0' ) {
			return;
		}

		var found = false;
		martfury.$body.on('click', '.single_add_to_cart_button', function(e) {
			var $el = $(this),
				$cartForm = $el.closest('form.cart');

			if ( $cartForm.length > 0 ) {
				e.preventDefault();
			} else {
				return;
			}

			if ( $el.hasClass('disabled') ) {
				return;
			}

			$el.addClass('loading');
			if ( found ) {
				return;
			}
			found = true;

			var formdata = $cartForm.serializeArray(),
				currentURL = window.location.href;

			if ( $el.val() != '' ) {
				formdata.push({name: $el.attr('name'), value: $el.val()});
			}
			$.ajax({
				url    : window.location.href,
				method : 'post',
				data   : formdata,
				error  : function() {
					window.location = currentURL;
				},
				success: function(response) {
					if ( !response ) {
						window.location = currentURL;
					}


					if ( typeof wc_add_to_cart_params !== 'undefined' ) {
						if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
							window.location = wc_add_to_cart_params.cart_url;
							return;
						}
					}

					$(document.body).trigger('updated_wc_div');
					$(document.body).on('wc_fragments_refreshed', function() {
						$el.removeClass('loading');
					});

					found = false;

				}
			});

		});

	};

	// Filter Ajax
	martfury.filterAjax = function() {

		if ( !martfury.$body.hasClass('catalog-ajax-filter') ) {
			return;
		}

		$(document.body).on('price_slider_change', function(event, ui) {
			var form = $('.price_slider').closest('form').get(0),
				$form = $(form),
				url = $form.attr('action') + '?' + $form.serialize();

			$(document.body).trigger('martfury_catelog_filter_ajax', url, $(this));
		});

		martfury.$body.on('click', '.mf_widget_product_categories a, .mf-widget-layered-nav a, .widget_rating_filter a, .widget_layered_nav_filters a', function(e) {
			e.preventDefault();
			var url = $(this).attr('href');
			$(document.body).trigger('martfury_catelog_filter_ajax', url, $(this));
		});


		$(document.body).on('martfury_catelog_filter_ajax', function(e, url, element) {

			var $content = $('#content'),
				$pageHeader = $('.page-header');

			NProgress.start();
			$('#page').removeClass('fade-in');

			if ( '?' == url.slice(-1) ) {
				url = url.slice(0, -1);
			}

			url = url.replace(/%2C/g, ',');

			history.pushState(null, null, url);

			$(document.body).trigger('martfury_ajax_filter_before_send_request', [url, element]);

			if ( martfury.ajaxXHR ) {
				martfury.ajaxXHR.abort();
			}

			martfury.ajaxXHR = $.get(url, function(res) {

				$content.replaceWith($(res).find('#content'));
				$pageHeader.html($(res).find('.page-header').html());

				$(document.body).trigger('martfury_ajax_filter_request_success', [res, url]);

			}, 'html');

		});

		$(document.body).on('martfury_ajax_filter_request_success', function() {
			martfury.lazyLoad();
			martfury.toolTipIcon();
			martfury.searchLayeredNav();
			martfury.catalogBanners();
			martfury.productsTopCarousel();
			martfury.productCategoriesWidget();
			martfury.productAttribute();
			martfury.variationImagesCarousel();
			martfury.productTopCategories();
			martfury.priceSlider();
			NProgress.done();
			$('#page').addClass('fade-in');
		});

	};

	// Get price js slider
	martfury.priceSlider = function() {
		// woocommerce_price_slider_params is required to continue, ensure the object exists
		if ( typeof woocommerce_price_slider_params === 'undefined' ) {
			return false;
		}

		if ( $('.catalog-sidebar').find('.widget_price_filter').length <= 0 ) {
			return false;
		}

		// Get markup ready for slider
		$('input#min_price, input#max_price').hide();
		$('.price_slider, .price_label').show();

		// Price slider uses jquery ui
		var min_price = $('.price_slider_amount #min_price').data('min'),
			max_price = $('.price_slider_amount #max_price').data('max'),
			current_min_price = parseInt(min_price, 10),
			current_max_price = parseInt(max_price, 10);

		if ( $('.price_slider_amount #min_price').val() != '' ) {
			current_min_price = parseInt($('.price_slider_amount #min_price').val(), 10);
		}
		if ( $('.price_slider_amount #max_price').val() != '' ) {
			current_max_price = parseInt($('.price_slider_amount #max_price').val(), 10);
		}

		$(document.body).bind('price_slider_create price_slider_slide', function(event, min, max) {
			if ( woocommerce_price_slider_params.currency_pos === 'left' ) {

				$('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + min);
				$('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + max);

			} else if ( woocommerce_price_slider_params.currency_pos === 'left_space' ) {

				$('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + ' ' + min);
				$('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + ' ' + max);

			} else if ( woocommerce_price_slider_params.currency_pos === 'right' ) {

				$('.price_slider_amount span.from').html(min + woocommerce_price_slider_params.currency_symbol);
				$('.price_slider_amount span.to').html(max + woocommerce_price_slider_params.currency_symbol);

			} else if ( woocommerce_price_slider_params.currency_pos === 'right_space' ) {

				$('.price_slider_amount span.from').html(min + ' ' + woocommerce_price_slider_params.currency_symbol);
				$('.price_slider_amount span.to').html(max + ' ' + woocommerce_price_slider_params.currency_symbol);

			}

			$(document.body).trigger('price_slider_updated', [min, max]);
		});
		if ( typeof $.fn.slider !== 'undefined' ) {
			$('.price_slider').slider({
				range  : true,
				animate: true,
				min    : min_price,
				max    : max_price,
				values : [current_min_price, current_max_price],
				create : function() {

					$('.price_slider_amount #min_price').val(current_min_price);
					$('.price_slider_amount #max_price').val(current_max_price);

					$(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
				},
				slide  : function(event, ui) {

					$('input#min_price').val(ui.values[0]);
					$('input#max_price').val(ui.values[1]);

					$(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
				},
				change : function(event, ui) {

					$(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
				}
			});
		}
	};


	/**
	 * Document ready
	 */
	$(function() {
		martfury.init();
	});

})(jQuery);