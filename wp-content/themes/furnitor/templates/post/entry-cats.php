<?php
// Get Categories for posts.
$categories_list = get_the_category_list( ', ' );
if (empty($categories_list)) {
	return;
}
?>
<span class="cat-tags-links">
	<span class="cat-links"><?php echo wp_kses($categories_list,wp_kses_allowed_html('categories_list'))?></span>
</span>