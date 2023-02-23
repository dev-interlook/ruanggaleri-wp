<?php
/**
 * Shortcode attributes
 * @var $author_name
 * @var $author_job
 * @var $author_bio
 * @var $author_avatar
 * @var $author_link
 * @var $name_class
 * @var $job_class
 * @var $bio_class
 * Shortcode class
 */
?>
<?php if (!empty($author_avatar)) { ?>
    <div class="author-avatar">
		<?php echo wp_kses($image_src,wp_kses_allowed_html('image'))?>
    </div>
<?php } ?>
<div class="testi-quote">
	<?php if ((string)$rating != 'none') { ?>
        <div class="testimonial-rating">
			<?php for ($i = 1; $i <= 5; $i++): ?>
				<?php $icon_class = ($i <= $rating) ? 'fa fa-star' : 'far fa-star'; ?>
                <span class="<?php echo esc_attr($icon_class) ?>"></span>
			<?php endfor; ?>
        </div>
	<?php } ?>
    <div class="testimonial-content">
        <p class="<?php echo implode(' ', $bio_class); ?>"><?php echo esc_html($author_bio) ?></p>
    </div>
    <h4 class="<?php echo implode(' ', $name_class); ?>">
        <a href="<?php echo esc_url($author_link) ?>"
           title="<?php echo esc_attr($author_name) ?>">
			<?php echo esc_html($author_name) ?>
        </a>
    </h4>
	<?php if ($author_job !== ''): ?>
        <p class="<?php echo implode(' ', $job_class); ?>"><?php echo esc_html($author_job) ?></p>
	<?php endif; ?>
</div>