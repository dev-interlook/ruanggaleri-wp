<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if ( ! class_exists( 'FURNITOR_WC' ) ) {
	class FURNITOR_WC {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
			remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
			add_filter('woocommerce_show_page_title',array($this,'remove_page_title'));
			add_filter('furnitor_has_sidebar', array($this,'remove_sidebar'), 100);

			add_filter('wp_list_categories', array($this,'change_cate_count'),15,2);


			add_filter('woocommerce_product_description_heading',array($this,'product_description_heading'));
			add_filter('woocommerce_product_additional_information_heading',array($this,'product_description_heading'));

			add_action('woocommerce_checkout_before_order_review_heading', array($this,'checkout_order_review_wrap_open'),1);
			add_action('woocommerce_checkout_after_order_review', array($this,'checkout_order_review_wrap_close'),100);

			add_filter('woocommerce_review_gravatar_size',array($this,'change_review_gravatar_size'));

		}

		public function remove_sidebar($has_sidebar) {
			if (function_exists('WC') && (is_cart() || is_checkout() || is_account_page()) ) {
				return false;
			}


			if (function_exists('yith_wcwl_object_id')) {
				$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
				if ( ! empty( $wishlist_page_id ) && is_page( $wishlist_page_id ) ) {
					return false;
				}
			}



			return $has_sidebar;
		}

		public function remove_page_title() {
			return false;
		}

		public function product_description_heading() {
			return '';
		}

		public function checkout_order_review_wrap_open() {
			echo '<div id="order_review_wrapper">';
		}

		public function checkout_order_review_wrap_close() {
			echo '</div>';
		}

		public function change_cate_count($links, $args)
		{
			if (isset($args['taxonomy']) && ($args['taxonomy'] == 'product_cat')) {
				$links = str_replace('(', '', $links);
				$links = str_replace(')', '', $links);
			}
			return $links;
		}

		public function change_review_gravatar_size() {
			return 70;
		}

	}

	function FURNITOR_WC() {
		return FURNITOR_WC::getInstance();
	}

	FURNITOR_WC()->init();
}


