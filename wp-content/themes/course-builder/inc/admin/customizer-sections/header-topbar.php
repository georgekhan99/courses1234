<?php
/**
 * Section Header Top bar
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_topbar',
		'title'    => esc_html__( 'Top bar', 'course-builder' ),
		'panel'    => 'header',
		'priority' => 20,
	)
);

// Enable or disable top bar
thim_customizer()->add_field(
	array(
		'id'       => 'header_topbar_display',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Topbar', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to enable or disable Top bar.', 'course-builder' ),
		'section'  => 'header_topbar',
		'default'  => 0,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Topbar background color
thim_customizer()->add_field(
	array(
		'id'        => 'topbar_background_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows you to choose a background color for widget on topbar. ', 'course-builder' ),
		'section'   => 'header_topbar',
		'default'   => '#18C1F0',
		'priority'  => 20,
		'alpha'     => true,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'background-color',
				'element'  => 'body header#masthead #thim-header-topbar',
				'property' => 'background-color',
			)
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'topbar_text_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Text Color', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows you to choose a color for text on topbar. ', 'course-builder' ),
		'section'   => 'header_topbar',
		'default'   => '#fff',
		'priority'  => 30,
		'alpha'     => true,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'text-color',
				'element'  => 'body header#masthead #thim-header-topbar',
				'property' => 'text-color',
			)
		)
	)
);

// Show line after topbar
thim_customizer()->add_field(
	array(
		'id'       => 'show_line_after_topbar',
		'type'     => 'switch',
		'label' => esc_html__('Show Line After Topbar', 'course-builder'),
		'tooltip' => esc_html__('Allows you to show or hide line between topbar and main menu.', 'course-builder'),
		'section'  => 'header_topbar',
		'default'  => 0,
		'priority' => 40,
		'choices'  => array(
			true => esc_html__('On', 'course-builder'),
			false => esc_html__('Off', 'course-builder'),
		),
	)
);
