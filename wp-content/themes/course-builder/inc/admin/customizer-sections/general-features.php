<?php
/**
 * Section Advance features
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'advanced',
		'panel'    => 'general',
		'priority' => 80,
		'title'    => esc_html__( 'Extra Features', 'course-builder' ),
	)
);

// Feature: RTL
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'feature_rtl_support',
		'label'    => esc_html__( 'RTL Support', 'course-builder' ),
		'section'  => 'advanced',
		'default'  => 0,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);
//thim_customizer()->add_field(
//	array(
//		'type'     => 'switch',
//		'id'       => 'feature_remove_version',
//		'label'    => esc_html__( 'Remove Version CSS & JS', 'course-builder' ),
//		'section'  => 'advanced',
//		'default'  => 0,
//		'priority' => 10,
//		'choices'  => array(
//			true  => esc_html__( 'On', 'course-builder' ),
//			false => esc_html__( 'Off', 'course-builder' ),
//		),
//	)
//);
// Feature: Smoothscroll
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'feature_smoothscroll',
		'label'    => esc_html__( 'Smooth Scrolling', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to enable smooth scrolling.', 'course-builder' ),
		'section'  => 'advanced',
		'default'  => 0,
		'priority' => 20,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Feature: Open Graph Meta
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'feature_open_graph_meta',
		'label'    => esc_html__( 'Open Graph Meta Tags', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to enable open graph meta tags which is mainly used when sharing pages on social networking sites like Facebook.', 'course-builder' ),
		'section'  => 'advanced',
		'default'  => 1,
		'priority' => 30,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Feature: Back To Top
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'feature_backtotop',
		'label'    => esc_html__( 'Back To Top', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to enable the Back To Top script which adds the scrolling to top functionality.', 'course-builder' ),
		'section'  => 'advanced',
		'default'  => 1,
		'priority' => 40,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Feature: Toolbar Color For Android
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'feature_google_theme',
		'label'    => esc_html__( 'Google Theme', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to set the toolbar color in Chrome for Android.', 'course-builder' ),
		'section'  => 'advanced',
		'default'  => 0,
		'priority' => 50,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Feature: Google Theme Color
thim_customizer()->add_field(
	array(
		'type'            => 'color',
		'id'              => 'feature_google_theme_color',
		'label'           => esc_html__( 'Google Theme Color', 'course-builder' ),
		'section'         => 'advanced',
		'default'         => '#333333',
		'priority'        => 60,
		'alpha'           => true,
		'active_callback' => array(
			array(
				'setting'  => 'feature_google_theme',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

// Feature: Preload
thim_customizer()->add_field( array(
	'label'    => esc_html__( 'Preload', 'course-builder' ),
	'id'       => 'theme_feature_preloading',
	'type'     => 'switch',
	'section'  => 'advanced',
	'priority' => 70,
	'default'  => 0,
	'choices'  => array(
		true  => esc_html__( 'On', 'course-builder' ),
		false => esc_html__( 'Off', 'course-builder' ),
	),
) );


thim_customizer()->add_field( array(
	'type'     => 'radio-image',
	'id'       => 'theme_feature_loading',
	'section'  => 'advanced',
	'label'    => esc_html__( 'Loading icon', 'course-builder' ),
	'default'  => 'chasing-dots',
	'priority' => 80,
	'choices'  => array(
		'chasing-dots'    => THIM_URI . 'assets/images/preloading/chasing-dots.gif',
		'circle'          => THIM_URI . 'assets/images/preloading/circle.gif',
		'cube-grid'       => THIM_URI . 'assets/images/preloading/cube-grid.gif',
		'double-bounce'   => THIM_URI . 'assets/images/preloading/double-bounce.gif',
		'fading-circle'   => THIM_URI . 'assets/images/preloading/fading-circle.gif',
		'folding-cube'    => THIM_URI . 'assets/images/preloading/folding-cube.gif',
		'rotating-plane'  => THIM_URI . 'assets/images/preloading/rotating-plane.gif',
		'spinner-pulse'   => THIM_URI . 'assets/images/preloading/spinner-pulse.gif',
		'three-bounce'    => THIM_URI . 'assets/images/preloading/three-bounce.gif',
		'wandering-cubes' => THIM_URI . 'assets/images/preloading/wandering-cubes.gif',
		'wave'            => THIM_URI . 'assets/images/preloading/wave.gif',
		'custom-image'    => THIM_URI . 'assets/images/preloading/custom-image.jpg',
	),
) );

// Feature: Preload Image Upload
thim_customizer()->add_field( array(
	'type'            => 'image',
	'id'              => 'theme_feature_loading_custom_image',
	'label'           => esc_html__( 'Loading Custom Image', 'course-builder' ),
	'section'         => 'advanced',
	'priority'        => 90,
	'active_callback' => array(
		array(
			'setting'  => 'theme_feature_loading',
			'operator' => '===',
			'value'    => 'custom-image',
		),
	),
) );
// Feature: Login Popup Image
thim_customizer()->add_field(
	array(
		'id'              => 'bg_img_login_popup',
		'type'            => 'image',
		'label'           => esc_html__( 'Popup Background', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to add, remove and change Popup Background.', 'course-builder' ),
		'section'         => 'advanced',
		'priority'        => 100,
	)
);

thim_customizer()->add_field(
	array(
		'type'      => 'textarea',
		'id'        => 'text_widget_login',
		'label'     => esc_html__( 'Widget Login Text', 'course-builder' ),
		'tooltip'   => esc_html__( 'Enter the text that displays in the widget login. HTML markup can be used.', 'course-builder' ),
		'section'   => 'advanced',
		'default'   => sprintf( '<h2>Hello!</h2><h3>We are happy to see you again!</h3>' ),
		'priority'  => 102,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.login-banner-wrap',
				'function' => 'html',
			),
		)
	)
);
