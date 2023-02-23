<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5Shop_Elementor')) {
	class G5Shop_Elementor {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter('ube_get_element_configs',array($this,'change_ube_get_element_configs'));
			add_filter('ube_autoload_file_dir',array($this,'change_ube_autoload_file_dir'),10,2);
			add_filter('ube_element_listing_query_args',array($this,'set_query_args'),10,2);
			add_action( 'init', array( $this, 'register_scripts' ) );
		}

		public function register_scripts() {
			wp_register_script(G5SHOP()->assets_handle('products'),G5SHOP()->asset_url('assets/js/elements/products.min.js'),array(),G5BLOG()->plugin_ver());
			wp_register_script(G5SHOP()->assets_handle('products-slider'),G5SHOP()->asset_url('assets/js/elements/products-slider.min.js'),array(),G5BLOG()->plugin_ver());
			wp_register_script(G5SHOP()->assets_handle('product-tabs'),G5SHOP()->asset_url('assets/js/elements/product-tabs.min.js'),array(),G5BLOG()->plugin_ver());
			wp_register_script(G5SHOP()->assets_handle('product-slider-tabs'),G5SHOP()->asset_url('assets/js/elements/product-slider-tabs.min.js'),array(),G5BLOG()->plugin_ver());
			wp_register_script(G5SHOP()->assets_handle('product-categories'),G5SHOP()->asset_url('assets/js/elements/product-categories.min.js'),array(),G5BLOG()->plugin_ver());
		}

		private function get_elements() {
			return apply_filters('g5shop_elements',array(
				'Products' => esc_html__('Products','g5-shop'),
				'Products_Slider' => esc_html__('Products','g5-shop'),
				'Product_Tabs' => esc_html__('Product Tabs','g5-shop'),
				'Product_Slider_Tabs' => esc_html__('Product Slider Tabs','g5-shop'),
				'Product_Categories' => esc_html__('Product Categories','g5-shop'),
			));
		}

		public function change_ube_get_element_configs($configs) {

			$elements = $this->get_elements();

			$g5_elements = isset($configs['g5_elements']) ? $configs['g5_elements'] : array(
				'title' => esc_html__('G5 Elements', 'g5-shop'),
				'items' => array()
			);

			foreach ($elements as $k => $v) {
				$g5_elements['items']["G5Shop_{$k}"] = array(
					'title' => $v
				);
			}

			$configs['g5_elements'] = $g5_elements;
			return $configs;
		}

		public function change_ube_autoload_file_dir($path, $class) {
			$prefix = 'UBE_Element_G5Shop_';
			if (strpos($class,$prefix) === 0) {
				$file_name = substr($class,strlen($prefix));
				$file_name = str_replace( '_', '-', $file_name );
				$file_name = strtolower( $file_name );
				return G5SHOP()->locate_template("elements/$file_name/config.php");

			}
			return $path;
		}

		public function set_query_args($query_args,$atts) {
			if ($query_args['post_type'] === 'product') {
				$query_args['meta_query'] = array();
				$query_args['tax_query'] = array(
					'relation' => 'AND',
				);

				$product_visibility_term_ids = wc_get_product_visibility_term_ids();
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
					'operator' => 'NOT IN',
				);
				$query_args['post_parent'] = 0;


				if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
					$query_args['tax_query'][] = array(
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'term_taxonomy_id',
							'terms'    => $product_visibility_term_ids['outofstock'],
							'operator' => 'NOT IN',
						),
					); // WPCS: slow query ok.
				}

				if (!isset($atts['show'])) {
					$atts['show'] = '';
				}

				switch ( $atts['show'] ) {
					case 'featured':
						$query_args['tax_query'][] = array(
							'taxonomy' => 'product_visibility',
							'field'    => 'term_taxonomy_id',
							'terms'    => $product_visibility_term_ids['featured'],
						);
						break;
					case 'sale':
						$product_ids_on_sale    = wc_get_product_ids_on_sale();
						$product_ids_on_sale[]  = 0;
						$query_args['post__in'] = $product_ids_on_sale;
						break;
					case 'new-in':
						$query_args['orderby'] = 'date';
						$query_args['order'] = 'DESC';
						break;
					case 'top-rated':
						$query_args['meta_key'] = '_wc_average_rating';
						$query_args['orderby'] = 'meta_value_num';
						$query_args['order'] = 'DESC';
						$query_args['meta_query'] = WC()->query->get_meta_query();
						$query_args['tax_query'] = WC()->query->get_tax_query();
						break;
					case 'recent-review':
						add_filter( 'posts_clauses', array(G5SHOP()->shortcodes(), 'order_by_comment_date_post_clauses' ) );
						break;
					case 'best-selling' :
						$query_args['meta_key'] = 'total_sales';
						$query_args['orderby'] = 'meta_value_num';
						break;
					case 'products':
						$query_args['post__in'] = array_map('absint',$atts['ids']);
						$query_args['posts_per_page'] = -1;
						$query_args['orderby'] = 'post__in';
						break;
				}


				if (in_array($atts['show'],array('','sale','featured'))) {
					switch ( $atts['orderby'] ) {
						case 'price':
							$query_args['meta_key'] = '_price'; // WPCS: slow query ok.
							$query_args['orderby']  = 'meta_value_num';
							break;
						case 'rand':
							$query_args['orderby'] = 'rand';
							break;
						case 'sales':
							$query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
							$query_args['orderby']  = 'meta_value_num';
							break;
						default:
							$query_args['orderby'] = 'date';
					}
				}


				if ($atts['show'] !== 'products' && !empty($atts['cat'])) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_cat',
						'terms' => array_map('absint',$atts['cat']),
						'field' => 'id',
						'operator' => 'IN'
					);
				}

			}

			return $query_args;
		}
	}
}