<?php
/**
 * Section Woocommerce Archive
 *
 * @package 'course-builder'
 */

thim_customizer()->add_section(
	array(
		'id'       => 'woocommerce_layout',
		'panel'    => 'woocommerce',
		'title'    => esc_html__( 'Layouts', 'course-builder' ),
		'priority' => 20,
	)
);

// Archive Layouts
thim_customizer()->add_field(
	array(
		'id'       => 'woocommerce_archive_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Archive Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for WooCommerce archive pages.', 'course-builder' ),
		'section'  => 'woocommerce_layout',
		'priority' => 10,
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
		'id'              => 'woocommerce_archive_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Archive Layout ', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on product archive layout.', 'course-builder' ),
		'section'         => 'woocommerce_layout',
		'priority'        => 13,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'woocommerce_archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'woocommerce_archive_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Archive Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on product archive layout.', 'course-builder' ),
		'section'         => 'woocommerce_layout',
		'priority'        => 14,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'woocommerce_archive_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Single Page Layouts
thim_customizer()->add_field(
	array(
		'id'       => 'woocommerce_single_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Single Layouts', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to choose layout for WooCommerce single pages.', 'course-builder' ),
		'section'  => 'woocommerce_layout',
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
		'id'              => 'woocommerce_single_layout_sidebar_left',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Left For Post Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar left when you used Full sidebar layout on product single page.', 'course-builder' ),
		'section'         => 'woocommerce_layout',
		'priority'        => 21,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'woocommerce_single_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);

// Select Sidebar To Display In Sidebar Right For Full Sidebar Layout
thim_customizer()->add_field(
	array(
		'id'              => 'woocommerce_single_layout_sidebar_right',
		'type'            => 'select',
		'label'           => esc_html__( 'Sidebar Right For Post Layout', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to select a sidebar to display in sidebar right when you used Full sidebar layout on product single page.', 'course-builder' ),
		'section'         => 'woocommerce_layout',
		'priority'        => 22,
		'multiple'        => 1,
		'choices'         => thim_get_list_sidebar(),
		'active_callback' => array(
			array(
				'setting'  => 'woocommerce_single_layout',
				'operator' => '===',
				'value'    => 'full-sidebar',
			),
		),
	)
);
