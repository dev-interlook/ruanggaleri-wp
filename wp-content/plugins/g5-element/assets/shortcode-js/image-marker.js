(function ($) {
	"use strict";
	$('.g5element-image-marker').find('[data-toggle="tooltip"]').each(function () {
		var configs = {
			container: $(this).parent(),
			html: true,
			placement: 'top',
			offset: 20,
			delay: {"show": 0, "hide": 100},
		};
		if ($(this).closest('.gtf__tooltip-wrap').length) {
			configs = $.extend({}, configs, $(this).closest('.gtf__tooltip-wrap').data('tooltip-options'));
		}
		$(this).tooltip(configs);
	});
})(jQuery);
