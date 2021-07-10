<?php
/**
 * Section Breadcrumb
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'breadcrumb',
		'panel'    => 'page_title_bar',
		'title'    => esc_html__( 'Breadcrumb', 'course-builder' ),
		'priority' => 20,
	)
);

// Enable or Disable Breadcrumb
thim_customizer()->add_field(
	array(
		'id'       => 'show_breadcrumb',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show/Hide Breadcrumb', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to show or hide breadcrumb on page title bar. ', 'course-builder' ),
		'section'  => 'breadcrumb',
		'default'  => 1,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);


// Background
thim_customizer()->add_field(
	array(
		'id'              => 'breadcrumb_background_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set background color for breadcrumb on page title bar.', 'course-builder' ),
		'section'         => 'breadcrumb',
		'default'         => '#ffffff',
		'priority'        => 11,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => '.main-top',
				'property' => 'background-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'show_breadcrumb',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);


// Text Color
thim_customizer()->add_field(
	array(
		'id'              => 'breadcrumb_text_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Text Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set text color for breadcrumb on page title bar.', 'course-builder' ),
		'section'         => 'breadcrumb',
		'default'         => '#a9a9a9',
		'priority'        => 12,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => '.main-top',
				'property' => 'background-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'show_breadcrumb',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);