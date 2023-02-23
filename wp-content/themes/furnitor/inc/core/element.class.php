<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('FURNITOR_CORE_ELEMENT')) {
	class FURNITOR_CORE_ELEMENT
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
			add_filter('gsf_testimonials_layout_style', array($this, 'add_testimonials_layout'));

		}

		public function add_testimonials_layout($layout)
		{
			return wp_parse_args(array(
				'style-08' => array(
					'label' => esc_html__('Style 08', 'furnitor'),
					'img' => get_parent_theme_file_uri('assets/images/testimonial-08.png'),
				),
				'style-09' => array(
					'label' => esc_html__('Style 09', 'furnitor'),
					'img' => get_parent_theme_file_uri('assets/images/testimonial-09.png'),
				),
			), $layout);
		}
	}
}