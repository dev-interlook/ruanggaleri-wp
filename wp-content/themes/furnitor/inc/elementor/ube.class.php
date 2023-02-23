<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('FURNITOR_ELEMENTOR_UBE')) {
	class FURNITOR_ELEMENTOR_UBE
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == null) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{
			add_filter('ube_testimonials_layout_style', array($this, 'testimonials_layout_style'));
			add_filter('ube_testimonials_text_align_condition', array($this, 'testimonials_text_align_condition'));

		}

		public function testimonials_layout_style($layout)
		{
			return wp_parse_args(array(
				'layout-08' => esc_html__('Layout 08', 'furnitor'),
				'layout-09' => esc_html__('Layout 09', 'furnitor'),
			), $layout);
		}

		public function testimonials_text_align_condition($layout)
		{
			return wp_parse_args(array(
				'layout-09',
			), $layout);
		}

	}
}