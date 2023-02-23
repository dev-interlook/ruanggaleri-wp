<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('FURNITOR_ELEMENTOR')) {
	class FURNITOR_ELEMENTOR {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
		public function __construct() {
			spl_autoload_register(array($this, 'autoload'));
		}

		public function init(){
			add_action('g5blog_init',array($this->blog(),'init'));
			add_action('g5shop_init',array($this->shop(),'init'));
			add_action('ube_init',array($this->ube(),'init'));
		}

		public function autoload($class) {
			$file_name = preg_replace('/^FURNITOR_ELEMENTOR_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->loadFile($this->themeDir("inc/elementor/{$file_name}.class.php"));
			}
		}

		public function loadFile($path) {
			if ( $path && is_readable($path) ) {
				include_once($path);
				return true;
			}
			return false;
		}

		public function themeDir($path = '') {
			return trailingslashit(get_template_directory()) . $path;
		}

		/**
		 * @return FURNITOR_ELEMENTOR_BLOG
		 */
		public function blog() {
			return FURNITOR_ELEMENTOR_BLOG::getInstance();
		}

		/**
		 * @return FURNITOR_ELEMENTOR_SHOP
		 */
		public function shop() {
			return FURNITOR_ELEMENTOR_SHOP::getInstance();
		}

		/**
		 * @return FURNITOR_ELEMENTOR_UBE
		 */
		public function ube() {
			return FURNITOR_ELEMENTOR_UBE::getInstance();
		}
	}
	function FURNITOR_ELEMENTOR() {
		return FURNITOR_ELEMENTOR::getInstance();
	}
	FURNITOR_ELEMENTOR()->init();
}