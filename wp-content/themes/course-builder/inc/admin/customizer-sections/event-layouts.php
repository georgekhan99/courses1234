<?php
/**
 * Section Blog Layouts
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'event_layout',
		'panel'    => 'events',
		'title'    => esc_html__( 'Layouts', 'course-builder' ),
		'priority' => 10,
	)
);

//-------------------------------------------------Archive---------------------------------------------//

// Select Blog Archive Layout
thim_customizer()->add_field(
	array(
		'id'       => 'event_archive_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Event Archive Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for event archive pages.', 'course-builder' ),
		'section'  => 'event_layout',
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
		'id'              => 'event_archive_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Event Archive Layout ', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on Event archive layout.', 'course-builder' ),
		'section'         => 'event_layout',
		'priority'        => 13,
		'multiple'        => 1,
		'default'         => 'sidebar',
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'event_archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'event_archive_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Event Archive Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on Archive layout.', 'course-builder' ),
		'section'         => 'event_layout',
		'priority'        => 14,
		'multiple'        => 1,
		'default'         => 'sidebar',
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'event_archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

//-------------------------------------------------Single---------------------------------------------//

// Select Single Layout
thim_customizer()->add_field(
	array(
		'id'       => 'event_single_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Event Single Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for event single pages.', 'course-builder' ),
		'section'  => 'event_layout',
		'priority' => 20,
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
		'id'              => 'event_single_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Post Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on Post layout.', 'course-builder' ),
		'section'         => 'event_layout',
		'priority'        => 21,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'event_single_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'event_single_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Post Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on Post layout.', 'course-builder' ),
		'section'         => 'event_layout',
		'priority'        => 22,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'event_single_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);