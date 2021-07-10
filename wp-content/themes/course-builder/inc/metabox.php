<?php

/**
 *
 * Home Settings
 *
 * @param $meta_boxes
 *
 * @return array
 */
function thim_metabox_home_settings( $meta_boxes ) {
	$prefix = 'thim_';

	$meta_boxes[] = array(
		'id'         => $prefix . 'footer',
		'title'      => esc_html__( 'Home - Settings', 'course-builder' ),
		'post_types' => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show'       => array(
			'template' => array( 'templates/home-page.php', 'templates/home-page-2.php' ),
		),
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Footer Palette Colors', 'course-builder' ),
				'id'      => $prefix . 'footer_palette',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'course-builder' ),
					'light'   => esc_html__( 'Light', 'course-builder' ),
					'dark'    => esc_html__( 'Dark', 'course-builder' ),
					'custom'  => esc_html__( 'Custom', 'course-builder' ),
				)
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'thim_metabox_home_settings' );


/**
 *
 * Home Settings
 *
 * @param $meta_boxes
 *
 * @return array
 */
function thim_metabox_extra_class( $meta_boxes ) {
	$prefix = 'thim_';

	$meta_boxes[] = array(
		'id'         => $prefix . 'extra',
		'title'      => esc_html__( 'Advanced Settings', 'course-builder' ),
		'post_types' => array( 'page' ),
		'context'    => 'side',
		'priority'   => 'low',
		'fields'     => array(
			array(
				'name' => esc_html__( 'Extra Class', 'course-builder' ),
				'id'   => $prefix . 'extra_class',
				'type' => 'text',
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'thim_metabox_extra_class' );


/**
 * Display Settings
 * Page
 * @author khoapq
 */
add_filter( 'thim_metabox_display_settings', 'thim_metabox_page_display_settings' );
function thim_metabox_page_display_settings( $metabox_ ) {
	$prefix                = 'thim_';
	$page_id               = isset( $_GET['post'] ) ? $_GET['post'] : '';
	$custom_description    = get_theme_mod( 'page_title_custom_description' ) ? get_theme_mod( 'page_title_custom_description' ) : '';
	$profile_page_id       = get_option( 'learn_press_profile_page_id' );
	$custom_layout_default = ( $page_id == $profile_page_id ) ? 'no-sidebar' : 'sidebar-right';


	$metabox_ = array(
		'title'      => esc_attr__( 'Display settings', 'course-builder' ),
		'post_types' => array( 'page', 'post', 'lp_collection', 'lp_course', 'product', 'forum', 'topic', 'tp_event', 'portfolio' ),
		'tabs'       => array(
			'page_title' => array(
				'label' => esc_attr__( 'Page Title', 'course-builder' ),
				'icon'  => 'dashicons-admin-appearance',
			),
			'layout'     => array(
				'label' => esc_attr__( 'Layout', 'course-builder' ),
				'icon'  => 'dashicons-align-left',
			),
		),
		'tab_style'  => 'box',

		'tab_wrapper' => true,
		'fields'      => array(
			/**
			 * Custom Settings
			 */
			array(
				'name' => esc_attr__( 'Custom Page Title', 'course-builder' ),
				'id'   => $prefix . 'enable_custom_title',
				'type' => 'checkbox',
				'std'  => 0,
				'tab'  => 'page_title',
			),

			array(
				'type'   => 'divider',
				'tab'    => 'page_title',
				'hidden' => array( $prefix . 'enable_custom_title', '=', 0 ),
			),

			array(
				'name'   => esc_attr__( 'Hide All Page Title', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_page_title',
				'type'   => 'checkbox',
				'std'    => 0,
				'hidden' => array( $prefix . 'enable_custom_title', '=', 0 ),
				'tab'    => 'page_title',
			),

//			array(
//				'name'   => esc_attr__( 'Auto Scroll To Main Content', 'course-builder' ),
//				'id'     => $prefix . 'group_custom_title_auto_scroll',
//				'type'   => 'checkbox',
//				'std'    => 0,
//				'hidden'  => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
//				'tab'    => 'page_title',
//			),

			array(
				'type'   => 'heading',
				'name'   => esc_attr__( 'Title & Breadcrumb', 'course-builder' ),
				'desc'   => 'Optional description',
				'tab'    => 'page_title',
				'hidden' => array( $prefix . 'enable_custom_title', '=', 0 ),
			),

			array(
				'name'    => esc_attr__( 'Select Layout', 'course-builder' ),
				'id'      => $prefix . 'group_custom_title_layout',
				'type'    => 'image_select',
				'options' => array(
					'layout-1' => THIM_URI . 'assets/images/page-title/layouts/layout-1.jpg',
					'layout-2' => THIM_URI . 'assets/images/page-title/layouts/layout-2.jpg',
					'layout-3' => THIM_URI . 'assets/images/page-title/layouts/layout-3.jpg',
				),
				'tab'     => 'page_title',
				'hidden'  => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
				'std'     => 'layout-1',
			),

			array(
				'name'   => esc_attr__( 'Hide Title', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_title',
				'type'   => 'checkbox',
				'std'    => 0,
				'hidden' => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
				'tab'    => 'page_title',
			),

			array(
				'name'        => esc_attr__( 'Custom Title', 'course-builder' ),
				'id'          => $prefix . 'group_custom_title_new_title',
				'type'        => 'text',
				'desc'        => 'Leave empty to use current page title',
				'std'         => get_the_title( $page_id ),
				'placeholder' => get_the_title( $page_id ),
				'hidden'      => array( $prefix . 'group_custom_title_hide_title', '=', 1 ),
				'tab'         => 'page_title',
			),

			array(
				'name'   => esc_attr__( 'Hide Sub Title & Description', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_sub_title',
				'type'   => 'checkbox',
				'std'    => 0,
				'hidden' => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
				'tab'    => 'page_title',
			),

			array(
				'name'   => esc_attr__( 'Custom Sub Title & Description', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_custom_sub_title',
				'type'   => 'textarea',
//				'desc'        => esc_attr__( 'Leave empty to use the content in Customize / Page Title / Title / Custom Description', 'course-builder' ),
				'std'    => $custom_description,
//				'placeholder' => $custom_description,
				'hidden' => array( $prefix . 'group_custom_title_hide_sub_title', '=', 1 ),
				'tab'    => 'page_title',
			),

			array(
				'name'   => esc_attr__( 'Hide Breadcrumbs', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_breadcrumbs',
				'type'   => 'checkbox',
				'std'    => 0,
				'hidden' => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
				'tab'    => 'page_title',
			),

			array(
				'type'   => 'heading',
				'name'   => esc_attr__( 'Background', 'course-builder' ),
				'desc'   => 'Optional description',
				'tab'    => 'page_title',
				'hidden' => array( $prefix . 'enable_custom_title', '=', 0 ),
			),

			array(
				'name'             => esc_attr__( 'Background Image', 'course-builder' ),
				'id'               => $prefix . 'group_custom_title_bg_img',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'force_delete'     => false,
				'hidden'           => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
				'tab'              => 'page_title',
			),

			array(
				'name'          => esc_attr__( 'Background Color Overlay', 'course-builder' ),
				'id'            => $prefix . 'group_custom_title_bg_color',
				'type'          => 'color',
				'alpha_channel' => true,
				'hidden'        => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
				'tab'           => 'page_title',
			),

			array(
				'name'          => esc_attr__( 'Background Color SC', 'course-builder' ),
				'id'            => $prefix . 'sc_bg_color',
				'type'          => 'color',
				'alpha_channel' => true,
				'hidden'        => array( $prefix . 'group_custom_title_hide_page_title', '=', 1 ),
				'tab'           => 'page_title',
			),

			/**
			 * Custom layout
			 */
			array(
				'name' => esc_attr__( 'Custom Layout', 'course-builder' ),
				'id'   => $prefix . 'enable_custom_layout',
				'type' => 'checkbox',
				'tab'  => 'layout',
				'std'  => false,
			),
			array(
				'name'    => esc_attr__( 'Select Layout', 'course-builder' ),
				'id'      => $prefix . 'custom_layout',
				'type'    => 'image_select',
				'options' => array(
					'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
					'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
					'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
					'full-sidebar'  => THIM_URI . 'assets/images/layout/body-left-right.jpg'
				),
				'tab'     => 'layout',
				'hidden'  => array( $prefix . 'enable_custom_layout', '=', false ),
				'std'     => $custom_layout_default,
			),
			array(
				'name'   => esc_attr__( 'No Padding', 'course-builder' ),
				'id'     => $prefix . 'no_padding_content',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'enable_custom_layout', '=', false ),
				'tab'    => 'layout',
			),
		),
	);

	return $metabox_;
}

if ( is_admin() ) {
	/*
	   * prefix of meta keys, optional
	   */
	$prefix = 'thim_';

	/*
	   * configure your meta box
	   */
	$config = array(
		'id'             => 'category_meta_box',
		// meta box id, unique per meta box
		'title'          => esc_html__( 'Category Meta Box', 'course-builder' ),
		// meta box title
		'pages'          => array( 'category', 'product_cat', 'course_category', 'portfolio_category', 'post_tag', 'course_tag', 'tp_event_tag', 'tp_event_category' ),
		// taxonomy name, accept categories, post_tag and custom taxonomies
		'context'        => 'normal',
		// where the meta box appear: normal (default), advanced, side; optional
		'fields'         => array(),
		// list of meta fields (can be added by field arrays)
		'local_images'   => false,
		// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => THIM_URI . '/inc/libs/Tax-meta-class'
		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$taxonomy = !empty( $_REQUEST['taxonomy'] ) ? $_REQUEST['taxonomy'] : 'category';

	$my_meta = new Tax_Meta_Class( $config );

	$my_meta->addCheckbox( 'thim_enable_custom_title', array(
		'name' => esc_html__( 'Custom Page Title ', 'course-builder' ),
		'std'  => ''
	) );
	$my_meta->addCheckbox( 'thim_group_custom_title_hide_page_title', array( 'name' => esc_html__( 'Hide All Page Title', 'course-builder' ) ) );

	$my_meta->addSelect( 'thim_group_custom_title_layout', array(
		'layout-1' => esc_html__( 'Layout 1', 'course-builder' ),
		'layout-2' => esc_html__( 'Layout 2', 'course-builder' ),
		'layout-3' => esc_html__( 'Layout 3', 'course-builder' )
	), array( 'name' => esc_html__( 'Custom Title Layout ', 'course-builder' ), 'std' => array( '' ) ) );

	$my_meta->addCheckbox( 'thim_group_custom_title_hide_title', array( 'name' => esc_html__( 'Hide Title', 'course-builder' ) ) );
	$my_meta->addText( 'thim_group_custom_title_new_title', array( 'name' => esc_html__( 'Custom Title', 'course-builder' ) ) );
	$my_meta->addCheckbox( 'thim_group_custom_title_hide_sub_title', array( 'name' => esc_html__( 'Hide Sub Title & Description', 'course-builder' ) ) );
	$my_meta->addTextarea( 'thim_group_custom_title_custom_sub_title', array( 'name' => esc_html__( 'Custom Sub Title & Description', 'course-builder' ) ) );
	$my_meta->addCheckbox( 'thim_group_custom_title_hide_breadcrumbs', array( 'name' => esc_html__( 'Hide Breadcrumbs', 'course-builder' ) ) );

	$my_meta->addImage( 'thim_group_custom_title_bg_img', array( 'name' => esc_html__( 'Background Image', 'course-builder' ), 'std' => array() ) );
	$my_meta->addColor( 'thim_group_custom_title_bg_color', array( 'name' => esc_html__( 'Background Color Overlay', 'course-builder' ), 'std' => 'rgba(0,0,0,0.6)' ) );
	$my_meta->addColor( 'thim_sc_bg_color', array( 'name' => esc_html__( 'Background Color Category Course', 'course-builder' ), 'std' => '#60d3c6' ) );

	$my_meta->Finish();
}
