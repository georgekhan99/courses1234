<?php
/**
 * Panel Portfolio
 **/

thim_customizer()->add_panel(
    array(
        'id'       => 'portfolio',
        'priority' => 62,
        'title'    => esc_html__( 'Portfolio', 'course-builder' ),
        'icon'     => 'dashicons-portfolio',
    )
);