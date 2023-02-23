<?php
$post_class = is_singular() ? 'article-post article-single-post' : 'article-post article-archive-post';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<?php furnitor_get_template('post/entry-thumbnail') ?>
	<?php if (!is_singular()): ?>
		<header class="entry-header">
			<?php furnitor_get_template('post/entry-date') ?>
			<?php furnitor_get_template('post/entry-title') ?>
		</header><!-- .entry-header -->
	<?php endif; ?>
	<?php furnitor_get_template('post/entry-content') ?>
	<?php if (is_singular()): ?>
		<?php furnitor_get_template('post/entry-tags') ?>
	<?php else: ?>
		<?php furnitor_get_template('post/read-more') ?>
	<?php endif; ?>
</article><!-- #post-## -->