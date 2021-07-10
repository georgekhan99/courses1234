<?php
/**
 * Panel LearnPress
 *
 * @package Course_Builder
 */

thim_customizer()->add_panel(
	array(
		'id'       => 'learnpress',
		'priority' => 43,
		'title'    => esc_html__( 'Courses', 'course-builder' ),
		'icon'     => 'dashicons-welcome-learn-more',
	)
);
