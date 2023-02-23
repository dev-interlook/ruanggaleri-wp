<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $img_width
 * @var $custom_image
 * @var $cat
 * @var $el_id
 * @var $el_class
 * @var $slider_rows
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Product_category
 */


$el_id = $el_class = $cat = $img_width = $custom_image =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'g5element__product_category',
	'woocommerce',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css)
);

if (!isset($cat)) {
	return;
}

$term = get_term_by('id', $cat, 'product_cat', 'ARRAY_A');
$prefix = G5SHOP()->meta_prefix;
$image = '';
if (!empty($custom_image)) {
	$custom_image_id = preg_replace('/[^\d]/', '', $custom_image);
	$custom_image_src = wp_get_attachment_image_src($custom_image_id, 'full');
	if (!empty($custom_image_src[0])) {
		$custom_image_src = $custom_image_src[0];
		$image = '<img alt="' . esc_attr($term['name']) . '" src="' . esc_url($custom_image_src) . '">';
	}
} else {
	$images = get_term_meta($cat, "{$prefix}product_cate", true);
	if (($images !== '') && ($images['url'] !== '')) {
		$image = '<img alt="' . esc_attr($term['name']) . '" src="' . esc_url($images['url']) . '">';
	}
}

if ($img_width !== '') {
	$img_width = absint($img_width);
	if ($img_width > 0) {
		$img_width_class = uniqid('g5element__product_category-');
		$img_width_css = <<<CSS
                .{$img_width_class} .g5element__product_category-image {
                      -ms-flex: 0 0 {$img_width}px;
                      flex: 0 0 {$img_width}px;
                      max-width: {$img_width}px;
                 }
CSS;
		G5Core()->custom_css()->addCss($img_width_css);
		$wrapper_classes[] = $img_width_class;
	}
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
$wrapper_attributes = array();
if (!empty($el_id)) {
	$wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}

$link = get_term_link((int)$cat, 'product_cat');

?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
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