<?php
/**
 * Section Page Title Product
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'page_title_product',
		'panel'    => 'page_title_bar',
		'title'    => esc_html__( 'Products: Archive Pages', 'course-builder' ),
		'priority' => 50,
	)
);

thim_customizer()->add_field(
	array(
		'label'    => esc_attr__( 'Select a layout page title', 'course-builder' ),
		'id'       => 'product_page_title_layout',
		'type'     => 'radio-image',
		'section'  => 'page_title_product',
		'priority' => 1,
		'choices'  => array(
			"layout-1" => THIM_URI . 'assets/images/page-title/layouts/layout-1.jpg',
			"layout-2" => THIM_URI . 'assets/images/page-title/layouts/layout-2.jpg',
			"layout-3" => THIM_URI . 'assets/images/page-title/layouts/layout-3.jpg',
		),
		'default'  => 'layout-1',
	)
);

// Enable or Disable Breadcrumb
thim_customizer()->add_field(
	array(
		'id'       => 'product_show_breadcrumb',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show/Hide Breadcrumb', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to show or hide breadcrumb on page title bar. ', 'course-builder' ),
		'section'  => 'page_title_product',
		'default'  => 1,
		'priority' => 2,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'       => 'product_page_title_show_text',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Page Title', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to show or hide page title area.', 'course-builder' ),
		'section'  => 'page_title_product',
		'default'  => 1,
		'priority' => 5,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'product_page_title_custom_description',
		'type'      => 'textarea',
		'label'     => esc_html__( 'Custom Description', 'course-builder' ),
		'tooltip'   => esc_html__( 'Allows to set custom page title description.', 'course-builder' ),
		'section'   => 'page_title_product',
		'default'   => '<strong class="br">The best demo education </strong> Be successful with Course Builder theme.',
		'priority'  => 7,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => 'body.post-type-archive-product .page-title .banner-description',
				'function' => 'html',
			),
		)
	)
);

// Upload Background Image
thim_customizer()->add_field(
	array(
		'id'       => 'page_title_product_background_image',
		'type'     => 'image',
		'label'    => esc_html__( 'Background Image', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows to set background image for page title area of shop page.', 'course-builder' ),
		'section'  => 'page_title_product',
		'priority' => 50,
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