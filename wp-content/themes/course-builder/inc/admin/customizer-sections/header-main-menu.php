<?php
/**
 * Section Header Main Menu
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_main_menu',
		'title'    => esc_html__( 'Layouts & Main Menu', 'course-builder' ),
		'panel'    => 'header',
		'priority' => 30,
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'header_template',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Header Layout', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows select layout for header.', 'course-builder' ),
		'section'  => 'header_main_menu',
		'priority' => 1,
		'default'  => 'layout-1',
		'choices'  => array(
			'layout-1' => THIM_URI . 'assets/images/header-layout/layout-1.jpg',
			'layout-2' => THIM_URI . 'assets/images/header-layout/layout-2.jpg',
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'header_v2_style',
		'type'            => 'select',
		'label'           => esc_html__( 'Header Layout 2 Style', 'course-builder' ),
		//		'tooltip'         => esc_html__( 'Allows you can select position layout for header layout.', 'course-builder' ),
		'section'         => 'header_main_menu',
		'priority'        => 3,
		'multiple'        => 0,
		'default'         => 'default',
		'choices'         => array(
			'default' => esc_html__( 'Style 1', 'course-builder' ),
			'style2'  => esc_html__( 'Style 2', 'course-builder' ),
			'style3'  => esc_html__( 'Style 3', 'course-builder' ),
			'style_kit'  => esc_html__( 'Style Course Kit', 'course-builder' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_template',
				'operator' => '==',
				'value'    => 'layout-2',
			),
		),
	)
);

thim_customizer()->add_field( array(
	'type'     => 'palette',
	'id'       => 'header_palette',
	'label'    => esc_html__( 'Palette', 'course-builder' ),
	'section'  => 'header_main_menu',
    'tooltip'  => esc_html__( 'COLOR SORT: Main Menu Background Color - Sub Menu Background Color - Main Menu Text Color - Sub Text Menu Color', 'course-builder' ),
    'default'  => 'light',
	'priority' => 5,

	'choices'  => array(
		'white'       => array(
			'#FFF',
			'#202121',
			'#888888',
			'#18c1f0',
		),
		'transparent' => array(
			'transparent',
			'#FFFFFF',
			'#9c9c9c',
			'#202121',
		),
		'custom'      => array(
			esc_html__( 'Custom', 'course-builder' )
		),
	),
) );

// Select Header Position
thim_customizer()->add_field(
	array(
		'id'              => 'header_position',
		'type'            => 'select',
		'label'           => esc_html__( 'Header Positions', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you can select position layout for header layout.', 'course-builder' ),
		'section'         => 'header_main_menu',
		'priority'        => 10,
		'multiple'        => 0,
		'default'         => 'default',
		'choices'         => array(
			'default' => esc_html__( 'Default', 'course-builder' ),
			'overlay' => esc_html__( 'Overlay', 'course-builder' ),
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

// Background Header
thim_customizer()->add_field(
	array(
		'id'              => 'header_background_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you can choose background color for your header. ', 'course-builder' ),
		'section'         => 'header_main_menu',
		'default'         => '#ffffff',
		'priority'        => 17,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'body #masthead.site-header',
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

// Select All Fonts For Main Menu
thim_customizer()->add_field(
	array(
		'id'              => 'main_menu',
		'type'            => 'typography',
		'label'           => esc_html__( 'Fonts', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to change font properties for header.', 'course-builder' ),
		'section'         => 'header_main_menu',
		'priority'        => 10,
		'default'         => array(
			'font-family'    => 'Roboto',
			'variant'        => '700',
			'font-size'      => '15px',
			'line-height'    => '30px',
			'color'          => '#333333',
			'text-transform' => 'uppercase',
		),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'font-family',
				'element'  => 'header#masthead.site-header .width-navigation .inner-navigation #primary-menu >li >a,
                               header#masthead.site-header .width-navigation .inner-navigation #primary-menu >li >span',
				'property' => 'font-family',
			),
			array(
				'choice'   => 'variant',
				'element'  => 'header#masthead.site-header .width-navigation .inner-navigation #primary-menu >li >a,
                               header#masthead.site-header .width-navigation .inner-navigation #primary-menu >li >span',
				'property' => 'font-weight',
			),
			array(
				'choice'   => 'font-size',
				'element'  => 'header#masthead.site-header #primary-menu >li >a,
                               header#masthead.site-header #primary-menu >li >span',
				'property' => 'font-size',
			),
			array(
				'choice'   => 'line-height',
				'element'  => 'header#masthead.site-header #primary-menu >li >a,
                               header#masthead.site-header #primary-menu >li >span',
				'property' => 'line-height',
			),
			array(
				'choice'   => 'color',
				'element'  => 'header#masthead.site-header #primary-menu >li >a,
                               header#masthead.site-header #primary-menu >li >span,
                               header#masthead.site-header .navigation .width-navigation .inner-navigation .navbar > .current-menu-item a',
				'property' => 'color',
			),
			array(
				'choice'   => 'text-transform',
				'element'  => 'header#masthead.site-header #primary-menu >li >a,
                               header#masthead.site-header #primary-menu >li >span',
				'property' => 'text-transform',
			),
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

// Text Link Hover
thim_customizer()->add_field(
	array(
		'id'              => 'main_menu_hover_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Text Hover Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows to set text hover color for header.', 'course-builder' ),
		'section'         => 'header_main_menu',
		'default'         => '#3498DB',
		'priority'        => 16,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'header#masthead.site-header #primary-menu >li >a:hover,
                               header#masthead.site-header #primary-menu >li >span:hover',
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

// Show or Hide Magic Line
thim_customizer()->add_field(
	array(
		'id'          => 'header_show_magic_line',
		'type'        => 'switch',
		'label'       => esc_html__( 'Show magic line', 'course-builder' ),
		'tooltip'     => esc_html__( 'Allows you to show or hide magic line under main menu on header. Line color same as main menu color.', 'course-builder' ),
		'section'     => 'header_main_menu',
		'default'     => 0,
		'priority'    => 30,
		'choices'     => array(
			true  	  => esc_html__( 'On', 'course-builder' ),
			false	  => esc_html__( 'Off', 'course-builder' ),
		),
	)
);