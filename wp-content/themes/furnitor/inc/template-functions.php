<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Header template
 */
function furnitor_template_header() {
	furnitor_get_template('header');
}
add_action('furnitor_before_page_wrapper_content', 'furnitor_template_header', 10);

/**
 * Footer template
 */
function furnitor_template_footer() {
	furnitor_get_template('footer');
}
add_action('furnitor_after_page_wrapper_content', 'furnitor_template_footer', 10);

/**
 * Content Wrapper Start
 */
function furnitor_template_wrapper_start() {
	furnitor_get_template('global/wrapper-start');
}
add_action('furnitor_main_wrapper_content_start', 'furnitor_template_wrapper_start', 10);

/**
 * Content Wrapper End
 */
function furnitor_template_wrapper_end() {
	furnitor_get_template('global/wrapper-end');
}
add_action('furnitor_main_wrapper_content_end', 'furnitor_template_wrapper_end', 10);

/**
 * Archive content layout
 */
function furnitor_template_archive_content() {
	furnitor_get_template('archive/layout');
}
add_action('furnitor_archive_content', 'furnitor_template_archive_content', 10);

/**
 * Single content layout
 */
function furnitor_template_single_content() {
	furnitor_get_template('single/layout');
}
add_action('furnitor_single_content', 'furnitor_template_single_content', 10);

/**
 * Single content layout
 */
function furnitor_template_page_content() {
	furnitor_get_template('page/layout');
}
add_action('furnitor_page_content', 'furnitor_template_page_content', 10);

/**
 * Search content layout
 */
function furnitor_template_search_content() {
	furnitor_get_template('search/layout');
}
add_action('furnitor_search_content', 'furnitor_template_search_content', 10);

/**
 * 404 content layout
 */
function furnitor_template_404_content() {
	furnitor_get_template('404/layout');
}
add_action('furnitor_404_content', 'furnitor_template_404_content', 10);

function furnitor_template_page_title() {
	furnitor_get_template( 'page-title' );
}
add_action('furnitor_before_main_content', 'furnitor_template_page_title', 10);
