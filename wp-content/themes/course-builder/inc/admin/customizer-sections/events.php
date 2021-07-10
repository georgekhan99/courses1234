<?php
/**
 * Panel Blog
 * 
 * @package Course_Builder
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'events',
        'priority' => 44,
        'title'    => esc_html__( 'Events', 'course-builder' ),
        'icon'     => 'dashicons-calendar',
    )
);