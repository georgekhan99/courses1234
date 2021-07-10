<?php
/**
 * Section Custom CSS
 * 
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'custom_css',
		'panel'    => 'general',
		'title'    => esc_html__( 'Custom CSS', 'course-builder' ),
		'description' => esc_html__( 'Just want to do some quick CSS changes? Enter theme here, they will be applied to the theme.', 'course-builder' ),
		'priority' => 99,
	)
);