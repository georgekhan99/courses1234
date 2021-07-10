<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses thim_startertheme_header_style()
 */
function thim_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'thim_custom_header_args', array(
		'default-image'      => '',
		'default-text-color' => '000000',
		'width'              => 1000,
		'height'             => 250,
		'flex-height'        => true,
	) ) );
}

add_action( 'after_setup_theme', 'thim_custom_header_setup' );

