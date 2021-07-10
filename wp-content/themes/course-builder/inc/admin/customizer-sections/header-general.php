<?php
/**
 * Section Header Layout
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_layout',
		'title'    => esc_html__( 'Settings', 'course-builder' ),
		'panel'    => 'header',
		'priority' => 20,
	)
);


// Enable or disable menu right
thim_customizer()->add_field(
	array(
		'id'       => 'menu_right_display',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Search', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to enable or disable Search form for header template 1 or ONLY style 2 of header template 2.', 'course-builder' ),
		'section'  => 'header_layout',
		'default'  => 1,
		'priority' => 15,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Enable or disable text
thim_customizer()->add_field(
	array(
		'id'       => 'search_text_on_header',
		'type'     => 'text',
		'label'    => esc_html__( 'Search text', 'course-builder' ),
		'default'  => esc_html__( 'What are you looking for ?', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to input text for search on header.', 'course-builder' ),
		'section'  => 'header_layout',
		'priority' => 16,
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'header_sidebar_right_display',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Header Right Sidebar', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to enable or disable Header right sidebar.', 'course-builder' ),
		'section'  => 'header_layout',
		'default'  => 1,
		'priority' => 20,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'profile_menu_items',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Menu Profile Items', 'course-builder' ),
		'tooltip'  => esc_html__( 'Click on eye icon to show or hide social icon. Drag and drop to change the order of menu items.', 'course-builder' ),
		'section'  => 'header_layout',
		'priority' => 35,
		'default'  => array(
			'become_a_teacher',
			'courses',
			'orders',
			'certificates',
			'settings'
		),
		'choices'  => array(
			'become_a_teacher' => esc_html_x( 'Become An Instructor', 'Customizer option', 'course-builder' ),
			'courses'          => esc_html_x( 'My Courses', 'Customizer option', 'course-builder' ),
			'orders'           => esc_html_x( 'My Orders', 'Customizer option', 'course-builder' ),
			'certificates'     => esc_html_x( 'My Certificates', 'Customizer option', 'course-builder' ),
			'settings'         => esc_html_x( 'Edit Profile', 'Customizer option', 'course-builder' ),
		)
	)
);