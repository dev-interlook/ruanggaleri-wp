<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('FURNITOR_ELEMENTOR_SHOP')) {
	class FURNITOR_ELEMENTOR_SHOP {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter('g5shop_elementor_product_layout',array($this,'change_product_layout'));
			add_filter('g5shop_elementor_product_skins',array($this,'change_product_skins'));

			add_filter('g5shop_elements',array($this,'change_elements'));

		}

		public function change_product_layout($layout) {
			return wp_parse_args( array(
				'metro-1' => array(
					'label' => esc_html__('Metro 01', 'furnitor'),
					'priority' => 30,
				),
				'metro-2' => array(
					'label' => esc_html__('Metro 02', 'furnitor'),
					'priority' => 40,
				),
			), $layout );
		}

		public function change_product_skins($skins) {
			return wp_parse_args( array(
				'skin-04' => array(
					'label' => esc_html__('Skin 04', 'furnitor'),
					'priority' => 40,
				)
			), $skins );
		}

		public function change_elements($elements) {
			return wp_parse_args(array(
				'Product_Category' => esc_html__('Product Category','furnitor'),
			),$elements);
		}
	}
}