(function ($) {
	'use strict';
	var G5_Product_Tabs_Handler = function ($scope, $) {
		new G5CORE_Animation($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-g5-product-tabs.default', G5_Product_Tabs_Handler);
	});

})(jQuery);