<?php
/**
 * Matthew Schroeter Theme Customizer
 *
 * @package Matthew_Schroeter
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function matthew_schroeter_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'matthew_schroeter_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'matthew_schroeter_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'matthew_schroeter_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function matthew_schroeter_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function matthew_schroeter_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function matthew_schroeter_customize_preview_js() {
	wp_enqueue_script( 'matthew-schroeter-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'matthew_schroeter_customize_preview_js' );

/**
 * ADD CUSTOMIZER SETTINGS
 *
 * @since 1.0.0
 * @param $wp_customize
 */
function matthew_schroeter_customizer_settings( $wp_customize ) {

	/************ GitLab API ************/

	$wp_customize->add_section('ms_gitlab_api',
		array(
			'priority' 			=> 160,
			'title' 			=> __('GitLab API', 'matthew-schroeter'),
			'capability' 		=> 'edit_theme_options',
			'theme_supports' 	=> '',

		)
	);

	/************ Private Token ************/

	$wp_customize->add_setting('ms_gitlab_token',
		array(
			'default' 		=> '',
			'type' 			=> 'theme_mod',
			'capability' 	=> 'edit_theme_options',
		)
	);

	$wp_customize->add_control('ms_gitlab_token',
		array(
			'type' 		=> 'input',
			'label' 	=> __('GitLab API Private Token', 'matthew-schroeter'),
			'priority' 	=> 10,
			'section' 	=> 'ms_gitlab_api',
			'settings' 	=> 'ms_gitlab_token',
		)
	);

}
add_action( 'customize_register', 'matthew_schroeter_customizer_settings' );