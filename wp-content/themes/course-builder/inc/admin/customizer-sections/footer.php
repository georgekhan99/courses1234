<?php
/**
 * Panel Footer
 * 
 * @package Course_Builder
 */

thim_customizer()->add_panel(
	array(
		'id'       => 'footer',
		'priority' => 100,
		'title'    => esc_html__( 'Footer', 'course-builder' ),
		'icon'     => 'dashicons-align-right',
	)
);
