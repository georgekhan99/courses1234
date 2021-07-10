<?php
/**
 * Panel Woocommerce
 *
 * @package Hotel-WP
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'woocommerce',
        'title'    => esc_html__( 'Products', 'course-builder' ),
        'priority' => 65,
        'icon'     => 'dashicons-cart',
    )
);