<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 */
return array(
	'base' => 'g5element_product_category',
	'name' => esc_html__('Product Category', 'furnitor'),
	'category' => G5ELEMENT()->shortcode()->get_category_name(),
	'icon' => 'g5element-vc-icon-product-category',
	'description' => esc_html__('Display single product category', 'furnitor'),
	'params' => array_merge(
		array(
			g5shop_vc_map_add_narrow_category(
				array(
					'multiple' => false,
					'admin_label' => true,
				)
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Custom Images Category', 'furnitor'),
				'param_name' => 'custom_image',
				'value' => '',
				'description' => esc_html__('Upload the custom image icon.', 'furnitor'),
				'std' => '',
			),

			array(
				'type' => 'g5element_number',
				'heading' => esc_html__('Image Width', 'furnitor'),
				'param_name' => 'img_width',
				'description' => esc_html__('Set max width to image category.', 'furnitor'),
			),
			g5element_vc_map_add_element_id(),
			g5element_vc_map_add_extra_class(),
		),
		array(
			g5element_vc_map_add_css_animation(),
			g5element_vc_map_add_animation_duration(),
			g5element_vc_map_add_animation_delay(),
		),
		array(
			g5element_vc_map_add_css_editor(),
			g5element_vc_map_add_responsive(),
		)
	)
);
