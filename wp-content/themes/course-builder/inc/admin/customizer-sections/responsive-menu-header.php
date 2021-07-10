<?php
/**
 * Section Responsive
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'responsive_setting',
		'title'    => esc_html__( 'Settings', 'course-builder' ),
		'panel'    => 'responsive',
		'priority' => 10,
	)
);

// Enable or Disable
thim_customizer()->add_field(
	array(
		'id'       => 'enable_responsive',
		'type'     => 'switch',
		'label'    => esc_html__( 'Responsive', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to enable responsive on mobile device.', 'course-builder' ),
		'section'  => 'responsive_setting',
		'default'  => 1,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

thim_customizer()->add_field(
    array(
        'id'              => 'mobile_menu_position',
        'type'            => 'select',
        'label'           => esc_html__( 'Position', 'course-builder' ),
        'tooltip'         => esc_html__( 'Allows you to select a mobile menu effect position for header on mobile.', 'course-builder' ),
        'section'         => 'responsive_setting',
        'priority'        => 12,
        'multiple'        => 0,
        'default'         => 'creative-left',
        'choices'         => array(
            'creative-left'  => esc_html__( 'Left', 'course-builder' ),
            'creative-right' => esc_html__( 'Right', 'course-builder' ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'enable_responsive',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    )
);

thim_customizer()->add_field(
	array(
		'id'              => 'mobile_menu_hamburger_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Hamburger icon color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to select color for hamburger menu on mobile device.', 'course-builder' ),
		'section'         => 'responsive_setting',
		'default'         => '#202121',
		'priority'        => 16,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => '.menu-mobile-effect span.icon-bar',
				'property' => 'background-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'enable_responsive',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'mobile_menu_header_background_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to select header background color on mobile device.', 'course-builder' ),
		'section'         => 'responsive_setting',
		'default'         => '#FFF',
		'priority'        => 17,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'enable_responsive',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'mobile_menu_header_sticky_background_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Sticky Background Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to select header sticky background color on mobile device.', 'course-builder' ),
		'section'         => 'responsive_setting',
		'default'         => '#FFF',
		'priority'        => 20,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'enable_responsive',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);