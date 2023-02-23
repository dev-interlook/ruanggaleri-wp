<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('FURNITOR_CORE_BLOG')) {
	class FURNITOR_CORE_BLOG{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {

			add_action('g5blog_loop_post_content',array($this,'change_layout'),1);
			add_action('g5blog_loop_post_content',array($this,'revert_change_layout'),100);

			add_filter('g5blog_loop_post_meta_args',array($this,'change_loop_post_meta_args'),10,2);

			add_filter('g5blog_options_post_layout',array($this,'change_post_layout'));

			add_filter('g5blog_post_layout_has_columns',array($this,'change_post_layout_has_columns'));

			add_filter('g5blog_config_layout_matrix',array($this,'change_g5blog_config_layout_matrix'));

			add_action('g5blog_widget_post_content',array($this,'change_layout_widget_post'),1);

			add_filter('g5blog_shortcode_post_layout',array($this,'change_shortcode_post_layout'));

			add_filter('g5blog_shortcode_post_slider_layout',array($this,'change_shortcode_post_slider_layout'));

			add_action('template_redirect', array($this,'demo_layout') ,15);
			add_action( 'pre_get_posts', array( $this, 'demo_post_per_pages' ), 15 );

			add_filter('g5blog_options_single_post_layout',array($this,'change_single_post_layout'));

			add_action('furnitor_before_main_content', array($this,'single_post_header'), 12);

			add_filter('g5blog_single_meta_args',array($this,'change_single_meta_args'));

			add_action('g5blog_single_meta_top',array($this,'single_post_meta_date_template'),4);


			add_filter('g5blog_single_related_settings',array($this,'change_single_related_settings'));

			add_filter( 'g5core_default_options_g5blog_options', array($this,'change_default_options'), 11 );

			add_filter( 'g5core_default_options_g5core_options', array($this,'change_default_single_blog_page_title'), 11 );



		}

		public function change_layout($post_layout) {
			remove_action('g5blog_loop_post_content','g5blog_template_loop_post_meta',10);
			add_action('g5blog_loop_post_content','g5blog_template_loop_post_meta',4);
			if (in_array($post_layout,array('large-image','medium-image','grid'))) {
				add_action('g5blog_loop_post_content',array($this,'template_loop_read_more'),20);
			}

		/*	if ($post_layout === 'grid-2') {
				remove_action('g5blog_loop_post_content','g5blog_template_loop_excerpt',15);
			}*/


		}

		public function revert_change_layout($post_layout) {
			if (in_array($post_layout,array('large-image','medium-image','grid'))) {
				remove_action('g5blog_loop_post_content',array($this,'template_loop_read_more'),20);
			}

		/*	if ($post_layout === 'grid-2') {
				add_action('g5blog_loop_post_content','g5blog_template_loop_excerpt',15);
			}*/
		}

		public function change_layout_widget_post() {
			remove_action('g5blog_widget_post_content','g5blog_template_widget_post_meta',10);
			add_action('g5blog_widget_post_content','g5blog_template_widget_post_meta',4);
		}


		public function change_loop_post_meta_args($post_meta,$post_layout){
			$post_meta = array(
				'date'    => true,
			);

			return $post_meta;
		}


		public function template_loop_read_more() {
			furnitor_get_template('post/read-more');
		}

		public function change_post_layout($layout) {
			unset($layout['masonry']);
			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'furnitor'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 31,
				),
			),$layout);
		}

		public function change_shortcode_post_layout($layout) {
			unset($layout['masonry']);

			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'furnitor'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 31,
				),
			),$layout);
		}





		public function change_shortcode_post_slider_layout($layout) {
			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'furnitor'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 11,
				),
			),$layout);
		}

		public function change_g5blog_config_layout_matrix($layout_matrix) {
			return wp_parse_args(array(
				'grid-2' => array(
					'layout' => array(
						array('template' => 'grid', 'template_class' => 'g5blog__post-grid g5blog__post-grid-2')
					),
				),
			),$layout_matrix);
		}


		public function change_post_layout_has_columns($post_layout) {
			return wp_parse_args(array('grid-2'),$post_layout);
		}



		public function change_single_meta_args($args) {
			return array(
				'author'  => true,
				'cat'    => true,
				'comment' => false,
				'view' => true,
				'like' => true
			);
		}

		public function change_single_related_settings($args) {
			return wp_parse_args(array(
					'post_layout' => 'grid-2',
					'image_size' => '370x240',
					'placeholder' => 'on',
					'excerpt_enable' => ''
			),$args);
		}

		public function change_default_options($defaults) {
			return wp_parse_args(array(
				'single_post_related_columns_xl' => 2,
				'single_post_related_columns_lg' => 2,
				'single_post_related_columns_md' => 2,
				'single_post_related_columns_sm' => 2,
				'single_post_related_columns' => 1,
				'single_post_navigation_enable' => 'on',
				'single_post_author_info_enable' => '',
				'single_post_related_enable' => 'on',
				'single_post_layout' => 'layout-1',

			),$defaults) ;
		}

		public function demo_layout() {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5BLOG' ) ) {
				return;
			}
			$post_layout = isset( $_REQUEST['post_layout'] ) ? $_REQUEST['post_layout'] : '';

			if ( ! empty( $post_layout ) ) {
				$ajax_query                = G5CORE()->cache()->get( 'g5core_ajax_query', array() );
				$ajax_query['post_layout'] = $post_layout;
				G5CORE()->cache()->set( 'g5core_ajax_query', $ajax_query );
			}

			$has_sidebar = furnitor_has_sidebar();

			if ( ! empty( $post_layout ) ) {
				switch ( $post_layout ) {
					case 'large-image':
						G5BLOG()->options()->set_option('post_layout','large-image');
						G5BLOG()->options()->set_option('post_image_size','830x425');
						break;
					case 'grid':
					case 'grid-2':
						G5BLOG()->options()->set_option('post_layout',$post_layout);
						G5BLOG()->options()->set_option('post_columns_gutter','30');
						G5BLOG()->options()->set_option('post_columns_xl','3');
						G5BLOG()->options()->set_option('post_columns_lg','3');
						G5BLOG()->options()->set_option('post_columns_md','3');
						G5BLOG()->options()->set_option('post_columns_sm','2');
						G5BLOG()->options()->set_option('post_columns','1');
						G5BLOG()->options()->set_option('post_image_size','370x240');
						if ($has_sidebar) {
							G5BLOG()->options()->set_option('post_columns_xl','2');
							G5BLOG()->options()->set_option('post_columns_lg','2');
							G5BLOG()->options()->set_option('post_columns_md','2');
						}
						break;
					case 'medium-image':
						G5BLOG()->options()->set_option('post_layout','medium-image');
						G5BLOG()->options()->set_option('post_image_size','420x270');
						break;
				}


			}

		}

		public function demo_post_per_pages( $query ) {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5BLOG' ) ) {
				return;
			}
			if ( ! is_admin() && $query->is_main_query() ) {
				$post_layout = isset( $_REQUEST['post_layout'] ) ? $_REQUEST['post_layout'] : '';
				if ( empty( $post_layout ) ) {
					return;
				}
				$site_layout = isset( $_REQUEST['site_layout'] ) ? $_REQUEST['site_layout'] : '';
				if ( ! empty( $site_layout ) ) {
					G5CORE()->options()->layout()->set_option( 'site_layout', $site_layout );
				}
				$has_sidebar = furnitor_has_sidebar();
				switch ( $post_layout ) {
					case 'grid':
					case 'grid-2':
						$query->set( 'posts_per_page', 9 );
						if ( $has_sidebar ) {
							$query->set( 'posts_per_page', 8 );
						}
						break;
					case 'medium-image':
						$query->set( 'posts_per_page', 6 );
						break;
					case 'large-image':
						$query->set( 'posts_per_page', 6 );
						break;
				}
			}

		}

		public function change_single_post_layout() {
			return array(
				'layout-1' => array(
					'label' => esc_html__('Layout 1', 'furnitor'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-1.png'),
					'priority' => 10,
				)
			);
		}

		public function single_post_header() {
			if (!is_singular('post')) return;
			G5BLOG()->get_template('single/featured/layout-1.php');
		}

		public function single_post_meta_date_template() {
			g5blog_template_post_meta(array('date' => true));
		}


		public function change_default_single_blog_page_title($defaults) {
			return wp_parse_args(array(
				'post_single__page_title_enable' => 'off'
			),$defaults) ;
		}

	}
}