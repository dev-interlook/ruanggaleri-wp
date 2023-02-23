<?php
// Get Categories for posts.
$categories_list = get_the_category_list( ', ' );
global $post;
$author_Id = $post->post_author;
$author_name = get_the_author_meta( 'display_name',$author_Id );
?>
<ul class="entry-meta">
	<li class="meta-author">
		<span><?php esc_html_e('By','furnitor') ?></span>
		<a href="<?php echo esc_url( get_author_posts_url( $author_Id ) ) ?>">
			<?php echo esc_html($author_name)?>
		</a>
	</li>
	<?php if (!empty($categories_list)): ?>
	<li class="meta-cate">
		<span><?php esc_html_e('on','furnitor') ?></span>
		<?php echo wp_kses($categories_list,wp_kses_allowed_html('categories_list'))?>
	</li>
	<?php endif; ?>
	<?php if (comments_open() || get_comments_number()): ?>
		<li class="meta-comment">
			<?php comments_popup_link('<i class="far fa-comment"></i>' . esc_html__('0 Comments','furnitor'),'<i class="far fa-comment"></i>' . esc_html__('1 Comment','furnitor'),'<i class="far fa-comments"></i>'. esc_html__('% Comments','furnitor')) ?>
		</li>
	<?php endif; ?>
</ul>