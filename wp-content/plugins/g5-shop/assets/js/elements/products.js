(function ($) {
	'use strict';
	var G5_Products_Handler = function ($scope, $) {
		new G5CORE_Animation($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-g5-products.default', G5_Products_Handler);
	});

})(jQuery);