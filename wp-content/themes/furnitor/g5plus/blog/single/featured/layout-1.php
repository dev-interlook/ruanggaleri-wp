<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="g5blog__single-meta-top">
	<div class="container">
		<?php
		/**
		 * Hook: g5blog_loop_post_content.
		 *
		 * @hooked g5blog_template_single_title - 5
		 * @hooked g5blog_template_single_meta - 10
		 */
		do_action('g5blog_single_meta_top');
		?>
	</div>
</div>
