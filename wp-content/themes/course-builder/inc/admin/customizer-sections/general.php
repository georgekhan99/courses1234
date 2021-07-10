<?php
/**
 * Panel General
 * 
 * @package Course_Builder
 */

thim_customizer()->add_panel(
	array(
		'id'       => 'general',
		'priority' => 10,
		'title'    => esc_html__( 'General', 'course-builder' ),
		'icon'     => 'dashicons-admin-generic',
	)
);