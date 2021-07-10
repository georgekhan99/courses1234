<?php
/**
 * Section Responsive
 *
 * @package Course_Builder
 */

thim_customizer()->add_panel(
	array(
		'id'       => 'responsive',
		'title'    => esc_html__( 'Responsive', 'course-builder' ),
		'priority' => 70,
		'icon'     => 'dashicons-smartphone',
	)
);