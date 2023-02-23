<?php
/**
 * Setup theme install demo
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5ThemeAddons_Setup_Install_Demo')) {
	class G5ThemeAddons_Setup_Install_Demo {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter('gid_demo_list', array($this, 'theme_demo_list'));
		}

		public function theme_demo_list($demo_list) {
			return array(
				'main' => array(
					'name' => esc_html__( 'Main (Use With WPBakery Page Builder)', 'furnitor-addons' ),
					'thumbnail' => GTA()->plugin_url('assets/demo-data/main/preview.jpg'),
					'preview' => 'https://furnitor.g5plus.net/',
					//'preview' => 'http://dev.g5plus.net/furnitor/',
					'dir' => GTA()->plugin_dir('assets/demo-data/main/'),
					'theme' => 'furnitor',
					'builder' => 'vc',
				),
				'elementor' => array(
					'name' => esc_html__( 'Elementor (Use With Elementor)', 'furnitor-addons' ),
					'thumbnail' => GTA()->plugin_url('assets/demo-data/elementor/preview.jpg'),
					'preview' => 'https://furnitor-elementor.g5plus.net/',
					//'preview' => 'http://dev.g5plus.net/furnitor-elementor/',
					'dir' => GTA()->plugin_dir('assets/demo-data/elementor/'),
					'theme' => 'furnitor',
					'builder' => 'elementor',
				),
			);
		}
	}
}