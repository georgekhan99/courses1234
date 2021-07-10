<?php
/**
 * Panel 404
 */

thim_customizer()->add_section(
    array(
        'id'       => '404_page_general',
        'panel'    => 'general',
        'priority' => 150,
        'title'    => esc_html__( '404 Page', 'course-builder' ),
    )
);


thim_customizer()->add_field(
    array(
        'type'      => 'image',
        'id'        => 'single_404_image',
        'label'     => esc_html__( '404 Image', 'course-builder' ),
        'priority'  => 30,
        'transport' => 'postMessage',
        'section'  => '404_page_general',
        'default'     => THIM_URI . "/assets/images/404.png",
    )
);