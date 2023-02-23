(function ($) {
	'use strict';

	var UbeModalHandler = function ($scope, $) {
		var $modal_bg=$('.modal-backdrop');
		$modal_bg.removeClass('show');
		$modal_bg.css('position','static');
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-modals.default', UbeModalHandler);
	});
})(jQuery);