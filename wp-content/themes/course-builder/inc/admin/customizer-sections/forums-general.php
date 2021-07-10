<?php
/**
 * Section Forums General
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'forums_general',
		'panel'    => 'forums',
		'title'    => esc_html__( 'Layouts', 'course-builder' ),
		'priority' => 10,
	)
);

//-------------------------------------------------Archive---------------------------------------------//

// Select Blog Archive Layout
thim_customizer()->add_field(
	array(
		'id'       => 'forums_archive_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Archive Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for forums archive and forums category pages.', 'course-builder' ),
		'section'  => 'forums_general',
		'priority' => 12,
		'default'  => 'no-sidebar',
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
		),
	)
);


//-------------------------------------------------Single---------------------------------------------//

// Select Single Layout
thim_customizer()->add_field(
	array(
		'id'       => 'forums_single_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Single Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for forums single pages.', 'course-builder' ),
		'section'  => 'forums_general',
		'default'  => 'sidebar-right',
		'priority' => 20,
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
		),
	)
);
