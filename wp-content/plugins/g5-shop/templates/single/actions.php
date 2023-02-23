<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<div class="g5shop__single-product-actions g5shop__product-list-actions">
    <?php

    if (shortcode_exists('yith_wcwl_add_to_wishlist')) {
	    echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
    }

    if (shortcode_exists('yith_compare_button') && (get_option('yith_woocompare_compare_button_in_product_page','yes') === 'yes')) {
	    echo do_shortcode('[yith_compare_button container="false" type="link"]');
    }
    ?>
</div>
