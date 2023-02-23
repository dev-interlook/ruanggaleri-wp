<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<span><?php esc_html_e('on','furnitor') ?></span> <?php echo get_the_category_list(' / '); ?>

