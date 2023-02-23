(function ($) {
	'use strict';
	var G5ProductCategoriesHandler = function ($scope, $) {
		G5CORE.util.slickSlider($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-g5-product-categories.default', G5ProductCategoriesHandler);
	});

})(jQuery);