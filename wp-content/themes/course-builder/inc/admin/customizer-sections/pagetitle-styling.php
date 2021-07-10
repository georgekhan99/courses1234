<?php
/**
 * Section Page Title
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'page_title_styling',
		'panel'    => 'page_title_bar',
		'title'    => esc_html__( 'Title', 'course-builder' ),
		'priority' => 12,
	)
);

thim_customizer()->add_field(
	array(
		'label'    => esc_attr__( 'Select a Layout', 'course-builder' ),
		'id'       => 'page_title_layout',
		'type'     => 'radio-image',
		'section'  => 'page_title_styling',
		'priority' => 2,
		'choices'  => array(
			"layout-1" => THIM_URI . 'assets/images/page-title/layouts/layout-1.jpg',
			"layout-2" => THIM_URI . 'assets/images/page-title/layouts/layout-2.jpg',
			"layout-3" => THIM_URI . 'assets/images/page-title/layouts/layout-3.jpg',
		),
		'default'  => 'layout-1',
	)
);

// Upload Background Image
thim_customizer()->add_field(
	array(
		'id'       => 'page_title_background_image',
		'type'     => 'image',
		'label'    => esc_html__( 'Background Image', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to set background image for page title area.', 'course-builder' ),
		'section'  => 'page_title_styling',
		'priority' => 3,
		'default'  => THIM_URI . "assets/images/page-title/bg.jpg",
		'js_vars'  => array(
			array(
				'element'  => '.main-top',
				'function' => 'css',
				'property' => 'background-image',
			),
		),
	)
);


// Background Header
thim_customizer()->add_field(
	array(
		'id'        => 'page_title_background_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to set background color for page title area.', 'course-builder' ),
		'section'   => 'page_title_styling',
		'default'   => 'rgba(0,0,0,0.6)',
		'priority'  => 4,
		'alpha'     => true,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'color',
				'element'  => '.main-top',
				'property' => 'background-color',
			)
		),
	)
);


// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'       => 'page_title_show_text',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Page Title', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to show or hide page title area.', 'course-builder' ),
		'section'  => 'page_title_styling',
		'default'  => 1,
		'priority' => 5,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);


// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'       => 'page_title_parallax',
		'type'     => 'switch',
		'label'    => esc_html__( 'Parallax', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to parallax on page title area, turn off on the mobile.', 'course-builder' ),
		'section'  => 'page_title_styling',
		'default'  => 1,
		'priority' => 5,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Background Header
thim_customizer()->add_field(
	array(
		'id'        => 'page_title_custom_title',
		'type'      => 'text',
		'label'     => esc_html__( 'Custom Title', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to set custom page title.', 'course-builder' ),
		'section'   => 'page_title_styling',
		'priority'  => 6,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.page-title .main-top .content .text-title h1, .page-title .main-top .content .text-title h2',
				'function' => 'html',
			),
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'page_title_custom_description',
		'type'      => 'textarea',
		'label'     => esc_html__( 'Custom Description', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to set custom page title description.', 'course-builder' ),
		'section'   => 'page_title_styling',
		'default'   => '<strong class="br">The best demo education </strong> Be successful with Course Builder theme.',
		'priority'  => 6,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.page-title .banner-description',
				'function' => 'html',
			),
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'page_title_text_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Title Text Color', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to set page title text color.', 'course-builder' ),
		'section'   => 'page_title_styling',
		'default'   => '#ffffff',
		'priority'  => 6,
		'alpha'     => true,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'color',
				'element'  => '.page-title .main-top .content .text-title h1, .page-title .main-top .content .text-title h2',
				'property' => 'color',
			)
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'page_title_description_strong_color',
		'type'      => 'color',
		'label'     => esc_html__( "Description strong Text Color", 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to set page Description strong tag text color.', 'course-builder' ),
		'section'   => 'page_title_styling',
		'default'   => '#f6f6f7',
		'priority'  => 6,
		'alpha'     => true,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'color',
				'element'  => '.page-title .main-top .content .text-description strong',
				'property' => 'color',
			)
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'page_title_description_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Description Text Color', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to set page Description text color.', 'course-builder' ),
		'section'   => 'page_title_styling',
		'default'   => '#e0e0e0',
		'priority'  => 6,
		'alpha'     => true,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'color',
				'element'  => '.page-title .main-top .content .text-description',
				'property' => 'color',
			)
		),
	)
);

// Height Page Title
thim_customizer()->add_field(
	array(
		'id'        => 'page_title_height',
		'type'      => 'dimension',
		'label'     => esc_html__( 'Height', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to adjust page title height in supported units: px, em, cm, in, % and more.', 'course-builder' ),
		'section'   => 'page_title_styling',
		'default'   => '434px',
		'priority'  => 7,
		'choices'   => array(
			'min'  => 100,
			'max'  => 500,
			'step' => 10,
		),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'height',
				'element'  => '.page-title .main-top',
				'property' => 'height',
			)
		),
	)
);