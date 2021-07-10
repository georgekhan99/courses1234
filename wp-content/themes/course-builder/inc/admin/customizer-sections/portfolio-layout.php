<?php
/**
 * Section Archive
 **/

thim_customizer()->add_section(
	array(
		'id'       => 'portfolio_layout',
		'panel'    => 'portfolio',
		'title'    => esc_html__( 'Layouts', 'course-builder' ),
		'priority' => 10,
	)
);


// Select Blog Archive Layout
thim_customizer()->add_field(
	array(
		'id'       => 'portfolio_archive_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Archive Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to choose a layout for all portfolio archive pages.', 'course-builder' ),
		'section'  => 'portfolio_layout',
		'priority' => 12,
		'default'  => 'no-sidebar',
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
		),
	)
);

// Select Single Layout
thim_customizer()->add_field(
	array(
		'id'       => 'portfolio_single_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Single Layout', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to choose a layout to display for all portfolio single pages.', 'course-builder' ),
		'section'  => 'portfolio_layout',
		'default'  => 'no-sidebar',
		'priority' => 20,
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
			'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
		),
	)
);