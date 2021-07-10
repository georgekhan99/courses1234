<?php
/**
 * Section Custom CSS
 * 
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'custom_js',
		'panel'    => 'general',
		'title'    => esc_html__( 'Custom JS', 'course-builder' ),
		'priority' => 100,
	)
);

thim_customizer()->add_field( array(
	'type'        => 'code',
	'id'          => 'thim_custom_js',
	'description' => esc_html__( 'Just want to do some quick JS changes? Enter theme here, they will be applied to the theme.', 'course-builder' ),
	'section'     => 'custom_js',
	'default'     => '',
	'priority'    => 10,
	'choices'     => array(
		'language' => 'javascript',
		'theme'    => 'monokai',
		'height'   => 250,
	),
	'transport'   => 'postMessage',
	'js_vars'     => array()
) );