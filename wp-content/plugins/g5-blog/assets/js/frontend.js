var G5BLOG = window.G5BLOG || {};
(function ($) {
    "use strict";
    window.G5BLOG = G5BLOG;


    var $window = $(window),
        $body = $('body'),
        isRTL = $body.hasClass('rtl');

    G5BLOG = {
        init: function () {
            this.singleThumbnail();
        },
        singleThumbnail: function () {
            if ($('body.single-post').find('.g5blog__single-featured').length) {
                $('body').addClass('g5blog__has-post-thumbnail');
            } else {
                $('body').addClass('g5blog__no-post-thumbnail');
            }
        },
    };




    $(document).ready(function () {
        G5BLOG.init();
    });
})(jQuery);