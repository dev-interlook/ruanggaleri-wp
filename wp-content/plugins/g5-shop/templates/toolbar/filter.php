<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
add_action('g5shop_after_shop_toolbar','g5shop_template_shop_filter',10);
?>
<a href="#" data-g5shop-filter class="g5shop__filter-button"><i class="far fa-filter"></i> <?php esc_html_e( 'Filter', 'g5-shop' ) ?></a>
