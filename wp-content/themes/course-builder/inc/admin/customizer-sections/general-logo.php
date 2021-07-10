<?php
/**
 * Field Logo and Sticky Logo
 *
 */
thim_customizer()->add_section(
	array(
		'id'       => 'title_tagline',
		'panel'    => 'general',
		'title'    => esc_html__( 'Logo', 'course-builder' ),
		'priority' => 10,
	)
);

// Header Logo
thim_customizer()->add_field(
	array(
		'id'       => 'header_logo',
		'type'     => 'image',
		'section'  => 'title_tagline',
		'label'    => esc_html__( 'Site Logo', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to add, remove and change site logo.', 'course-builder' ),
		'priority' => 10,
		'default'  => THIM_URI . "assets/images/logo.png",
	)
);

// Header Sticky Logo
thim_customizer()->add_field(
	array(
		'id'          => 'header_sticky_logo',
		'type'        => 'image',
		'section'     => 'title_tagline',
		'label'       => esc_html__( 'Sticky Logo', 'course-builder' ),
		'tooltip'     => esc_html__( 'Allows to add, remove and change Sticky Logo', 'course-builder' ),
		'description' => esc_html__( 'Use default logo if no image selected', 'course-builder' ),
		'priority'    => 20,
		'default'     => THIM_URI . "assets/images/logo.png",
	)
);

// Header Retina Logo
thim_customizer()->add_field(
	array(
		'id'          => 'header_retina_logo',
		'type'        => 'image',
		'section'     => 'title_tagline',
		'label'       => esc_html__( 'Retina Logo', 'course-builder' ),
		'tooltip'     => esc_html__( 'Allows to add, remove and change Retina Logo.', 'course-builder' ),
		'description' => esc_html__( 'Retina Logo is the same as the normal logo, though twice the size for sharper display on Retina Display devices. Use default logo if no image selected', 'course-builder' ),
		'priority'    => 30,
		'default'     => THIM_URI . "assets/images/retina-logo.png",
	)
);

// Header Retina Sticky Logo
thim_customizer()->add_field(
    array(
        'id'          => 'header_sticky_logo_retina',
        'type'        => 'image',
        'section'     => 'title_tagline',
        'label'       => esc_html__( 'Sticky Logo Retina', 'course-builder' ),
        'tooltip'     => esc_html__( 'Allows to add, remove and change Sticky Logo Retina', 'course-builder' ),
        'description' => esc_html__( 'Use default logo if no image selected', 'course-builder' ),
        'priority'    => 31,
        'default'     => THIM_URI . "assets/images/retina-logo.png",
        'active_callback' => array(
            array(
                'setting'  => 'header_retina_logo',
                'operator' => '!==',
                'value'    => '',
            ),
        ),
    )
);

// Lesson Logo
thim_customizer()->add_field(
	array(
		'id'          => 'header_lesson_logo',
		'type'        => 'image',
		'section'     => 'title_tagline',
		'label'       => esc_html__( 'Lesson Logo', 'course-builder' ),
		'tooltip'     => esc_html__( 'Allows to add, remove and change Lesson Logo.', 'course-builder' ),
		'description' => esc_html__( 'Lesson Logo is the logo that appears on the top bar when viewing a lesson. Use default logo if no image selected', 'course-builder' ),
		'priority'    => 35,
		'default'     => THIM_URI . "assets/images/logo-2.png",
	)
);

// Header Mobile Logo
thim_customizer()->add_field(
	array(
		'id'          => 'header_mobile_logo',
		'type'        => 'image',
		'section'     => 'title_tagline',
		'label'       => esc_html__( 'Mobile Logo', 'course-builder' ),
		'tooltip'     => esc_html__( 'Allows to add, remove and change Mobile Logo.', 'course-builder' ),
		'description' => 'Use default logo if no image selected.',
		'priority'    => 37,
		'default'     => THIM_URI . "assets/images/mobile-logo.png",
	)
);

// Logo width
thim_customizer()->add_field(
	array(
		'id'        => 'width_logo',
		'type'      => 'dimension',
		'label'     => esc_html__( 'Logo width', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to adjust logo width in supported units: px, em, cm, in, %, and more.', 'course-builder' ),
		'section'   => 'title_tagline',
		'default'   => '300px',
		'priority'  => 40,
		'choices'   => array(
			'min'  => 100,
			'max'  => 500,
			'step' => 10,
		),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'width',
				'element'  => 'header#masthead .width-logo',
				'property' => 'width',
			)
		)
	)
);