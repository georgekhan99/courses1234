<?php
/**
 * Section Sidebar
 * 
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'sidebar',
		'panel'    => 'general',
		'title'    => esc_html__( 'Sidebar', 'course-builder' ),
		'priority' => 80,
	)
);

thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'sticky_sidebar',
		'label'    => esc_html__( 'Sticky Sidebar', 'course-builder' ),
		'section'  => 'sidebar',
		'default'  => true,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);