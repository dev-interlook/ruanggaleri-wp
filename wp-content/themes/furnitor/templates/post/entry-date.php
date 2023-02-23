<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<span class="meta-date"><a href="<?php echo esc_url( get_permalink() ) ?>"><?php echo get_the_time( get_option( 'date_format' ) ) ?></a></span>
