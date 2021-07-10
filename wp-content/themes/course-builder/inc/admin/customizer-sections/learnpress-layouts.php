<?php
/**
 * Section Blog Layouts
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'learnpress_layout',
		'panel'    => 'learnpress',
		'title'    => esc_html__( 'Layouts', 'course-builder' ),
		'priority' => 10,
	)
);

//-------------------------------------------------Archive---------------------------------------------//

// Select Blog Archive Layout
thim_customizer()->add_field(
	array(
		'id'       => 'learnpress_archive_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Courses Archive Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for course archive pages.', 'course-builder' ),
		'section'  => 'learnpress_layout',
		'priority' => 12,
		'default'  => 'sidebar-right',
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
		'id'              => 'learnpress_archive_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Courses Archive Layout ', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on Courses archive layout.', 'course-builder' ),
		'section'         => 'learnpress_layout',
		'priority'        => 13,
		'multiple'        => 1,
		'default'         => 'sidebar',
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'learnpress_archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'learnpress_archive_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Courses Archive Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on Archive layout.', 'course-builder' ),
		'section'         => 'learnpress_layout',
		'priority'        => 14,
		'multiple'        => 1,
		'default'         => 'sidebar',
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'learnpress_archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

//-------------------------------------------------Single---------------------------------------------//

// Course Single Style
thim_customizer()->add_field( array(
	'id'       => 'learnpress_single_course_style',
	'section'  => 'learnpress_layout',
	'priority' => 15,
	'type'     => 'radio-image',
	'label'    => esc_attr__( 'Course Single Styles', 'course-builder' ),
	'default'  => '1',
	'choices'  => array(
		"1" => THIM_URI . 'assets/images/single-course/style1.jpg',
		"2" => THIM_URI . 'assets/images/single-course/style2.jpg',
	),
) );

// Select Single Layout
thim_customizer()->add_field(
	array(
		'id'       => 'learnpress_single_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Course Single Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for Course single pages.', 'course-builder' ),
		'section'  => 'learnpress_layout',
		'priority' => 20,
		'default'  => 'no-sidebar',
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
		),
		'active_callback' => array(
			array(
				'setting'  => 'learnpress_single_course_style',
				'operator' => '==',
				'value'    => '1',
			),
		),
	)
);