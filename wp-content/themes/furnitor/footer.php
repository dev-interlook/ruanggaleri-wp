<?php
/**
 * The template for displaying the footer
 *
 * @since 1.0
 * @version 1.0
 */
			/**
			 * @hooked  furnitor_template_wrapper_end - 10
			 */
			do_action('furnitor_main_wrapper_content_end');
?>
		</div><!-- /.wrapper_content -->

		<?php
		/**
		 * @hooked furnitor_template_footer, 10
		 */
		do_action('furnitor_after_page_wrapper_content');
		?>
	</div><!-- /.site-wrapper -->
<?php
do_action('furnitor_after_page_wrapper');
?>
<?php wp_footer(); ?>
</body>
</html> <!-- end of site. what a ride! -->
