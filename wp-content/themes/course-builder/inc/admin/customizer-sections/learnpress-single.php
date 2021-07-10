<?php
/*
 * Section LearnPress / Features
 * */

thim_customizer()->add_section(
	array(
		'id'       => 'learnpress_single',
		'panel'    => 'learnpress',
		'title'    => esc_html__( 'Single', 'course-builder' ),
		'priority' => 20,
	)
);

thim_customizer()->add_field( array(
	'label'    => esc_html__( 'Show/Hidden All Lesson Comment', 'course-builder' ),
	'id'       => 'thim_learnpress_lesson_comment',
	'type'     => 'switch',
	'section'  => 'learnpress_single',
	'tooltip'  => 'Check this box to hide/unhide advertisement',
	'default'  => 1,
	'priority' => 5,
	'choices'  => array(
		true  => esc_html__( 'On', 'course-builder' ),
		false => esc_html__( 'Off', 'course-builder' ),
	),
) );

thim_customizer()->add_field( array(
	'label'    => esc_html__( 'Show/Hidden Lessons completed', 'course-builder' ),
	'id'       => 'thim_learnpress_lessons_completed',
	'type'     => 'switch',
	'section'  => 'learnpress_single',
	'tooltip'  => 'Check this box to hide/unhide lessons completed',
	'default'  => 1,
	'priority' => 10,
	'choices'  => array(
		true  => esc_html__( 'On', 'course-builder' ),
		false => esc_html__( 'Off', 'course-builder' ),
	),
) );

thim_customizer()->add_field( array(
	'label'    => esc_html__( 'Show/Hidden Course results', 'course-builder' ),
	'id'       => 'thim_learnpress_course_results',
	'type'     => 'switch',
	'section'  => 'learnpress_single',
	'tooltip'  => 'Check this box to hide/unhide course results',
	'default'  => 1,
	'priority' => 15,
	'choices'  => array(
		true  => esc_html__( 'On', 'course-builder' ),
		false => esc_html__( 'Off', 'course-builder' ),
	),
) );

thim_customizer()->add_field( array(
	'label'    => esc_html__( 'Show/Hidden Remaining time', 'course-builder' ),
	'id'       => 'thim_learnpress_remaining_time',
	'type'     => 'switch',
	'section'  => 'learnpress_single',
	'tooltip'  => 'Check this box to hide/unhide Remaining time',
	'default'  => 1,
	'priority' => 15,
	'choices'  => array(
		true  => esc_html__( 'On', 'course-builder' ),
		false => esc_html__( 'Off', 'course-builder' ),
	),
) );

if ( class_exists( 'LP_Addon_Announcements_Preload' ) ) {
	$course_tabs         = apply_filters( 'thim_customize_course_tabs', array(
		'overview'      => esc_html__( 'Overview', 'course-builder' ),
		'curriculum'    => esc_html__( 'Curriculum', 'course-builder' ),
		'announcements' => esc_html__( 'Announcements', 'course-builder' ),
		'instructor'    => esc_html__( 'Instructors', 'course-builder' ),
		'students-list' => esc_html__( 'Student list', 'course-builder' ),
		'review'        => esc_html__( 'Reviews', 'course-builder' ),
		'faqs'          => esc_html__( 'Faqs', 'course-builder' ),
	) );
	$course_tabs_default = array(
		'tab-overview'      => esc_html__( 'Overview', 'course-builder' ),
		'tab-curriculum'    => esc_html__( 'Curriculum', 'course-builder' ),
		'tab-announcements' => esc_html__( 'Announcements', 'course-builder' ),
		'tab-instructor'    => esc_html__( 'Instructors', 'course-builder' ),
		'tab-students-list' => esc_html__( 'Student list', 'course-builder' ),
		'tab-reviews'       => esc_html__( 'Reviews', 'course-builder' ),
		'tab-faqs'          => esc_html__( 'Faqs', 'course-builder' ),
	);
} else {
	$course_tabs         = apply_filters( 'thim_customize_course_tabs', array(
		'overview'      => esc_html__( 'Overview', 'course-builder' ),
		'curriculum'    => esc_html__( 'Curriculum', 'course-builder' ),
		'instructor'    => esc_html__( 'Instructors', 'course-builder' ),
		'students-list' => esc_html__( 'Student list', 'course-builder' ),
		'review'        => esc_html__( 'Reviews', 'course-builder' ),
		'faqs'        => esc_html__( 'Faqs', 'course-builder' ),
	) );
	$course_tabs_default = array(
		'tab-overview'      => esc_html__( 'Overview', 'course-builder' ),
		'tab-curriculum'    => esc_html__( 'Curriculum', 'course-builder' ),
		'tab-instructor'    => esc_html__( 'Instructors', 'course-builder' ),
		'tab-students-list' => esc_html__( 'Student list', 'course-builder' ),
		'tab-reviews'       => esc_html__( 'Reviews', 'course-builder' ),
        'tab-faqs'          => esc_html__( 'Faqs', 'course-builder' ),
	);
}
// Tab Course
thim_customizer()->add_field(
	array(
		'id'       => 'group_tabs_course',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Sortable Tab Course', 'course-builder' ),
		'tooltip'  => esc_html__( 'Click on eye icons to show or hide buttons. Use drag and drop to change the position of tabs...', 'course-builder' ),
		'section'  => 'learnpress_single',
		'priority' => 50,
		'default'  => array(
			'overview',
			'curriculum',
			'instructor',
			'students-list',
			'review',
            'faqs',
		),
		'choices'  => $course_tabs,
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'default_tab_course',
		'type'     => 'select',
		'label'    => esc_html__( 'Select Tab Default', 'course-builder' ),
		'tooltip'  => esc_html__( 'Select tab you want set to default', 'course-builder' ),
		'section'  => 'learnpress_single',
		'priority' => 50,
		'choices'  => $course_tabs_default,
		'default'  => 'tab-curriculum',
	)
);