<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( function_exists( 'G5CORE' ) ) {
	add_action( 'template_redirect', 'furnitor_custom_css', 20 );
}

function furnitor_custom_css() {
	$body_font = g5core_process_font( G5CORE()->options()->typography()->get_option( 'body_font' ) );
	$primary_font = g5core_process_font( G5CORE()->options()->typography()->get_option( 'primary_font' ) );


	$accent_color            = G5CORE()->options()->color()->get_option( 'accent_color' );
	$accent_foreground_color = g5core_color_contrast( $accent_color );
	$accent_adjust_brightness = g5core_color_adjust_brightness( $accent_color ,'7.5%');

	$primary_color            = G5CORE()->options()->color()->get_option( 'primary_color' );
	$primary_foreground_color = g5core_color_contrast( $primary_color );
	$primary_adjust_brightness = g5core_color_adjust_brightness( $primary_color ,'7.5%');

	$secondary_color            = G5CORE()->options()->color()->get_option( 'secondary_color' );
	$secondary_foreground_color = g5core_color_contrast( $secondary_color );
	$secondary_adjust_brightness = g5core_color_adjust_brightness( $secondary_color ,'7.5%');

	$light_color            = G5CORE()->options()->color()->get_option( 'light_color' );
	$light_foreground_color = g5core_color_contrast( $light_color );
	$light_adjust_brightness = g5core_color_adjust_brightness( $light_color ,'7.5%');

	$dark_color            = G5CORE()->options()->color()->get_option( 'dark_color' );
	$dark_foreground_color = g5core_color_contrast( $dark_color );
	$dark_adjust_brightness = g5core_color_adjust_brightness( $dark_color ,'7.5%');

	$gray_color            = G5CORE()->options()->color()->get_option( 'gray_color' );
	$gray_foreground_color = g5core_color_contrast( $gray_color );
	$gray_adjust_brightness = g5core_color_adjust_brightness( $gray_color ,'7.5%');

	$text_color = G5CORE()->options()->color()->get_option( 'site_text_color' );

	$heading_color = G5CORE()->options()->color()->get_option( 'heading_color' );
	$caption_color = G5CORE()->options()->color()->get_option( 'caption_color' );
	$border_color = G5CORE()->options()->color()->get_option( 'border_color' );

	$link_color = G5CORE()->options()->color()->get_option( 'link_color' );
	$link_color_hover = g5core_color_adjust_brightness( $link_color ,'10%');

	$custom_css = <<<CSS
:root {
	--g5-font-body: {$body_font['font_family']};
	--g5-font-primary: {$primary_font['font_family']};

	--g5-color-accent: {$accent_color};
	--g5-color-accent-foreground :  {$accent_foreground_color};
	--g5-color-accent-brightness : {$accent_adjust_brightness};
	--g5-color-primary :  {$primary_color};
	--g5-color-primary-foreground :  {$primary_foreground_color};
	--g5-color-primary-brightness : {$primary_adjust_brightness};
	--g5-color-secondary:  {$secondary_color};
	--g5-color-secondary-foreground :  {$secondary_foreground_color};
	--g5-color-secondary-brightness : {$secondary_adjust_brightness};
	--g5-color-light: {$light_color};
	--g5-color-light-foreground: {$light_foreground_color};
	--g5-color-light-brightness : {$light_adjust_brightness};
	--g5-color-dark: {$dark_color};
	--g5-color-dark-foreground: {$dark_foreground_color};
	--g5-color-dark-brightness : {$dark_adjust_brightness};

	--g5-color-gray: {$gray_color};
	--g5-color-gray-foreground: {$gray_foreground_color};
	--g5-color-gray-brightness : {$gray_adjust_brightness};
	--g5-color-text-main: {$text_color};
	--g5-color-heading: {$heading_color};
	--g5-color-border: {$border_color};
	--g5-color-muted: {$caption_color};


	--g5-color-link: {$link_color};
	--g5-color-link-hover: {$link_color_hover};
}

CSS;


	G5CORE()->custom_css()->addCss( $custom_css );
}