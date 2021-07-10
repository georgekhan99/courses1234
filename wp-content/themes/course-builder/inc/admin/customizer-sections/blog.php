<?php
/**
 * Panel Blog
 * 
 * @package Course_Builder
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'blog',
        'priority' => 42,
        'title'    => esc_html__( 'Blog', 'course-builder' ),
        'icon'     => 'dashicons-welcome-write-blog',
    )
);