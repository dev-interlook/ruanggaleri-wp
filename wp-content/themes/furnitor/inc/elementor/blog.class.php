<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('FURNITOR_ELEMENTOR_BLOG')) {
	class FURNITOR_ELEMENTOR_BLOG {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter('g5blog_elementor_post_layout',array($this,'change_post_layout'));

			add_filter('g5blog_elementor_post_slider_layout',array($this,'change_post_slider_layout'));

		}

		public function change_post_layout($layout) {
			unset($layout['masonry']);
			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'furnitor'),
					'priority' => 31,
				),
			),$layout);
		}

		public function change_post_slider_layout($layout) {
			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'furnitor'),
					'priority' => 11,
				),
			),$layout);
		}

	}
}