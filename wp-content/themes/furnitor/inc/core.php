<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('FURNITOR_CORE')) {
	class FURNITOR_CORE {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			spl_autoload_register(array($this, 'autoload'));
			add_action('g5blog_init',array($this->blog(),'init'));
			add_action('g5shop_init',array($this->shop(),'init'));
			add_action('g5element_init',array($this->element(),'init'));
			add_filter('g5core_theme_info',array($this,'change_theme_info'));

			$this->init();
		}



		public function init() {
			//$this->loadFile($this->themeDir('inc/core/template-hooks.php'));
			add_filter('g5core_paging_load_more_css_class',array($this,'change_paging_load_more_css_class'));
		}

		public function change_paging_load_more_css_class($css_classes) {
			return wp_parse_args(array('btn-outline'),$css_classes);
		}


		public function autoload($class) {
			$file_name = preg_replace('/^FURNITOR_CORE_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->loadFile($this->themeDir("inc/core/{$file_name}.class.php"));
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

		public function change_theme_info($info) {
			return wp_parse_args(array(
				'docs'    => 'http://document.g5plus.net/furnitor/',
				'video_tutorials_url' => 'https://www.youtube.com/watch?v=3dyvEH7sTow&list=PL_DzVbdOfv7Hw5lpKDZt6huRW7dWG05_c',
				'changelog' => 'https://furnitor.g5plus.net/changelog.html',
			),$info);
		}

		/**
		 * @return FURNITOR_CORE_BLOG
		 */
		public function blog() {
			return FURNITOR_CORE_BLOG::getInstance();
		}

		/**
		 * @return FURNITOR_CORE_SHOP
		 */
		public function shop() {
			return FURNITOR_CORE_SHOP::getInstance();
		}

		/**
		 * @return FURNITOR_CORE_ELEMENT
		 */
		public function element() {
			return FURNITOR_CORE_ELEMENT::getInstance();
		}

	}
	function FURNITOR_CORE() {
		return FURNITOR_CORE::getInstance();
	}
	FURNITOR_CORE()->init();
}