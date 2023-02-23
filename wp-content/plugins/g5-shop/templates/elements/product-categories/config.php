<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5SHOP()->load_file( G5SHOP()->plugin_dir( 'inc/abstract/elementor-listing.class.php' ) );
}

class UBE_Element_G5Shop_Product_Categories extends G5Shop_Abstracts_Elements_Listing {

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
	public function get_name() {
		return 'ube-g5-product-categories';
	}

	public function get_title() {
		return esc_html__( 'G5 Product Categories', 'g5-shop' );
	}

	public function get_ube_icon() {
		return 'eicon-product-categories';
	}

	public function get_ube_keywords() {
		return array('product categories', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5' );
	}

	public function get_script_depends() {
		return array(G5SHOP()->assets_handle('product-categories'));
	}

	public function render() {
		G5SHOP()->get_template( 'elements/product-categories/template.php', array(
			'element' => $this
		) );
	}

	protected function _register_controls() {
		$this->register_general_section_controls();
		$this->register_slider_section_controls();
		$this->register_style_section_controls();

	}

	protected function register_general_section_controls() {
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_cat_controls();

		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Total Categories', 'g5-core' ),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Enter number of category you want to display', 'g5-core'),
				'default' => '',
			]
		);

		$this->register_columns_controls();

		$this->register_columns_gutter_controls();

		$this->register_order_by_controls();

		$this->register_order_controls();

		$this->register_hide_empty_controls();

		$this->register_image_size_controls();

		$this->add_control(
			'slider_enable',
			[
				'label'        => esc_html__( 'Slider', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_cat_controls() {
		parent::register_cat_controls();
		$this->update_control('cat',[
			'condition' => []
		]);
	}

	protected function register_columns_controls() {
		parent::register_columns_controls();
		$this->update_control('post_columns',[
			'condition' => []
		]);
	}

	protected function register_order_by_controls() {
		$this->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'g5-shop'),
				'options'     => array(
					'menu_order' =>  esc_html__('Category order', 'g5-shop'),
					'name' => esc_html__('Name', 'g5-shop'),
					'include' => esc_html__('Include', 'g5-shop'),
				),
				'default' => 'menu_order',
			]
		);
	}

	protected function register_order_controls() {
		parent::register_order_controls();
		$this->update_control('order',[
			'condition' => []
		]);
	}

	protected function register_hide_empty_controls() {
		$this->add_control(
			'hide_empty',
			[
				'label' => esc_html__('Hide Empty','g5-shop'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'g5-shop' ),
				'label_off' => esc_html__( 'No', 'g5-shop' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);
	}

	protected function register_image_size_controls() {
		$this->add_control(
			'post_image_size',
			[
				'label' => esc_html__( 'Image size', 'g5-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 300x400).', 'g5-shop'),
				'default' => '',
			]
		);

	}


	protected function register_slider_section_controls() {
		parent::register_slider_section_controls();
		$this->update_control('section_slider',[
			'condition' => [
				'slider_enable' => 'on',
			]
		]);
	}

	protected function register_style_section_controls() {
		$this->register_style_title_section_controls();
	}

	protected function register_style_title_section_controls() {
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__( 'Title', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .woocommerce-loop-category__title',

			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-shop' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5shop__product-cat-info' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'title_color_tabs');

		$this->start_controls_tab( 'title_color_normal',
			[
				'label' => esc_html__( 'Normal', 'g5-shop' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'g5-shop' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-loop-category__title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover',
			[
				'label' => esc_html__( 'Hover', 'g5-shop' ),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'g5-shop' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-loop-category__title:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}
}