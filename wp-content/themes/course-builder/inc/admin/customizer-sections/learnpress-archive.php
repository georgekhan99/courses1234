<?php
/**
 * Section Blog General
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'learnpress_archive',
		'panel'    => 'learnpress',
		'title'    => esc_html__( 'Archive', 'course-builder' ),
		'priority' => 15,
	)
);

// Enable or disable Top Sidebar Archive
thim_customizer()->add_field(
	array(
		'id'      => 'learnpress_top_sidebar_archive_display',
		'type'    => 'switch',
		'label'   => esc_html__( 'Show Top Widget Area', 'course-builder' ),
		'tooltip' => esc_html__( 'Turn on to show Top Widget Area on LearnPress archive pages.', 'course-builder' ),
		'section' => 'learnpress_archive',
		'default' => 1,
		'choices' => array(
			'on'  => esc_attr__( 'On', 'course-builder' ),
			'off' => esc_attr__( 'Off', 'course-builder' )
		),
	)
);

thim_customizer()->add_field( array(
	'label'   => esc_attr__( 'Page Style', 'course-builder' ),
	'id'      => 'learnpress_cate_style',
	'type'    => 'select',
	'section' => 'learnpress_archive',
	'choices' => array(
		'grid' => esc_attr__( 'Grid', 'course-builder' ),
		'list' => esc_attr__( 'List', 'course-builder' ),
	),
	'default' => 'grid',
) );

thim_customizer()->add_field( array(
	'label'           => esc_attr__( 'Grid Columns', 'course-builder' ),
	'id'              => 'learnpress_cate_grid_column',
	'type'            => 'select',
	'section'         => 'learnpress_archive',
	'choices'         => array(
		'2' => esc_attr__( '2', 'course-builder' ),
		'3' => esc_attr__( '3', 'course-builder' ),
		'4' => esc_attr__( '4', 'course-builder' )
	),
	'default'         => '3',
	'active_callback' => array(
		array(
			'setting'  => 'learnpress_cate_style',
			'operator' => '===',
			'value'    => 'grid',
		),
	),
) );

thim_customizer()->add_field(
	array(
		'id'      => 'learnpress_icon_archive_display',
		'type'    => 'switch',
		'label'   => esc_html__( 'Show Icons Archive Page', 'course-builder' ),
		'tooltip' => esc_html__( 'Turn on to show icons on LearnPress archive pages.', 'course-builder' ),
		'section' => 'learnpress_archive',
		'default' => 1,
		'choices' => array(
			'on'  => esc_attr__( 'On', 'course-builder' ),
			'off' => esc_attr__( 'Off', 'course-builder' )
		),
	)
);

thim_customizer()->add_field(
    array(
        'id'       => 'learnpress_display_course_sort',
        'type'     => 'switch',
        'label'    => esc_html__( 'Display Courses Sort?', 'course-builder' ),
        'tooltip'  => '',
        'section'  => 'learnpress_archive',
        'default'  => true,
        'priority' => 40,
        'choices'  => array(
            true  => esc_html__( 'Show', 'course-builder' ),
            false => esc_html__( 'Hide', 'course-builder' ),
        ),
    )
);


//thim_customizer()->add_field(
//    array(
//        'id'       => 'thim_display_course_filter',
//        'type'     => 'switch',
//        'label'    => esc_html__( 'Display Courses Filter?', 'course-builder' ),
//        'tooltip'  => '',
//        'section'  => 'learnpress_archive',
//        'default'  => false,
//        'priority' => 50,
//        'choices'  => array(
//            true  => esc_html__( 'Show', 'course-builder' ),
//            false => esc_html__( 'Hide', 'course-builder' ),
//        ),
//    )
//);
//
//thim_customizer()->add_field(
//    array(
//        'id'              => 'thim_filter_by_cate',
//        'type'            => 'toggle',
//        'label'           => esc_html__( 'Filter by Categories?', 'course-builder' ),
//        'tooltip'         => '',
//        'section'         => 'learnpress_archive',
//        'default'         => 0,
//        'priority'        => 55,
//        'active_callback' => array(
//            array(
//                'setting'  => 'thim_display_course_filter',
//                'operator' => '==',
//                'value'    => true,
//            ),
//        ),
//    )
//);
//
//thim_customizer()->add_field(
//    array(
//        'id'              => 'thim_filter_by_instructor',
//        'type'            => 'toggle',
//        'label'           => esc_html__( 'Filter by Instructors?', 'course-builder' ),
//        'tooltip'         => '',
//        'section'         => 'learnpress_archive',
//        'default'         => 0,
//        'priority'        => 60,
//        'active_callback' => array(
//            array(
//                'setting'  => 'thim_display_course_filter',
//                'operator' => '==',
//                'value'    => true,
//            ),
//        ),
//    )
//);
//
//thim_customizer()->add_field(
//    array(
//        'id'              => 'thim_filter_by_price',
//        'type'            => 'toggle',
//        'label'           => esc_html__( 'Filter by Price?', 'course-builder' ),
//        'tooltip'         => '',
//        'section'         => 'learnpress_archive',
//        'default'         => 0,
//        'priority'        => 65,
//        'active_callback' => array(
//            array(
//                'setting'  => 'thim_display_course_filter',
//                'operator' => '==',
//                'value'    => true,
//            ),
//        ),
//    )
//);