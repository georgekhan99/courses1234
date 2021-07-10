<?php
/**
 * Section Header Sub Menu
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_sub_menu',
		'title'    => esc_html__( 'Sub Menu', 'course-builder' ),
		'panel'    => 'header',
		'priority' => 50,
	)
);

// Background Header
thim_customizer()->add_field(
	array(
		'id'              => 'sub_menu_background_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set background color for sub menu.', 'course-builder' ),
		'section'         => 'header_sub_menu',
		'default'         => '#ffffff',
		'priority'        => 16,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'header#masthead.site-header #primary-menu .sub-menu',
				'property' => 'background-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_palette',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

// Text Color
thim_customizer()->add_field(
	array(
		'id'              => 'sub_menu_text_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Text Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set text color for sub menu.', 'course-builder' ),
		'section'         => 'header_sub_menu',
		'default'         => '#333333',
		'priority'        => 17,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'header#masthead.site-header .navigation #primary-menu .sub-menu a,
                               header#masthead.site-header .navigation #primary-menu .sub-menu span',
				'property' => 'color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_palette',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

// Text Hover Color
thim_customizer()->add_field(
	array(
		'id'              => 'sub_menu_text_color_hover',
		'type'            => 'color',
		'label'           => esc_html__( 'Text Hover Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set text hover color for sub menu.', 'course-builder' ),
		'section'         => 'header_sub_menu',
		'default'         => '#3498DB',
		'priority'        => 18,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'header#masthead.site-header .navigation #primary-menu .sub-menu a:hover,
                               header#masthead.site-header .navigation #primary-menu .sub-menu span:hover',
				'property' => 'color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_palette',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);


