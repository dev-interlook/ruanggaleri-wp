<?php
/**
 * The template for displaying post author info
 */
if (!is_singular()) {
	return;
}
$author_description = get_the_author_meta('description');
if (empty($author_description)) {
	return;
}
?>
<div class="author-info-wrap">
	<div class="author-info-inner">
		<div class="author-info-avatar">
			<?php
			echo get_avatar(get_the_author_meta('user_email'), 90);
			?>
		</div>
		<div class="author-info-content">
			<div class="meta">
				<span><?php esc_html_e('Post By','furnitor') ?></span>
				<h2 class="name"><?php the_author_posts_link(); ?></h2>
			</div>
			<?php if (!empty($author_description)): ?>
				<div class="desc"><?php echo wp_kses($author_description,wp_kses_allowed_html('user_description')); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>