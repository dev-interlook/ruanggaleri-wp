<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_G5Shop_Products
 */
$atts = $element->get_settings();
$wrapper_classes = array(
	'ube__product-categories',
	'woocommerce'
);
$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'menu_order';
$order = isset($atts['order']) ? $atts['order'] : 'DESC';
$hide_empty = isset($atts['hide_empty']) ? $atts['hide_empty'] : 'on';
$number = isset($atts['number']) ? $atts['number'] : '';
$cat = isset($atts['cat']) ? $atts['cat'] : '';
$post_image_size = isset($atts['post_image_size']) ? $atts['post_image_size'] : '';
$slider_enable = isset($atts['slider_enable']) ? $atts['slider_enable'] : '';
// Get terms and workaround WP bug with parents/pad counts.
$args = array(
	'orderby'    => $orderby,
	'order'      => $order,
	'hide_empty' => $hide_empty === 'on',
	'pad_counts' => true,
);


$number = absint($number);
if ( $number > 0 ) {
	$args['number'] = $number;
}

if (!empty($cat)) {
	$args['include'] =  array_filter(explode(',',$cat),'absint');
}

$product_categories = get_terms( 'product_cat', $args );
$atts['slider'] = $slider_enable === 'on';
$element->prepare_display($atts);
unset($element->_settings['post_layout']);
G5SHOP()->listing()->set_layout_settings($element->_settings);
$element->add_render_attribute('wrapper','class',$wrapper_classes);

?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php
	if ( $product_categories ) {
		woocommerce_product_loop_start();
		foreach ( $product_categories as $category ) {
			wc_get_template( 'content-product_cat.php', array(
				'category' => $category,
				'image_size' => $post_image_size
			) );
		}
		woocommerce_product_loop_end();
		G5SHOP()->listing()->unset_layout_settings();
	}
	?>
</div>
