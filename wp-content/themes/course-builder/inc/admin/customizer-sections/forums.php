<?php
/**
 * Panel Forums
 * 
 * @package Course_Builder
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'forums',
        'priority' => 46,
        'title'    => esc_html__( 'Forums', 'course-builder' ),
        'icon'     => 'dashicons-groups',
    )
);