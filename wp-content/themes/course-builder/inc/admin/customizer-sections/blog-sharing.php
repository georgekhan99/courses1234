<?php
/**
 * Section Sharing
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'blog_share',
		'panel'    => 'blog',
		'title'    => esc_html__( 'Social Share', 'course-builder' ),
		'priority' => 21,
	)
);


thim_customizer()->add_group( array(
	'id'       => 'blog_share_group',
	'section'  => 'blog_share',
	'priority' => 10,
	'groups'   => array(
		array(
			'id'     => 'blog_share_group_single',
			'label'  => esc_html__( 'Single', 'course-builder' ),
			'fields' => array(
				array(
					'id'       => 'blog_single_group_sharing',
					'type'     => 'sortable',
					'label'    => esc_html__( 'Sortable Buttons Sharing', 'course-builder' ),
					'tooltip'  => esc_html__( 'Click on eye icon to show or hide social icon. Drag and drop to change the order of social icons.', 'course-builder' ),
					'section'  => 'sharing',
					'priority' => 10,
					'default'  => array(
						'facebook',
						'twitter',
						'pinterest',
						'linkedin',
						'google'
					),
					'choices'  => array(
						'facebook'  => esc_html__( 'Facebook', 'course-builder' ),
						'twitter'   => esc_html__( 'Twitter', 'course-builder' ),
						'pinterest' => esc_html__( 'Pinterest', 'course-builder' ),
						'linkedin'  => esc_html__( 'Linkedin', 'course-builder' ),
						'google'    => esc_html__( 'Google', 'course-builder' ),
					),
				)
			),
		),
	)
) );