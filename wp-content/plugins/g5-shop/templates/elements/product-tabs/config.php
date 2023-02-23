<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5SHOP()->load_file(G5SHOP()->plugin_dir('inc/abstract/elementor-listing.class.php'));
}

class UBE_Element_G5Shop_Product_Tabs extends G5Shop_Abstracts_Elements_Listing {

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 * @since 1.4.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'ube-g5-product-tabs';
	}

	public function get_title() {
		return esc_html__( 'G5 Product Tabs', 'g5-shop' );
	}

	public function get_ube_icon() {
		return 'eicon-product-tabs';
	}

	public function get_ube_keywords() {
		return array('products','product tabs', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5', 'tabs' );
	}

	public function get_script_depends() {
		return array(G5SHOP()->assets_handle('product-tabs'));
	}

	public function get_style_depends() {
		return array();
	}

	public function render() {
		G5SHOP()->get_template( 'elements/product-tabs/template.php', array(
			'element' => $this
		) );
	}

	public function _register_controls() {
		$this->register_tabs_section_controls();
		$this->register_tabs_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_style_section_controls();
	}
}