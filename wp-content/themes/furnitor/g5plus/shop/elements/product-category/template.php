<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

/**
 * @var $element UBE_Element_G5Shop_Product_Category
 */
$atts = $element->get_settings();

if ($atts['category'] === '') {
	return;
}

$wrap_class = array(
	'g5element__product_category',
	'woocommerce',
);

$element->add_render_attribute('product_cat_attr', 'class', $wrap_class);

$term = get_term_by('id', $atts['category'], 'product_cat', 'ARRAY_A');
$prefix = G5SHOP()->meta_prefix;
$image = '';
if (!empty($atts['custom_image']['url'])) {
	$custom_image_src = wp_get_attachment_image_src($atts['custom_image']['id'], 'full');
	if (!empty($custom_image_src[0])) {
		$custom_image_src = $custom_image_src[0];
		$image = '<img alt="' . esc_attr($term['name']) . '" src="' . esc_url($custom_image_src) . '">';
	}
} else {
	$images = get_term_meta($atts['category'], "{$prefix}product_cate", true);
	if (($images !== '') && ($images['url'] !== '')) {
		$image = '<img alt="' . esc_attr($term['name']) . '" src="' . esc_url($images['url']) . '">';
	}
}

$link = get_term_link((int)$atts['category'], 'product_cat');

?>

<div <?php $element->print_render_attribute_string('product_cat_attr') ?>>
	<?php if ($image !== ''): ?>
		<div class="g5element__product_category-image">
			<?php echo wp_kses($image,wp_kses_allowed_html('image'))?>
		</div>
	<?php endif; ?>
	<div class="g5element__product_category-content">
		<?php if ($term['name'] !== ''): ?>
			<h4 class="g5element__product_category-title">
				<a href="<?php echo esc_url($link) ?>"><?php echo esc_html($term['name']) ?></a>
			</h4>
		<?php endif; ?>
		<?php if ($term['count'] !== ''): ?>
			<div class="g5element__product_category-count-item">
				<span class="g5element__product_category-count"><?php echo esc_html($term['count']) ?></span>
				<span><?php esc_html_e('items', 'furnitor') ?></span>
			</div>
		<?php endif; ?>
	</div>
</div>
