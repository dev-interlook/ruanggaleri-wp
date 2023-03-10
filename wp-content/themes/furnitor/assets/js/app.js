var FURNITOR = FURNITOR || {};
(function ($) {
	"use strict";

	FURNITOR = {
		init: function () {
			this.search();
			this.mobileEvent();
			this.menuPopupTransition();
			this.cateToggle();
		},
		isMobile: function () {
			var responsive_breakpoint = 991;
			return window.matchMedia('(max-width: ' + responsive_breakpoint + 'px)').matches;
		},
		search: function () {
			$('.search-form-wrapper .search-icon').on('click', function () {
				$(this).closest('.search-form-wrapper').find('.search-form').toggle();
			});

			$(document).on('click', function (event) {
				if ($(event.target).closest('.search-form-wrapper').length === 0) {
					$('.search-form-wrapper .search-form').hide();
				}
			});
		},
		mobileEvent: function () {
			$('.site-header .menu-toggle-button').on('click', function () {
				var $this = $(this);
				if ($this.hasClass('in')) {
					$this.removeClass('in');
					$('.site-navigation').slideUp();
				}
				else {
					$this.addClass('in');
					$('.site-navigation').slideDown();
				}

			});

			$('.main-menu a').on('click', function (event) {
				if (FURNITOR.isMobile()) {
					if ($(event.target).closest('.caret').length !== 0) {
						event.preventDefault();
					}
				}

			});
			$('.main-menu .menu-item-has-children .caret').on('click', function () {
				if (FURNITOR.isMobile()) {
					var $this = $(this);
					$this.closest('li').find(' > .sub-menu').slideToggle();
					$this.toggleClass('in');
				}
			});
		},
		menuPopupTransition: function () {
			$('.g5core-menu-popup .main-menu > li > a').each(function (index) {
				$(this).css('transition-delay', (index * 200) + 'ms');
			});

			$('.g5core-menu-popup .main-menu li').on('click', function () {
				$(this).css('height','auto');
			})
		},
		cateToggle: function () {
			$(".g5shop__cate-browse").click(function(){
				$(".g5shop__list-cate").slideToggle();
			});
		},
	};

	$(document).ready(function () {
		FURNITOR.init();
	});
	$(window).resize(function () {
		if (!FURNITOR.isMobile()) {
			$('.site-header .menu-toggle-button').removeClass('in');
			$('.main-menu .menu-item-has-children .caret').removeClass('in');
			$('.site-navigation').css('display', '');
			$('.main-menu .menu-item-has-children > .sub-menu').css('display', '');
		}
	});

})(jQuery);
