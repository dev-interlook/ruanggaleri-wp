<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function gid_replace_elementor_data($find, $replace, &$data) {
	$data = json_decode($data, true);
	gid_recursive_replace_data($find, $replace, $data);
	return json_encode($data);
}

function gid_replace_elementor_data_post_id(&$map_ids, &$data) {
	if (is_array($data)) {
		// Replace Image
		if ((count($data) === 2) && isset($data['url']) && isset($data['id'])) {
			$data['id'] = isset($map_ids[$data['id']]) ? $map_ids[$data['id']] : $data['id'];
		}

		// Replace Widget ID
		if ((count($data) === 2) && isset($data['etype']) && isset($data['ube_dynamic_content_id'])) {
			$data['ube_dynamic_content_id'] = isset($map_ids[$data['ube_dynamic_content_id']]) ? $map_ids[$data['ube_dynamic_content_id']] : $data['ube_dynamic_content_id'];
		}

		if (isset($data['elements'])) {
			// Replace Data
			foreach ($data['elements'] as &$el_child) {
				gid_replace_elementor_data_post_id($map_ids, $el_child);
			}
		}
	}
}

add_action('gid_installing_prepare_data_success', 'gid_process_elementor_data');
function gid_process_elementor_data($demo) {
	$current_demo = gid_get_current_demo( $demo );
	if (!isset($current_demo['builder']) || ($current_demo['builder'] !== 'elementor') ) {
		return;
	}

	global $wpdb, $terms_id_log, $posts_id_log;

	$rows = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type <> 'attachment'" );
	foreach ($rows as $row) {
		$data = get_post_meta($row->ID, '_elementor_data', true);

		if ($data !== false) {
			$data = json_decode($data, true);

			if (is_array($data)) {
				gid_replace_elementor_data_post_id($posts_id_log, $data);

				update_post_meta($row->ID, '_elementor_data', wp_slash(json_encode($data)));
			}
			else {
				update_post_meta($row->ID, '_elementor_data', json_encode(array()));
			}
		}
	}

	// Update options
	$elementor_active_kit = get_option('elementor_active_kit', false);
	if ($elementor_active_kit !== false) {
		$elementor_active_kit = isset($posts_id_log[$elementor_active_kit]) ? $posts_id_log[$elementor_active_kit] : $elementor_active_kit;
		update_option('elementor_active_kit', $elementor_active_kit);
	}
}