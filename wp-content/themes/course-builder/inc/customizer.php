<?php
/**
 * Thim - Starter Theme Theme Customizer.
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function thim_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}

add_action( 'customize_register', 'thim_customize_register' );

if ( thim_plugin_active( 'thim-core' ) ) {
	require_once THIM_DIR . 'inc/admin/customizer-options.php';
}

/**
 * Compile Sass from theme customize.
 */
add_filter( 'thim_core_config_sass', 'thim_theme_options_sass' );
function thim_theme_options_sass() {
	$dir = THIM_DIR . 'assets/sass/';

	return array(
		'dir'  => $dir,
		'name' => '_style-options.scss',
	);
}
