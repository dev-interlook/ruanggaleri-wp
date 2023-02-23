<?php
add_filter('g5core_theme_font_default', 'furnitor_font_default');
function furnitor_font_default()
{
	return array(
		array(
			'family'   => 'SofiaPro',
			'kind'     => 'custom',
			'css_url' => get_theme_file_uri('/assets/fonts/sofiapro/stylesheet.min.css'),
			'variants' => array(
				"300italic",
				"300",
				"400italic",
				"400",
				"500italic",
				"500",
				"700italic",
				"700",
			),
		)
	);
}

if (!class_exists('FURNITOR_SETUP_DATA')) {
	class FURNITOR_SETUP_DATA {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter('g5core_default_options_g5core_typography_options', array($this, 'change_default_options_g5core_typography_options'));
			add_filter('g5core_default_options_g5core_color_options', array($this, 'change_default_options_g5core_color_options'));
			add_filter( 'g5core_default_options_g5core_layout_options', array($this, 'change_default_options_g5core_layout_options') );

			add_filter('g5core_default_options_g5core_header_options', array($this, 'change_default_options_g5core_header_options'));

			add_filter('g5core_header_options', array($this, 'change_g5core_header_options_config'), 20);

		}
		public function change_default_options_g5core_typography_options($defaults) {
			return wp_parse_args(array(
				'body_font' =>
					array (
						'font_family' => 'SofiaPro',
						'font_size' => '16px',
						'font_weight' => '400',
					),
				'primary_font' => array(
					'font_family' => 'SofiaPro'
				),

				'h1_font' =>
					array (
						'font_family' => 'SofiaPro',
						'font_size' => '48px',
						'font_weight' => '700',
					),
				'h2_font' =>
					array (
						'font_family' => 'SofiaPro',
						'font_size' => '44px',
						'font_weight' => '700',
					),
				'h3_font' =>
					array (
						'font_family' => 'SofiaPro',
						'font_size' => '36px',
						'font_weight' => '700',
					),
				'h4_font' =>
					array (
						'font_family' => 'SofiaPro',
						'font_size' => '24px',
						'font_weight' => '700',
					),
				'h5_font' =>
					array (
						'font_family' => 'SofiaPro',
						'font_size' => '20px',
						'font_weight' => '700',
					),
				'h6_font' =>
					array (
						'font_family' => 'SofiaPro',
						'font_size' => '16px',
						'font_weight' => '700',
					),
				'display_1' => array(
					'font_family' => 'SofiaPro',
					'font_size' => '16px',
				),
				'display_2' => array(
					'font_family' => 'SofiaPro',
					'font_size' => '16px',
				),
				'display_3' => array(
					'font_family' => 'SofiaPro',
					'font_size' => '16px',
				),
				'display_4' => array(
					'font_family' => 'SofiaPro',
					'font_size' => '16px',
				),
			), $defaults);
		}

		public function change_default_options_g5core_color_options($defaults) {
			return wp_parse_args(array(
				'site_text_color'   => '#777',
				'accent_color'      => '#000',
				'link_color'        => '#000',
				'border_color'      => '#e4e4e4',
				'heading_color'     => '#000',
				'caption_color'     => '#999',
				'placeholder_color' => '#777',
				'primary_color'     => '#000',
				'secondary_color'   => '#357284',
				'dark_color'        => '#000',
				'light_color'       => '#fff',
				'gray_color'        => '#8f8f8f',
			), $defaults);
		}

		public function change_default_options_g5core_layout_options($defaults) {
			return wp_parse_args(array(
				'content_padding' =>
					array (
						'left' => '',
						'right' => '',
						'top' => 0,
						'bottom' => 100,
					),
			),$defaults);
		}

		public function change_default_options_g5core_header_options($defaults)
		{

			$defaults = wp_parse_args(array(
				'logo_font'                              =>
					array(
						'font_family'    => 'SofiaPro',
						'font_size'      => '30px',
						'font_weight'    => '700',
						'font_style'     => '',
						'align'          => '',
						'transform'      => '',
						'line_height'    => '',
						'letter_spacing' => '0',
					),

				'top_bar_font'                           =>
					array(
						'font_family'    => 'SofiaPro',
						'font_size'      => '15px',
						'font_weight'    => '400',
						'font_style'     => '',
						'transform'      => '',
						'line_height'    => '',
						'letter_spacing' => '',
					),

				'menu_font'                              =>
					array(
						'font_family'    => 'SofiaPro',
						'font_size'      => '16px',
						'font_weight'    => '400',
						'font_style'     => '',
						'transform'      => 'none',
						'line_height'    => '',
						'letter_spacing' => '',
					),

				'sub_menu_font'                          =>
					array(
						'font_family'    => 'SofiaPro',
						'font_size'      => '16px',
						'font_weight'    => '400',
						'font_style'     => '',
						'transform'      => 'none',
						'line_height'    => '',
						'letter_spacing' => '',
					),

				'header_background_color' => '#fff',
				'header_text_color'       => '#000',
				'header_text_hover_color' => '#000',
				'header_border_color'     => '#e4e4e4',
				'header_disable_color'    => '#888',

				'header_sticky_background_color' => '#fff',
				'header_sticky_text_color'       => '#000',
				'header_sticky_text_hover_color' => '#000',
				'header_sticky_border_color'     => '#e4e4e4',
				'header_sticky_disable_color'    => '#888',


				'navigation_background_color' => '#fff',
				'navigation_text_color'       => '#000000',
				'navigation_text_hover_color' => '#000',
				'navigation_border_color'     => '#e4e4e4',
				'navigation_disable_color'    => '#888',

				'submenu_background_color'    => '#fff',
				'submenu_heading_color'       => '#000',
				'submenu_text_color'          => '#777',
				'submenu_item_bg_hover_color' => '#fff',
				'submenu_text_hover_color'    => '#000',
				'submenu_border_color'        => '#fff',



				'header_mobile_background_color' => '#fff',
				'header_mobile_text_color'       => '#000000',
				'header_mobile_text_hover_color' => '#000',
				'header_mobile_border_color'     => '#e4e4e4',

				'header_mobile_sticky_background_color' => '#fff',
				'header_mobile_sticky_text_color'       => '#000000',
				'header_mobile_sticky_text_hover_color' => '#000',
				'header_mobile_sticky_border_color'     => '#e4e4e4',
			), $defaults);


			return $defaults;
		}

		public function change_g5core_header_options_config($options_config)
		{


			$options_config['section_color']['fields']['top_bar_group']['fields']['top_bar_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'top_bar_background_color', '#ece4de' ),
						array( 'top_bar_text_color', '#000' ),
						array( 'top_bar_text_hover_color', '#000' ),
						array( 'top_bar_border_color', '#ececec' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'top_bar_background_color', '#222' ),
						array( 'top_bar_text_color', '#fff' ),
						array( 'top_bar_text_hover_color', '#b20f0f' ),
						array( 'top_bar_border_color', '#353535' ),
					)
				),
			);

			$options_config['section_color']['fields']['header_desktop_color_group']['fields']['header_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_background_color', '#fff' ),
						array( 'header_text_color', '#000' ),
						array( 'header_text_hover_color', '#000' ),
						array( 'header_border_color', '#e4e4e4' ),
						array( 'header_disable_color', '#999' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_background_color', '#222222' ),
						array( 'header_text_color', '#bababa' ),
						array( 'header_text_hover_color', '#fff' ),
						array( 'header_border_color', '#353535' ),
						array( 'header_disable_color', '#8f8f8f' ),
					)
				),
			);

			$options_config['section_color']['fields']['header_desktop_color_group']['fields']['header_sticky_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_sticky_background_color', '#fff' ),
						array( 'header_sticky_text_color', '#000' ),
						array( 'header_sticky_text_hover_color', '#000' ),
						array( 'header_sticky_border_color', '#e4e4e4' ),
						array( 'header_sticky_disable_color', '#999' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_sticky_background_color', '#222222' ),
						array( 'header_sticky_text_color', '#bababa' ),
						array( 'header_sticky_text_hover_color', '#fff' ),
						array( 'header_sticky_border_color', '#353535' ),
						array( 'header_sticky_disable_color', '#8f8f8f' ),
					)
				),
			);

			$options_config['section_color']['fields']['menu_color_group']['fields']['submenu_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array('submenu_background_color', '#fff'),
						array('submenu_heading_color', '#000'),
						array('submenu_text_color', '#777'),
						array('submenu_item_bg_hover_color', '#fff'),
						array('submenu_text_hover_color', '#000'),
						array('submenu_border_color', '#000'),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array('submenu_background_color', '#222222'),
						array('submenu_heading_color', '#fff'),
						array('submenu_text_color', '#bababa'),
						array('submenu_item_bg_hover_color', '#222222'),
						array('submenu_text_hover_color', '#fff'),
						array('submenu_border_color', '#222222'),
					)
				),
			);

			$options_config['section_color']['fields']['navigation_color_group']['fields']['navigation_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array('navigation_background_color', '#fff'),
						array('navigation_text_color', '#000000'),
						array('navigation_text_hover_color', '#000'),
						array('navigation_border_color', '#eee'),
						array('navigation_disable_color', '#999'),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array('navigation_background_color', '#222222'),
						array('navigation_text_color', '#bababa'),
						array('navigation_text_hover_color', '#b20f0f'),
						array('navigation_border_color', '#353535'),
						array('navigation_disable_color', '#8f8f8f'),
					)
				),
			);

			$options_config['section_color']['fields']['header_mobile_group']['fields']['header_mobile_color_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_mobile_background_color', '#fff' ),
						array( 'header_mobile_text_color', '#000' ),
						array( 'header_mobile_text_hover_color', '#000' ),
						array( 'header_mobile_border_color', '#ebebeb' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_mobile_background_color', '#222222' ),
						array( 'header_mobile_text_color', '#bababa' ),
						array( 'header_mobile_text_hover_color', '#fff' ),
						array( 'header_mobile_border_color', '#353535' ),
					)
				),
			);

			$options_config['section_color']['fields']['header_mobile_group']['fields']['header_mobile_sticky_color_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_mobile_sticky_background_color', '#fff' ),
						array( 'header_mobile_sticky_text_color', '#000' ),
						array( 'header_mobile_sticky_text_hover_color', '#000' ),
						array( 'header_mobile_sticky_border_color', '#ebebeb' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_mobile_sticky_background_color', '#222222' ),
						array( 'header_mobile_sticky_text_color', '#bababa' ),
						array( 'header_mobile_sticky_text_hover_color', '#fff' ),
						array( 'header_mobile_sticky_border_color', '#353535' ),
					)
				),
			);

			return $options_config;
		}
	}

	function FURNITOR_SETUP_DATA() {
		return FURNITOR_SETUP_DATA::getInstance();
	}

	FURNITOR_SETUP_DATA()->init();
}





