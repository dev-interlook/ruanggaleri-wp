<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('elementor/document/after_save', 'ube_elementor_document_after_save', 10, 2);
function ube_elementor_document_after_save($obj, $data) {
	if (is_a($obj, 'Elementor\Core\Kits\Documents\Kit')) {
		$map_colors = array(
			'primary' => 'primary_color',
			'secondary' => 'secondary_color',
			'text' => 'site_text_color',
			'accent' => 'accent_color',
			'border' => 'border_color',
			'dark' => 'dark_color',
			'light' => 'light_color',
			'gray' => 'gray_color',
			'muted' => 'caption_color',
			'placeholder' => 'placeholder_color',
		);

		$system_colors = isset($data['settings']['system_colors']) ? $data['settings']['system_colors'] : array();

		$color_options = get_option(G5CORE()->options()->color()->get_option_name(), array());

		foreach ($map_colors as $k => $v) {
			$current_color = array();
			foreach ($system_colors as $cl) {
				if ($cl['_id'] === $k) {
					$current_color = $cl;
					break;
				}
			}
			if (isset($current_color['color'])) {
				$color_options[$v] = $current_color['color'];
			}
		}

		update_option(G5CORE()->options()->color()->get_option_name(), $color_options);
	}
}

add_action('gsf_after_change_options/g5core_color_options', 'ube_elementor_after_change_options_color', 10, 2);
function ube_elementor_after_change_options_color($options, $preset) {
	if ($preset === '') {
		$map_colors = array(
			'primary' => 'primary_color',
			'secondary' => 'secondary_color',
			'text' => 'site_text_color',
			'accent' => 'accent_color',
			'border' => 'border_color',
			'dark' => 'dark_color',
			'light' => 'light_color',
			'gray' => 'gray_color',
			'muted' => 'caption_color',
			'placeholder' => 'placeholder_color',
		);

		if (class_exists('Elementor\Plugin')) {
			$kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();

			$kit = Elementor\Plugin::$instance->documents->get( $kit_id );
			$meta_key = Elementor\Core\Settings\Page\Manager::META_KEY;
			$kit_raw_settings = $kit->get_meta( $meta_key );

			if (!isset($kit_raw_settings['system_colors'])) {
				return;
			}

			foreach ($map_colors as $k => $v) {
				if (isset($options[$v])) {
					foreach ($kit_raw_settings['system_colors'] as &$cl) {
						if ($cl['_id'] === $k) {
							$cl['color'] = $options[$v];
						}
					}
				}
			}

			$kit->update_meta($meta_key, $kit_raw_settings);

			$post_css = Elementor\Core\Files\CSS\Post::create( $kit_id );
			$post_css->delete();
		}
	}
}