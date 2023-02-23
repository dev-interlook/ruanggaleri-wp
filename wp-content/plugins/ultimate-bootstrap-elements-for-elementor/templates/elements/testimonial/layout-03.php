<?php
/**
 * @var $element Elementor\Widget_Base
 * @var $item_key
 * @var $html_rating array
 * @var $client_say
 * @var $author_name
 * @var $author_job
 * @var $image_html
 */
?>
<?php if ($image_html !== ''): ?>
	<div class="ube-testimonial-avatar">
		<?php echo $image_html; ?>
	</div>
<?php endif; ?>

<div <?php echo $element->get_render_attribute_string("content_attr{$item_key}") ?>>
	<?php if ($client_say !== ''): ?>
		<p class="ube-testimonial-client-say">
			<?php echo wp_kses_post($client_say) ?>
		</p>
	<?php endif; ?>
	<?php if (count($html_rating) > 0): ?>
		<div class="ube-testimonial-rating">
			<?php echo join('', $html_rating) ?>
		</div>
	<?php endif; ?>
	<div class="ube-testimonial-info">
		<?php if ($author_name !== ''): ?>
			<h4 class="ube-testimonial-author-name">
				<?php echo esc_html($author_name) ?>
			</h4>
		<?php endif; ?>
		<?php if ($author_job !== ''): ?>
			<span class="ube-testimonial-author-job"><?php echo esc_html($author_job) ?></span>
		<?php endif; ?>
	</div>
</div>
