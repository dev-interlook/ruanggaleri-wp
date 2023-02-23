<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Elements_Listing_Abstract', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/elementor-listing.class.php'));
}
abstract class G5Shop_Abstracts_Elements_Listing extends G5Core_Elements_Listing_Abstract {
	public static function is_enabled() {
		return function_exists('WC');
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_skin_controls();
		$this->register_item_custom_class_controls();
		$this->register_category_enable_controls();
		$this->register_rating_enable_controls();
		$this->register_excerpt_enable_controls();
		$this->register_columns_controls();
		$this->register_columns_gutter_controls();
		$this->register_post_count_control();
		$this->register_post_offset_control();
		$this->register_post_paging_controls();
		$this->register_post_animation_controls();
		$this->register_cate_filter_controls();
		$this->end_controls_section();
	}

	protected function register_layout_controls() {
		$this->add_control(
			'post_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Product Layout','g5-shop'),
				'description' => esc_html__('Specify your product layout','g5-shop'),
				'options' => $this->get_config_product_layout(),
				'default' => 'grid',
			]
		);
	}

	protected function register_skin_controls() {
		$this->add_control(
			'item_skin',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Item Skin', 'g5-shop'),
				'description' => esc_html__('Specify your product item skin, (Note: Skin 01, Skin 02 only apply for layout Grid)', 'g5-shop'),
				'options' => $this->get_config_product_skins(),
				'default' => 'skin-01'
			]
		);
	}

	protected function register_category_enable_controls() {
		$this->add_control(
			'category_enable',
			[
				'label' => esc_html__('Show Category','g5-shop'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-shop' ),
				'label_off' => esc_html__( 'Hide', 'g5-shop' ),
				'return_value' => 'on',
				'default' => '',
			]
		);
	}

	protected function register_rating_enable_controls() {
		$this->add_control(
			'rating_enable',
			[
				'label' => esc_html__('Show Rating','g5-shop'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-shop' ),
				'label_off' => esc_html__( 'Hide', 'g5-shop' ),
				'return_value' => 'on',
				'default' => '',
			]
		);
	}

	protected function register_excerpt_enable_controls() {
		$this->add_control(
			'excerpt_enable',
			[
				'label' => esc_html__('Show Excerpt','g5-shop'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-shop' ),
				'label_off' => esc_html__( 'Hide', 'g5-shop' ),
				'return_value' => 'on',
				'default' => '',
			]
		);
	}


	protected function register_image_size_section_controls() {
		parent::register_image_size_section_controls();
		$this->update_control('post_image_size',[
			'description' => esc_html__('Enter image size (Example: "woocommerce_thumbnail", "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 300x400).', 'g5-shop'),
			'default' => 'woocommerce_thumbnail',
		]);
		$this->remove_control('post_image_width');

	}


	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'show',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Show', 'g5-shop'),
				'options' => [
					'' => esc_html__('All', 'g5-shop'),
					'sale' => esc_html__('Sale Off', 'g5-shop'),
					'new-in' => esc_html__('New In', 'g5-shop'),
					'featured' => esc_html__('Featured', 'g5-shop'),
					'top-rated' => esc_html__('Top rated', 'g5-shop'),
					'recent-review' => esc_html__('Recent review', 'g5-shop'),
					'best-selling' => esc_html__('Best Selling', 'g5-shop'),
					'products' => esc_html__('Narrow Products', 'g5-shop')
				],
				'default' => ''
			]

		);

		$this->register_cat_controls();
		$this->register_product_ids_controls();
		$this->register_order_by_controls();
		$this->register_order_controls();
		$this->end_controls_section();
	}

	protected function register_cat_controls() {
		$this->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_cat'
				),
				'label' => esc_html__('Narrow Category','g5-shop'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'g5-shop'),
				'default' => '',
				'condition' => [
					'show!' => 'products',
				],
			]
		);
	}

	protected function register_product_ids_controls() {
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'data_args' => array(
					'post_type' => 'product'
				),
				'label' => esc_html__('Narrow Products','g5-shop'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Products', 'g5-shop'),
				'default' => '',
				'condition' => [
					'show' => 'products',
				],
			]
		);

	}

	protected function register_order_by_controls() {
		$this->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'g5-shop'),
				'description' => esc_html__('Select how to sort retrieved products.', 'g5-shop'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'g5-shop'),
					'price' => esc_html__('Price', 'g5-shop'),
					'rand' => esc_html__('Random', 'g5-shop'),
					'sales' => esc_html__('Sales', 'g5-shop'),
				),
				'default' => 'date',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);


	}

	protected function register_order_controls() {
		$this->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'g5-shop'),
				'description' => esc_html__('Select sorting order.', 'g5-shop'),
				'options'     => array(
					'DESC' => esc_html__('Descending', 'g5-shop'),
					'ASC' => esc_html__('Ascending', 'g5-shop'),
				),
				'default' => 'DESC',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);
	}


	protected function register_style_section_controls() {
		$this->register_style_title_section_controls();
		$this->register_style_category_section_controls();
		$this->register_style_price_section_controls();
		$this->register_style_excerpt_section_controls();
	}

	protected function register_style_category_section_controls() {
		$this->start_controls_section(
			'section_design_category',
			[
				'label' => esc_html__( 'Category', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'category_enable' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'selector' => '{{WRAPPER}} .g5shop__loop-product-cat',

			]
		);

		$this->add_control(
			'category_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-shop' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5shop__product-item .g5shop__loop-product-cat + .g5shop__loop-product-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'category_color_tabs');

		$this->start_controls_tab( 'category_color_normal',
			[
				'label' => esc_html__( 'Normal', 'g5-shop' ),
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => esc_html__( 'Color', 'g5-shop' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5shop__loop-product-cat' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'category_color_hover',
			[
				'label' => esc_html__( 'Hover', 'g5-shop' ),
			]
		);


		$this->add_control(
			'category_hover_color',
			[
				'label' => esc_html__( 'Color', 'g5-shop' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5shop__loop-product-cat:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
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
				'selector' => '{{WRAPPER}} .g5shop__loop-product-title',

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
					'{{WRAPPER}} .g5shop__loop-product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .g5shop__loop-product-title' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .g5shop__loop-product-title:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function register_style_price_section_controls() {
		$this->start_controls_section(
			'section_design_price',
			[
				'label' => esc_html__( 'Price', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .g5shop__product-item .g5shop__product-info .price',

			]
		);

		$this->add_control(
			'price_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-shop' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5shop__product-item .g5shop__product-info .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'g5-shop' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5shop__product-item .g5shop__product-info .price' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function register_style_excerpt_section_controls() {
		$this->start_controls_section(
			'section_design_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'excerpt_enable' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .g5shop__product-item .g5shop__loop-product_excerpt',

			]
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-shop' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5shop__product-item .g5shop__loop-product_excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => esc_html__( 'Color', 'g5-shop' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5shop__product-item .g5shop__loop-product_excerpt' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function register_tabs_section_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => esc_html__( 'Tabs', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->register_tabs_cate_filter_controls();

		$this->register_tabs_controls();

		$this->end_controls_section();
	}


	protected function register_tabs_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'g5-shop' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);



		$this->register_layout_controls();

		$this->register_skin_controls();

		$this->register_item_custom_class_controls();

		$this->register_category_enable_controls();
		$this->register_rating_enable_controls();
		$this->register_excerpt_enable_controls();

		$this->register_columns_controls();
		$this->register_columns_gutter_controls();
		$this->register_post_count_control();
		$this->register_post_offset_control();

		$this->register_post_paging_controls();
		$this->register_post_animation_controls();

		$this->end_controls_section();
	}

	protected function register_tabs_controls() {

		$product_tabs = new \Elementor\Repeater();

		$product_tabs->add_control(
			'product_tab_title',
			[
				'label' => esc_html__('Title', 'g5-shop' ),
				'type' => Controls_Manager::TEXT
			]
		);

		$product_tabs->add_control(
			'product_tab_icon_type', [
				'label'       => esc_html__( 'Icon Type', 'g5-shop' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					''  => [
						'title' => esc_html__( 'None', 'g5-shop' ),
						'icon'  => 'fa fa-ban',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'g5-shop' ),
						'icon'  => 'fa fa-paint-brush',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'g5-shop' ),
						'icon'  => 'fa fa-image',
					],
				],
				'default'     => '',
			]
		);

		$product_tabs->add_control(
			'product_tab_icon', [
				'label'       => esc_html__( 'Icon', 'g5-shop' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => [
					'value'   => 'fas fa-address-book',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'product_tab_icon_type' => 'icon'
				]
			]
		);

		$product_tabs->add_control(
			'product_tab_image',
			[
				'label'     => esc_html__( 'Image', 'g5-shop' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'product_tab_icon_type' => 'image'
				]
			]
		);


		$product_tabs->add_control(
			'show',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Show', 'g5-shop'),
				'options' => [
					'' => esc_html__('All', 'g5-shop'),
					'sale' => esc_html__('Sale Off', 'g5-shop'),
					'new-in' => esc_html__('New In', 'g5-shop'),
					'featured' => esc_html__('Featured', 'g5-shop'),
					'top-rated' => esc_html__('Top rated', 'g5-shop'),
					'recent-review' => esc_html__('Recent review', 'g5-shop'),
					'best-selling' => esc_html__('Best Selling', 'g5-shop'),
					'products' => esc_html__('Narrow Products', 'g5-shop')
				],
				'default' => '',
				'separator'  => 'before',
			]

		);


		$product_tabs->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_cat'
				),
				'label' => esc_html__('Narrow Category','g5-shop'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'g5-shop'),
				'default' => '',
				'condition' => [
					'show!' => 'products',
				],
			]
		);

		$product_tabs->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'data_args' => array(
					'post_type' => 'product'
				),
				'label' => esc_html__('Narrow Products','g5-shop'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Products', 'g5-shop'),
				'default' => '',
				'condition' => [
					'show' => 'products',
				],
			]
		);

		$product_tabs->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'g5-shop'),
				'description' => esc_html__('Select how to sort retrieved products.', 'g5-shop'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'g5-shop'),
					'price' => esc_html__('Price', 'g5-shop'),
					'rand' => esc_html__('Random', 'g5-shop'),
					'sales' => esc_html__('Sales', 'g5-shop'),
				),
				'default' => 'date',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);

		$product_tabs->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'g5-shop'),
				'description' => esc_html__('Select sorting order.', 'g5-shop'),
				'options'     => array(
					'DESC' => esc_html__('Descending', 'g5-shop'),
					'ASC' => esc_html__('Ascending', 'g5-shop'),
				),
				'default' => 'DESC',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__('Product Tabs', 'g5-shop'),
				'type'      => Controls_Manager::REPEATER,
				'title_field' => '{{ product_tab_title }}',
				'default'     => [
					[
						'product_tab_title' => esc_html__( 'Sale Off', 'g5-shop' ),
						'show' => 'sale',
						'orderby' => 'sales',
						'order' => 'DESC',
					],
					[
						'product_tab_title' => esc_html__( 'New In', 'g5-shop' ),
						'show' => 'new-in',
						'order' => 'DESC',
					],
					[
						'product_tab_title' => esc_html__( 'Featured', 'g5-shop' ),
						'show' => 'featured',
						'orderby' => 'date',
						'order' => 'DESC',
					],
				],
				'fields'    => $product_tabs->get_controls(),

			]
		);
	}

	protected function register_tabs_cate_filter_controls() {

		$this->add_control(
			'cate_filter_align',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Tabs Align','g5-shop'),
				'options' => G5CORE()->settings()->get_category_filter_align(),
				'default' => '',
			]
		);

		$this->add_control(
			'append_tabs',
			[
				'label' => esc_html__( 'Append Tabs', 'g5-shop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Change where the tabs are attached (Selector, htmlString, Array, Element, jQuery object)', 'g5-shop' ),
				'default' => '',
			]
		);
	}


	public function get_config_product_layout()
	{
		$config = apply_filters('g5shop_elementor_product_layout', array(
			'grid' => array(
				'label' => esc_html__('Grid', 'g5-shop'),
				'priority' => 10,
			),
			'list' => array(
				'label' => esc_html__('List', 'g5-shop'),
				'priority' => 20,
			),
		));
		uasort( $config, 'g5core_sort_by_order_callback' );
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;

	}

	public function get_config_product_skins() {

		$config = apply_filters('g5shop_elementor_product_skins', array(
			'skin-01' => array(
				'label' => esc_html__('Skin 01', 'g5-shop'),
				'priority' => 10,
			),
			'skin-02' => array(
				'label' => esc_html__('Skin 02', 'g5-shop'),
				'priority' => 20,
			),
			'skin-03' => array(
				'label' => esc_html__('Skin 03', 'g5-shop'),
				'priority' => 30,
			),
		));
		uasort( $config, 'g5core_sort_by_order_callback' );
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;
	}

}
