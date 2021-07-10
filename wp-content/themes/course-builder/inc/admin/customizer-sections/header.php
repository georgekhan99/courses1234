<?php
/**
 * Panel Header
 * 
 * @package Course_Builder
 */

thim_customizer()->add_panel(
	array(
		'id'       => 'header',
		'priority' => 20,
		'title'    => esc_html__( 'Header', 'course-builder' ),
		'icon'     => 'dashicons-align-left',
	)
);