<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $element UBE_Element_G5Shop_Product_Tabs
 */
$atts = $element->get_settings();

$wrapper_classes = array(
	'ube__product-tabs',
	'woocommerce'
);

$element->set_render_attribute('wrapper', array(
	'class'=> $wrapper_classes
));


$query_args = array(
	'post_type' => 'product',
);

$post_layout = isset($atts['post_layout']) ? $atts['post_layout'] : 'grid';
$post_image_size = isset($atts['post_image_size']) ? $atts['post_image_size'] : 'medium';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';
$excerpt_enable = isset($atts['excerpt_enable']) ? $atts['excerpt_enable'] : '';
$rating_enable = isset($atts['rating_enable']) ? $atts['rating_enable'] : '';
$category_enable = isset($atts['category_enable']) ? $atts['category_enable'] : '';
$show = isset($atts['show']) ? $atts['show'] : '';

$settings = array(
	'post_layout' => $post_layout,
	'image_size' => $post_image_size,
	'image_ratio' => array(
		'width' => $post_image_ratio_width,
		'height' => $post_image_ratio_height
	),
	'category_enable' => $category_enable,
	'rating_enable' => $rating_enable,
	'excerpt_enable' => $excerpt_enable,
);

$element->prepare_display($atts,$query_args,$settings);
?>
<div <?php echo $element->get_render_attribute_string('wrapper') ?>>
	<?php G5SHOP()->listing()->render_content($element->_query_args, $element->_settings); ?>
</div>
