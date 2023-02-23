<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'FURNITOR_CORE_SHOP' ) ) {
	class FURNITOR_CORE_SHOP {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'g5shop_before_get_template_listing_item', array( $this, 'change_skin_classic' ) );
			add_action( 'g5shop_after_get_template_listing_item', array( $this, 'revert_change_skin_classic' ) );

			add_action( 'g5shop_before_get_template_listing_item', array( $this, 'change_skin_04' ) );
			add_action( 'g5shop_after_get_template_listing_item', array( $this, 'revert_change_skin_04' ) );

			add_filter( 'g5shop_options_product_skins', array( $this, 'change_product_skins' ) );

			add_filter( 'g5core_options_header_customize', array( $this, 'header_customize_cate' ) );
			add_filter( 'gsf_term_meta_config', array( $this, 'define_term_cate' ) );

			add_filter( 'g5shop_options_product_catalog_layout', array( $this, 'change_product_catalog_layout' ) );
			add_filter( 'g5shop_options_product_layout', array( $this, 'change_product_catalog_layout' ) );

			add_filter( 'g5shop_config_layout_matrix', array( $this, 'change_config_layout_matrix' ) );


			add_action( 'woocommerce_single_product_summary', array( $this, 'change_single_product_price' ), 1 );

			add_action( 'woocommerce_simple_add_to_cart', array( $this, 'change_add_to_cart_quantity' ) );
			add_action( 'woocommerce_single_variation', array( $this, 'change_add_to_cart_quantity' ) );

			add_filter( 'g5core_default_options_g5shop_options', array(
				$this,
				'change_default_options_g5shop_options'
			) );

			add_filter( 'g5shop_shortcodes', array( $this, 'define_shortcodes' ) );

			add_action( 'template_redirect', array( $this, 'demo_layout' ), 15 );

			add_action( 'pre_get_posts', array( $this, 'demo_post_per_pages' ), 15 );

			add_filter( 'g5shop_get_current_page_url', array( $this, 'change_g5shop_get_current_page_url' ) );


		}

		public function change_g5shop_get_current_page_url( $link ) {
			if ( isset( $_GET['shop_layout'] ) ) {
				$link = add_query_arg( 'shop_layout', wc_clean( wp_unslash( $_GET['shop_layout'] ) ), $link );
			}

			if ( isset( $_GET['_gsf_preset'] ) ) {
				$link = add_query_arg( '_gsf_preset', wc_clean( wp_unslash( $_GET['_gsf_preset'] ) ), $link );
			}

			if ( isset( $_GET['site_layout'] ) ) {
				$link = add_query_arg( 'site_layout', wc_clean( wp_unslash( $_GET['site_layout'] ) ), $link );
			}


			return $link;
		}

		public function demo_post_per_pages( $query ) {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5SHOP' ) ) {
				return;
			}
			if ( ! is_admin() && $query->is_main_query() ) {
				$shop_layout    = isset( $_REQUEST['shop_layout'] ) ? $_REQUEST['shop_layout'] : '';
				$post_per_pages = '';

				switch ( $shop_layout ) {
					case 'v2':
						$post_per_pages = 14;
						break;
					case 'v3':
						$post_per_pages = 16;
						break;
					case 'v7':
						$post_per_pages = 6;
						break;
				}

				if ( ! empty( $post_per_pages ) ) {
					$query->set( 'posts_per_page', $post_per_pages );
				}
			}
		}

		public function demo_layout() {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5SHOP' ) ) {
				return;
			}

			if ( is_singular( 'product' ) ) {
				$single_product_layout = isset( $_REQUEST['single_product_layout'] ) ? $_REQUEST['single_product_layout'] : '';


				$site_layout = G5CORE()->options()->layout()->get_option( 'site_layout' );
				if ( $site_layout !== 'none' ) {
					G5SHOP()->options()->set_option( 'product_related_columns_xl', 3 );
					G5SHOP()->options()->set_option( 'product_up_sells_columns_xl', 3 );
				}

				switch ( $single_product_layout ) {
					case 'layout-4':
						G5CORE()->options()->layout()->set_option( 'site_stretched_content', 'on' );
						break;
					case 'layout-5':
						G5CORE()->options()->layout()->set_option( 'site_stretched_content', 'on' );
						G5SHOP()->options()->set_option( 'single_product_breadcrumb_enable', 'off' );
						break;
				}


			}


			$shop_layout = isset( $_REQUEST['shop_layout'] ) ? $_REQUEST['shop_layout'] : '';
			if ( ! empty( $shop_layout ) ) {
				$ajax_query                = G5CORE()->cache()->get( 'g5core_ajax_query', array() );
				$ajax_query['shop_layout'] = $shop_layout;
				G5CORE()->cache()->set( 'g5core_ajax_query', $ajax_query );
			}


			switch ( $shop_layout ) {
				case 'v2':
					G5SHOP()->options()->set_option( 'post_layout', 'metro-2' );
					G5SHOP()->options()->set_option( 'post_paging', 'load-more' );

					break;
				case 'v3':
					G5SHOP()->options()->set_option( 'post_layout', 'metro-1' );
					G5SHOP()->options()->set_option( 'post_paging', 'load-more' );
					break;
				case 'v4':
					G5SHOP()->options()->set_option( 'post_columns_xl', '3' );
					break;
				case 'v5':
					G5SHOP()->options()->set_option( 'item_skin', 'skin-01' );
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', '' );
					G5CORE()->options()->page_title()->set_option( 'page_title_content_block', 2095 );
					G5CORE()->options()->layout()->set_option( 'content_padding', array(
						'top'    => 100,
						'bottom' => 100
					) );
					break;
				case 'v6':
					G5SHOP()->options()->set_option( 'item_skin', 'skin-01' );
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', '' );
					G5CORE()->options()->page_title()->set_option( 'page_title_content_block', 2095 );
					G5CORE()->options()->layout()->set_option( 'content_padding', array(
						'top'    => 100,
						'bottom' => 100
					) );
					G5SHOP()->options()->set_option( 'post_columns_xl', '3' );
					break;
				case 'v7':
					G5SHOP()->options()->set_option( 'item_skin', 'skin-01' );
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', '' );
					G5CORE()->options()->page_title()->set_option( 'page_title_content_block', 2095 );
					G5CORE()->options()->layout()->set_option( 'content_padding', array(
						'top'    => 100,
						'bottom' => 100
					) );
					G5SHOP()->options()->set_option( 'post_columns_xl', '3' );
					G5SHOP()->options()->set_option( 'post_layout', 'list' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'left' );
					break;
				case 'v8':
					G5SHOP()->options()->set_option( 'item_skin', 'skin-01' );
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', '' );
					G5CORE()->options()->page_title()->set_option( 'page_title_content_block', 2099 );
					G5SHOP()->options()->set_option( 'post_columns_xl', '3' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'left' );
					break;
				case 'v9':
					G5SHOP()->options()->set_option( 'item_skin', 'skin-01' );
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', '' );
					G5CORE()->options()->page_title()->set_option( 'page_title_content_block', 2101 );
					G5CORE()->options()->layout()->set_option( 'content_padding', array(
						'top'    => 100,
						'bottom' => 100
					) );
					G5SHOP()->options()->set_option( 'post_columns_xl', '3' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'left' );
					break;

			}


		}

		public function define_shortcodes( $shortcodes ) {
			return wp_parse_args( array( 'product_category' ), $shortcodes );
		}

		public function change_default_options_g5shop_options( $defaults ) {
			return wp_parse_args( array(
				'item_skin'                            => 'skin-04',
				'single_product_tab'                   => 'layout-2',
				'image_hover_effect'                   => 'none',
				'product_category_enable'              => 'on',
				'product_rating_enable'                => 'off'
			), $defaults );
		}

		public function change_add_to_cart_quantity() {
			add_action( 'woocommerce_before_add_to_cart_quantity', array( $this, 'add_to_cart_quantity_wrap_open' ) );
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'add_to_cart_quantity_wrap_close' ), 1 );
		}

		public function change_single_product_price() {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
		}

		public function add_to_cart_quantity_wrap_open() {
			?>
			<div class="g5shop__add-to-cart-quantity-wrap">
			<label class="g5shop__quantity-label"><?php echo esc_html__( 'Quantity', 'furnitor' ) ?></label>
			<div class="g5shop__add-to-cart-quantity">
			<?php
		}

		public function add_to_cart_quantity_wrap_close() {
			?>
			</div>
			</div>
			<?php
		}

		public function header_customize_cate( $header_customize ) {
			$customize        = array(
				'product-cate' => esc_html__( 'Product Cate', 'furnitor' )
			);
			$header_customize = wp_parse_args( $customize, $header_customize );

			return $header_customize;
		}

		public function define_term_cate( $configs ) {
			$prefix                      = G5SHOP()->meta_prefix;
			$configs['g5shop_cate_icon'] = array(
				'name'     => esc_html__( 'Icon Settings', 'furnitor' ),
				'taxonomy' => array( 'product_cat' ),
				'layout'   => 'inline',
				'fields'   => array(
					"{$prefix}product_cate" => array(
						'id'    => "{$prefix}product_cate",
						'title' => esc_html__( 'Icon', 'furnitor' ),
						'type'  => 'image',
					),
				)
			);

			return $configs;
		}


		public function change_skin_classic( $template ) {
			if ( in_array( $template, array( 'skin-01', 'list' ) ) ) {
				add_action( 'woocommerce_shop_loop_item_title', array( $this, 'product_title_price_wrap_open' ), 19 );
				add_action( 'woocommerce_after_shop_loop_item_title', array(
					$this,
					'product_title_price_wrap_close'
				), 11 );
			}

			if ( in_array( $template, array( 'skin-01' ) ) ) {
				add_action( 'woocommerce_after_shop_loop_item_title', array(
					$this,
					'product_price_add_to_cart_wrap_open'
				), 9 );
				add_action( 'woocommerce_after_shop_loop_item_title', array(
					$this,
					'product_price_add_to_cart_wrap_close'
				), 11 );
				add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
				add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 60 );
			}

		}

		public function revert_change_skin_classic( $template ) {
			if ( in_array( $template, array( 'skin-01', 'list' ) ) ) {
				remove_action( 'woocommerce_shop_loop_item_title', array(
					$this,
					'product_title_price_wrap_open'
				), 19 );
				remove_action( 'woocommerce_after_shop_loop_item_title', array(
					$this,
					'product_title_price_wrap_close'
				), 11 );
			}

			if ( in_array( $template, array( 'skin-01' ) ) ) {
				remove_action( 'woocommerce_after_shop_loop_item_title', array(
					$this,
					'product_price_add_to_cart_wrap_open'
				), 9 );
				remove_action( 'woocommerce_after_shop_loop_item_title', array(
					$this,
					'product_price_add_to_cart_wrap_close'
				), 11 );
				remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
				remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 60 );
			}
		}

		public function product_price_add_to_cart_wrap_open() {
			?>
			<div class="g5shop__loop-product-price-add-to-cart">
			<?php
		}

		public function product_price_add_to_cart_wrap_close() {
			?>
			</div>
			<?php
		}

		public function product_title_price_wrap_open() {
			?>
			<div class="g5shop__loop-product-title-price">
			<?php
		}

		public function product_title_price_wrap_close() {
			?>
			</div>
			<?php
		}

		public function change_skin_04( $template ) {
			if ( in_array( $template, array( 'skin-04' ) ) ) {
				remove_action( 'woocommerce_shop_loop_item_title', 'g5shop_template_loop_cat', 10 );
				remove_action( 'woocommerce_shop_loop_item_title', 'g5shop_template_loop_title', 20 );

				add_action( 'woocommerce_before_shop_loop_item_title', array(
					$this,
					'product_title_cat_wrap_open'
				), 1 );
				add_action( 'woocommerce_before_shop_loop_item_title', 'g5shop_template_loop_title', 2 );
				add_action( 'woocommerce_before_shop_loop_item_title', 'g5shop_template_loop_cat', 3 );
				add_action( 'woocommerce_before_shop_loop_item_title', array(
					$this,
					'product_title_price_wrap_close'
				), 4 );
			}
		}

		public function revert_change_skin_04( $template ) {
			if ( in_array( $template, array( 'skin-04' ) ) ) {
				add_action( 'woocommerce_shop_loop_item_title', 'g5shop_template_loop_cat', 10 );
				add_action( 'woocommerce_shop_loop_item_title', 'g5shop_template_loop_title', 20 );


				remove_action( 'woocommerce_before_shop_loop_item_title', array(
					$this,
					'product_title_cat_wrap_open'
				), 1 );
				remove_action( 'woocommerce_before_shop_loop_item_title', 'g5shop_template_loop_title', 2 );
				remove_action( 'woocommerce_before_shop_loop_item_title', 'g5shop_template_loop_cat', 3 );
				remove_action( 'woocommerce_before_shop_loop_item_title', array(
					$this,
					'product_title_price_wrap_close'
				), 4 );
			}
		}

		public function product_title_cat_wrap_open() {
			?>
			<div class="g5shop__loop-product-title-cat">
			<?php
		}

		public function change_product_skins( $config ) {
			return wp_parse_args( array(
				'skin-04' => array(
					'label' => esc_html__( 'Skin 04', 'furnitor' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/skin-04.png' ),
				),
			), $config );
		}

		public function change_product_catalog_layout( $config ) {
			return wp_parse_args( array(
				'metro-1' => array(
					'label' => esc_html__( 'Metro 01', 'furnitor' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/product-layout-metro-01.png' ),
				),
				'metro-2' => array(
					'label' => esc_html__( 'Metro 02', 'furnitor' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/product-layout-metro-02.png' ),
				),
			), $config );

		}

		public function change_config_layout_matrix( $config ) {
			$post_settings = G5SHOP()->listing()->get_layout_settings();
			$item_skin     = isset( $post_settings['item_skin'] ) ? $post_settings['item_skin'] : 'skin-04';
			if ( in_array( $item_skin, array( 'skin-01', 'skin-02' ) ) ) {
				$item_skin = 'skin-04';
			}

			return wp_parse_args( array(
				'metro-1' => array(
					'isotope'    => array(
						'itemSelector'    => 'article',
						'layoutMode'      => 'masonry',
						'percentPosition' => true,
						'masonry'         => array(
							'columnWidth' => '.g5core__col-base',
						),
						'metro'           => true
					),
					'image_mode' => 'background',
					'layout'     => array(
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x2'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 2,
								'lg' => 2,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '2x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),

						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x2'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),

						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 2,
								'lg' => 2,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '2x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
					)
				),
				'metro-2' => array(
					'isotope'    => array(
						'itemSelector'    => 'article',
						'layoutMode'      => 'masonry',
						'percentPosition' => true,
						'masonry'         => array(
							'columnWidth' => '.g5core__col-base',
						),
						'metro'           => true
					),
					'image_mode' => 'background',
					'layout'     => array(
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),

						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 2,
								'lg' => 2,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '2x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),

						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),


						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 4,
								'lg' => 4,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '1x1'
						),
						array(
							'columns'      => g5core_get_bootstrap_columns( array(
								'xl' => 2,
								'lg' => 2,
								'md' => 2,
								'sm' => 1,
								''   => 1
							) ),
							'template'     => $item_skin,
							'layout_ratio' => '2x1'
						),
					)
				),
			), $config );
		}

	}
}