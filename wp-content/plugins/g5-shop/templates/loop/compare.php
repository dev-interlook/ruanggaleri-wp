<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (shortcode_exists('yith_compare_button') && (get_option('yith_woocompare_compare_button_in_products_list','yes') == 'yes')) {
	echo do_shortcode('[yith_compare_button container="false" type="link"]');
}