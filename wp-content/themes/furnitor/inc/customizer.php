<?php
/**
 * Customizer For Theme
 *
 * @since 1.0
 * @version 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function furnitor_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'furnitor_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'furnitor_customize_partial_blogdescription',
	) );


	$wp_customize->add_section( 'furnitor_footer_section', array(
		'title'    => esc_html__( 'Footer', 'furnitor' ),
		'priority' => 120,
	) );
	$wp_customize->add_setting( 'footer_text', array(
		'default'   => esc_html__( 'Powered by Furnitor', 'furnitor' ),
		'transport' => 'refresh',
		'sanitize_callback'  => 'wp_kses_post'
	) );
	$wp_customize->add_control( 'footer_text',
		array(
			'label'    => esc_html__( 'Footer Text', 'furnitor' ),
			'type'     => 'textarea',
			'section'  => 'furnitor_footer_section',
			'settings' => 'footer_text',
		) );
	$wp_customize->add_setting( 'enable_private_policy_link', array(
		'default'   => 'on',
		'transport' => 'refresh',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( 'enable_private_policy_link',
		array(
			'label'    => esc_html__( 'Private Policy Link', 'furnitor' ),
			'type'     => 'radio',
			'section'  => 'furnitor_footer_section',
			'settings' => 'enable_private_policy_link',
			'choices'  => array(
				'on'   => esc_html__('Show private policy link','furnitor'),
				'off'   => esc_html__('Hide private policy link','furnitor'),
			)
		) );

}

add_action( 'customize_register', 'furnitor_customize_register' );

function furnitor_customize_partial_blogname() {
	bloginfo( 'name' );
}

function furnitor_customize_partial_blogdescription() {
	bloginfo( 'description' );
}