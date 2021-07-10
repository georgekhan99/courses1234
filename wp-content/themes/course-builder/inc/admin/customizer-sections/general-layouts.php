<?php
/**
 * Section Layout
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'content_layout',
		'panel'    => 'general',
		'title'    => esc_html__( 'Layouts', 'course-builder' ),
		'priority' => 20,
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'site_home_width',
		'type'      => 'dimension',
		'label'     => esc_html__( 'Site Home Width', 'course-builder' ),
		'tooltip'   => esc_html__( 'Controls the home site width only. Enter value including any valid CSS unit, ex: 1546px', 'course-builder' ),
		'section'   => 'content_layout',
		'default'   => '1546px',
		'priority'  => 9,
		'choices'   => array(
			'min'  => 960,
			'max'  => 1920,
			'step' => 1,
		),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'width',
				'element'  => 'body.home #main-content .container',
				'property' => 'width',
			)
		)
	)
);

//---------------------------------------------Site-Content---------------------------------------------//

// Select Theme Content Layout
thim_customizer()->add_field(
	array(
		'id'       => 'box_content_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Site Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to choose layout to display for all contents.', 'course-builder' ),
		'section'  => 'content_layout',
		'priority' => 10,
		'default'  => 'wide',
		'choices'  => array(
			'wide'  => THIM_URI . 'assets/images/layout/content-full.jpg',
			'boxed' => THIM_URI . 'assets/images/layout/content-boxed.jpg',
		),
	)
);

//-------------------------------------------------Archive---------------------------------------------//

// Select Archive Layout
thim_customizer()->add_field(
	array(
		'id'       => 'archive_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Archive Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to choose layout to display for all archive pages.', 'course-builder' ),
		'section'  => 'content_layout',
		'priority' => 12,
        'default'  => 'no-sidebar',
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
			'full-sidebar'  => THIM_URI . 'assets/images/layout/body-left-right.jpg'
		),
	)
);

// Select Sidebar To Display In Sidebar Left For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'archive_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Archive Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on archive layouts.', 'course-builder' ),
		'section'         => 'content_layout',
		'priority'        => 13,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'archive_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Archive Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on archive layouts.', 'course-builder' ),
		'section'         => 'content_layout',
		'priority'        => 14,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

//-------------------------------------------------Single-------------------------------------------//

// Select Single Layout
thim_customizer()->add_field(
	array(
		'id'       => 'single_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Single Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to choose a layout to display for single pages.', 'course-builder' ),
		'section'  => 'content_layout',
        'default'  => 'sidebar-right',
		'priority' => 20,
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
			'full-sidebar'  => THIM_URI . 'assets/images/layout/body-left-right.jpg'
		),
	)
);

// Select Sidebar To Display In Sidebar Left For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'single_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Post Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on single layouts.', 'course-builder' ),
		'section'         => 'content_layout',
		'priority'        => 21,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'single_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'single_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Post Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on single layouts.', 'course-builder' ),
		'section'         => 'content_layout',
		'priority'        => 22,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'single_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

//------------------------------------------------Page---------------------------------------------//

// Select All Page Layout
thim_customizer()->add_field(
	array(
		'id'       => 'page_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Page Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to choose a layout to display for all pages.', 'course-builder' ),
		'section'  => 'content_layout',
        'default'  => 'no-sidebar',
		'priority' => 66,
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
			'full-sidebar'  => THIM_URI . 'assets/images/layout/body-left-right.jpg'
		),
	)
);

// Select Sidebar To Display In Sidebar Left For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'page_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Page Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on page layouts.', 'course-builder' ),
		'section'         => 'content_layout',
		'priority'        => 67,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'page_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'page_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Page Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on page layouts.', 'course-builder' ),
		'section'         => 'content_layout',
		'priority'        => 68,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'page_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);
