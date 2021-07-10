<?php
/**
 * Section Footer Settings
 *
 */

// Add Section Footer Options
thim_customizer()->add_section(
	array(
		'id'       => 'footer_options',
		'title'    => esc_html__( 'Settings', 'course-builder' ),
		'panel'    => 'footer',
		'priority' => 10,
	)
);
// Select Style
thim_customizer()->add_field(
	array(
		'id'       => 'footer_style',
		'type'     => 'select',
		'label'    => esc_html__( 'Select style', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to select style for Footer.', 'course-builder' ),
		'section'  => 'footer_options',
		'default'  => 'style_old',
		'priority' => 10,
		'multiple' => 0,
		'choices'  => array(
			'style_old' => esc_html__( 'Standard Style', 'course-builder' ),
			'style_new' => esc_html__( 'Demo Tech Camp', 'course-builder' ),
			'style_kit' => esc_html__( 'Demo Kit Builder', 'course-builder' )
		),
	)
);

// Footer Column Numbers
thim_customizer()->add_field(
	array(
		'type'     => 'slider',
		'id'       => 'footer_columns',
		'label'    => esc_html__( 'Number of footer columns', 'course-builder' ),
		'tooltip'  => esc_html__( 'Change the number of footer columns.', 'course-builder' ),
		'section'  => 'footer_options',
		'default'  => 6,
		'priority' => 20,
		'choices'  => array(
			'min'  => '1',
			'max'  => '6',
			'step' => '1',
		),
	)
);

thim_customizer()->add_field( array(
	'type'     => 'palette',
	'id'       => 'footer_palette',
	'label'    => esc_html__( 'Palette Colors', 'course-builder' ),
	'section'  => 'footer_options',
	'default'  => 'light',
	'priority' => 30,
	'choices'  => array(
		'light'  => array(
			'#FFF',
			'#202121',
			'#888888',
			'#666666',
		),
		'dark'   => array(
			'#202121',
			'#FFFFFF',
			'#acacac',
			'#646565',
		),
		'custom' => array(
			esc_html__( 'Custom colors', 'course-builder' )
		),
	),
) );

// Footer Background Color
thim_customizer()->add_field(
	array(
		'type'            => 'color',
		'id'              => 'footer_background_color',
		'label'           => esc_html__( 'Background Color', 'course-builder' ),
		'section'         => 'footer_options',
		'default'         => '#fff',
		'priority'        => 40,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'footer#colophon .footer',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'footer_palette',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);


// Footer Text Color
thim_customizer()->add_field(
	array(
		'type'            => 'multicolor',
		'id'              => 'footer_color',
		'label'           => esc_html__( 'Colors', 'course-builder' ),
		'section'         => 'footer_options',
		'priority'        => 50,
		'choices'         => array(
			'title'     => esc_html__( 'Title', 'course-builder' ),
			'text'      => esc_html__( 'Text', 'course-builder' ),
			'link'      => esc_html__( 'Link', 'course-builder' ),
			'copyright' => esc_html__( 'Copyright', 'course-builder' ),
		),
		'default'         => array(
			'title'     => '#202121',
			'text'      => '#888',
			'link'      => '#888',
			'copyright' => '#666'
		),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'title',
				'element'  => 'footer#colophon h1, footer#colophon h2, footer#colophon h3, footer#colophon h4, footer#colophon h5, footer#colophon h6',
				'property' => 'color',
			),
			array(
				'choice'   => 'text',
				'element'  => 'footer#colophon',
				'property' => 'color',
			),
			array(
				'choice'   => 'link',
				'element'  => 'footer#colophon a',
				'property' => 'color',
			),
			array(
				'choice'   => 'copyright',
				'element'  => 'footer#colophon .copyright-text',
				'property' => 'color',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'footer_palette',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);