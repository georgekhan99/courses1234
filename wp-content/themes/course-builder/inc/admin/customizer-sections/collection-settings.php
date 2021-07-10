<?php
/**
 * Section Blog General
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'collection_setting',
		'panel'    => 'collection',
		'title'    => esc_html__( 'Settings', 'course-builder' ),
		'priority' => 15,
	)
);

thim_customizer()->add_field( array(
	'label'           => esc_attr__( 'Archive Columns', 'course-builder' ),
	'id'              => 'collection_archive_columns',
	'type'            => 'select',
    'priority'        => 15,
	'section'         => 'collection_setting',
	'choices'         => array(
		'2' => esc_attr__( '2', 'course-builder' ),
		'3' => esc_attr__( '3', 'course-builder' ),
		'4' => esc_attr__( '4', 'course-builder' )
	),
	'default'         => '3',
) );

// Numbers per page
thim_customizer()->add_field(
    array(
        'type'        => 'slider',
        'id'          => 'collection_per_page',
        'label'       => esc_html__( 'Collection numbers ', 'course-builder' ),
        'tooltip'     => esc_html__( 'Allows to set the number collection on collection archive page.', 'course-builder' ),
        'section'     => 'collection_setting',
        'priority'    => 16,
        'default'     => 9,
        'choices'     => array(
            'min'  => '1',
            'max'  => '50',
            'step' => '1',
        ),
    )
);

thim_customizer()->add_field( array(
    'label'           => esc_attr__( 'Single Columns', 'course-builder' ),
    'id'              => 'collection_single_columns',
    'type'            => 'select',
    'section'         => 'collection_setting',
    'priority'        => 18,
    'choices'         => array(
        '2' => esc_attr__( '2', 'course-builder' ),
        '3' => esc_attr__( '3', 'course-builder' ),
        '4' => esc_attr__( '4', 'course-builder' )
    ),
    'default'         => '3',
) );
