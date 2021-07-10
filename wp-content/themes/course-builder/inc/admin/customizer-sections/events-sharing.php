<?php
/**
 * Section Sharing
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
    array(
        'id'       => 'event_sharing',
        'panel'    => 'events',
        'title'    => esc_html__( 'Social Share', 'course-builder' ),
        'priority' => 21,
    )
);

// Sharing Group
thim_customizer()->add_field(
    array(
        'id'       => 'event_group_sharing',
        'type'     => 'sortable',
        'label'    => esc_html__( 'Sortable Buttons Sharing', 'course-builder' ),
        'tooltip'  => esc_html__( 'Click on eye icon to show or hide social icon. Drag and drop to change the order of social icons.', 'course-builder' ),
        'section'  => 'event_sharing',
        'priority' => 10,
        'default'  => array(
            'facebook',
            'twitter',
            'linkedin',
            'google',
            'pinterest',
            'whatsapp'
        ),
        'choices'  => array(
            'facebook'  => esc_html__( 'Facebook', 'course-builder' ),
            'twitter'   => esc_html__( 'Twitter', 'course-builder' ),
            'linkedin' => esc_html__( 'Linkedin', 'course-builder' ),
            'google'    => esc_html__( 'Google Plus', 'course-builder' ),
            'pinterest'     => esc_html__( 'Pinterest', 'course-builder' ),
            'whatsapp'    => esc_html__( 'Whatsapp', 'course-builder' ),
        ),
    )
);

