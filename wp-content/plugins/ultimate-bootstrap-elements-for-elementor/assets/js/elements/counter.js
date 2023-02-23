(function ($) {
	'use strict';

	var UbeCounterHandler = function ($scope, $) {
		if (typeof Waypoint !== 'undefined') {
			var $counters = $scope.find('.ube-counter-number');
			$.each($counters, function () {
				elementorFrontend.waypoint($(this), function () {
					var options_setting = $(this).data('counter-options');
					var start = options_setting.start;
					var end = options_setting.end;
					var decimals = 0;
					var duration = options_setting.duration;
					var separator = options_setting.separator;
					var usegrouping = false;
					if (separator !== '') {
						usegrouping = true
					}
					var decimal = 0;
					var prefix = '';
					var suffix = '';
					var options = {
						useEasing: true,
						useGrouping: usegrouping,
						separator: separator,
						decimal: decimal,
						prefix: prefix,
						suffix: suffix
					};
					var counterup = new CountUp(this, start, end, decimals, duration, options);
					counterup.start();
				}, {
					triggerOnce: true,
					offset: 'bottom-in-view'
				});
			});

		}
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-counter.default', UbeCounterHandler);
	});

})(jQuery);