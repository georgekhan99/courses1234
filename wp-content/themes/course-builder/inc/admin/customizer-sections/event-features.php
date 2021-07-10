<?php
/*
 * Section Event / Features
 * */

thim_customizer()->add_section(
	array(
		'id'       => 'event_features',
		'panel'    => 'events',
		'title'    => esc_html__( 'Features', 'course-builder' ),
		'priority' => 25,
	)
);

thim_customizer()->add_field(
    array(
        'type'     => 'switch',
        'id'       => 'event_login_popup',
        'label'    => esc_html__( 'Enable Login Popup', 'course-builder' ),
        'section'  => 'event_features',
        'tooltip'     => esc_html__( 'Enable login popup in event single', 'course-builder' ),
        'default'  => true,
        'priority' => 5,
        'choices'  => array(
            true  => esc_html__( 'On', 'course-builder' ),
            false => esc_html__( 'Off', 'course-builder' ),
        ),
    )
);
