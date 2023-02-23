(function ($) {
	'use strict';
	var G5ProductsSliderHandler = function ($scope, $) {
		G5CORE.util.slickSlider($scope);
		new G5CORE_Animation($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-g5-products-slider.default', G5ProductsSliderHandler);
	});

})(jQuery);