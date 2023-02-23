<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

use \Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;

class UBE_Element_G5Shop_Product_Category extends UBE_Abstracts_Elements
{

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 * @since 1.4.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return 'ube-g5-product-category';
	}

	public function get_title()
	{
		return esc_html__('G5 Product Category', 'furnitor');
	}

	public function get_ube_icon()
	{
		return 'eicon-products';
	}

	public function get_ube_keywords()
	{
		return array('products', 'product category', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type', 'ube', 'g5');
	}

	public function get_script_depends()
	{
		return array();
	}

	public function get_style_depends()
	{
		return array();
	}

	protected function _register_controls()
	{

		$this->start_controls_section('setting_section', [
			'label' => esc_html__('Setting', 'furnitor'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);


		$this->add_control(
			'category',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => false,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_cat'
				),
				'label' => esc_html__('Narrow Category', 'furnitor'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'furnitor'),
				'default' => '',
			]
		);

		$this->add_control(
			'custom_image',
			[
				'label' => esc_html__('Custom Images Category', 'furnitor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control('max_width_img', [
			'label' => esc_html__('Image Width', 'furnitor'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 1000,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .g5element__product_category-image' => 'max-width: {{SIZE}}{{UNIT}};flex: {{SIZE}}{{UNIT}};-ms-flex: {{SIZE}}{{UNIT}}',
			],
		]);

		$this->add_responsive_control('spacing_img', [
			'label' => esc_html__('Spacing', 'furnitor'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 400,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .g5element__product_category-image' => 'margin-right: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('category_style_section', [
			'label' => esc_html__('Category', 'furnitor'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control(
			'category_color',
			[
				'label' => esc_html__('Color', 'furnitor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5element__product_category-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'selector' => '{{WRAPPER}} .g5element__product_category-title',
			]
		);

		$this->add_responsive_control(
			'category_margin',
			[
				'label' => esc_html__('Margin', 'furnitor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .g5element__product_category-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('count_style_section', [
			'label' => esc_html__('Count', 'furnitor'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control(
			'count_color',
			[
				'label' => esc_html__('Color', 'furnitor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5element__product_category-count-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'count_typography',
				'selector' => '{{WRAPPER}} .g5element__product_category-count-item',
			]
		);

		$this->add_responsive_control(
			'count_margin',
			[
				'label' => esc_html__('Margin', 'furnitor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .g5element__product_category-count-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	public function render()
	{
		G5SHOP()->get_template('elements/product-category/template.php', array(
			'element' => $this
		));
	}
}