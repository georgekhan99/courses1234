<?php
/**
 * Section Woocommerce Settings
 *
 * @package Hotel-WP
 */

thim_customizer()->add_section(
    array(
        'id'       => 'woocommerce_settings',
        'panel'    => 'woocommerce',
        'title'    => esc_html__( 'Settings', 'course-builder' ),
        'priority' => 10,
    )
);

// Numbers per page
thim_customizer()->add_field(
    array(
        'type'        => 'slider',
        'id'          => 'woocommerce_product_per_page',
        'label'       => esc_html__( 'Number Of Products Per Page', 'course-builder' ),
        'tooltip'     => esc_html__( 'Allows to set the number of products on WooCommerce Archive pages.', 'course-builder' ),
        'section'     => 'woocommerce_settings',
        'priority'    => 10,
        'default'     => 8,
        'choices'     => array(
            'min'  => '0',
            'max'  => '50',
            'step' => '1',
        ),
    )
);


//Grid Layout Columns
thim_customizer()->add_field(
    array(
        'type'        => 'select',
        'id'          => 'woocommerce_product_column',
        'label'       => esc_html__( 'Grid Columns', 'course-builder' ),
        'tooltip'     => esc_html__( 'Allows to set the number of grid columns on WooCommerce archive pages.', 'course-builder' ),
        'section'     => 'woocommerce_settings',
        'default'     => '4',
        'priority'    => 20,
        'multiple'    => 0,
        'choices'     => array(
            '2' => esc_html__( '2', 'course-builder' ),
            '3' => esc_html__( '3', 'course-builder' ),
            '4' => esc_html__( '4', 'course-builder' ),
        ),
    )
);

//Product Related Columns
thim_customizer()->add_field(
    array(
        'type'        => 'select',
        'id'          => 'woocommerce_related_column',
        'label'       => esc_html__( 'Number of Related Products', 'course-builder' ),
        'tooltip'     => esc_html__( 'Allows to set the number of related products on WooCommerce single pages.', 'course-builder' ),
        'section'     => 'woocommerce_settings',
        'default'     => '4',
        'priority'    => 30,
        'multiple'    => 0,
        'choices'     => array(
            '3' => esc_html__( '3', 'course-builder' ),
            '4' => esc_html__( '4', 'course-builder' ),
        ),
    )
);

// Enable or Disable Quickview
thim_customizer()->add_field(
    array(
        'id'          => 'enable_product_quickview',
        'type'        => 'switch',
        'label'       => esc_html__( 'Show QuickView', 'course-builder' ),
        'tooltip'     => esc_html__( 'Turn on to enable quick view for WooCommerce products.', 'course-builder' ),
        'section'     => 'woocommerce_settings',
        'default'     => 1,
        'priority'    => 50,
        'choices'     => array(
            true  	  => esc_html__( 'On', 'course-builder' ),
            false	  => esc_html__( 'Off', 'course-builder' ),
        ),
    )
);