<?php
/**
 * Section Header Sticky Menu
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_sticky_menu',
		'title'    => esc_html__( 'Sticky Menu', 'course-builder' ),
		'panel'    => 'header',
		'priority' => 55,
	)
);

// Enable or Disable
thim_customizer()->add_field(
	array(
		'id'       => 'show_sticky_menu',
		'type'     => 'switch',
		'label'    => esc_html__( 'Enable Sticky Menu', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to Enable Sticky Menu when scrolling the page.', 'course-builder' ),
		'section'  => 'header_sticky_menu',
		'default'  => 1,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Select Style
thim_customizer()->add_field(
	array(
		'id'              => 'sticky_menu_style',
		'type'            => 'select',
		'label'           => esc_html__( 'Select style', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to select style for Sticky Menu.', 'course-builder' ),
		'section'         => 'header_sticky_menu',
		'default'         => 'same',
		'priority'        => 10,
		'multiple'        => 0,
		'choices'         => array(
			'same'   => esc_html__( 'The same with main menu', 'course-builder' ),
			'custom' => esc_html__( 'Custom', 'course-builder' )
		),
//		'active_callback' => array(
//			array(
//				'setting'  => 'header_palette',
//				'operator' => '==',
//				'value'    => 'custom',
//			),
//		),
	)
);

// Background Header
thim_customizer()->add_field(
	array(
		'id'              => 'sticky_menu_background_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set background color for Sticky Menu.', 'course-builder' ),
		'section'         => 'header_sticky_menu',
		'default'         => '#ffffff',
		'priority'        => 16,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'body header#masthead.site-header.custom-sticky.affix',
				'property' => 'background-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'sticky_menu_style',
				'operator' => '===',
				'value'    => 'custom',
			),
//			array(
//				'setting'  => 'header_palette',
//				'operator' => '==',
//				'value'    => 'custom',
//			),
		),
	)
);

// Text Color
thim_customizer()->add_field(
	array(
		'id'              => 'sticky_menu_text_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Text Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set text color for Sticky Menu.', 'course-builder' ),
		'section'         => 'header_sticky_menu',
		'default'         => '#333333',
		'priority'        => 18,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'body header#masthead.site-header.affix.custom-sticky #primary-menu >li >a,
                               header#masthead.site-header.affix.custom-sticky #primary-menu >li >span',
				'property' => 'color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'sticky_menu_style',
				'operator' => '===',
				'value'    => 'custom',
			),
//			array(
//				'setting'  => 'header_palette',
//				'operator' => '==',
//				'value'    => 'custom',
//			),
		),
	)
);

// Text Hover Color
thim_customizer()->add_field(
	array(
		'id'              => 'sticky_menu_text_color_hover',
		'type'            => 'color',
		'label'           => esc_html__( 'Text Hover Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set text hover color for Sticky Menu.', 'course-builder' ),
		'section'         => 'header_sticky_menu',
		'default'         => '#3498DB',
		'priority'        => 19,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'body header#masthead.site-header.affix.custom-sticky #primary-menu >li >a:hover,
                               body header#masthead.site-header.affix.custom-sticky #primary-menu >li >span:hover',
				'property' => 'color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'sticky_menu_style',
				'operator' => '===',
				'value'    => 'custom',
			),
//			array(
//				'setting'  => 'header_palette',
//				'operator' => '==',
//				'value'    => 'custom',
//			),
		),
	)
);