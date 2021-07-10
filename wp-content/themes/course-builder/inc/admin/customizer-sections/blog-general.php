<?php
/**
 * Section Blog General
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'blog_general',
		'panel'    => 'blog',
		'title'    => esc_html__( 'Settings', 'course-builder' ),
		'priority' => 10,
	)
);

// Blog Archive Group
thim_customizer()->add_group( array(
	'id'       => 'blog_archive_setting_group',
	'section'  => 'blog_general',
	'priority' => 10,
	'groups'   => array(
		array(
			'id'     => 'blog_archive_page_group',
			'label'  => esc_html__( 'Archive Page', 'course-builder' ),
			'fields' => array(
				//Blog Layout
				array(
					'type'     => 'select',
					'id'       => 'archive_post_layout',
					'label'    => esc_html__( 'Blog Layout Style', 'course-builder' ),
					'tooltip'  => esc_html__( 'Allows to choose layout style for blog archive page.', 'course-builder' ),
					'default'  => 'grid',
					'priority' => 10,
					'multiple' => 0,
					'choices'  => array(
						'grid' => esc_html__( 'Grid', 'course-builder' ),
						'list' => esc_html__( 'List', 'course-builder' ),

					),
				),
				array(
					'type'            => 'select',
					'id'              => 'archive_post_column',
					'label'           => esc_html__( 'Number of Grid Columns', 'course-builder' ),
					'tooltip'         => esc_html__( 'Allows to set the number of grid columns for blog posts if Grid style selected.', 'course-builder' ),
					'default'         => 1,
					'priority'        => 11,
					'multiple'        => 0,
					'choices'         => array(
						'1' => esc_html__( '1', 'course-builder' ),
						'2' => esc_html__( '2', 'course-builder' ),
						'3' => esc_html__( '3', 'course-builder' ),
						'4' => esc_html__( '4', 'course-builder' ),

					),
					'active_callback' => array(
						array(
							'setting'  => 'archive_post_layout',
							'operator' => '===',
							'value'    => 'grid',
						),
					),
				),

				// Turn On Excerpt
				array(
					'type'     => 'switch',
					'id'       => 'excerpt_archive_content_display',
					'label'    => esc_html__( 'Display Excerpt', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display blog posts Excerpt.', 'course-builder' ),
					'default'  => 0,
					'priority' => 21,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),


				// Excerpt Content
				array(
					'id'              => 'excerpt_archive_content',
					'type'            => 'slider',
					'label'           => esc_html__( 'Excerpt Length', 'course-builder' ),
					'tooltip'         => esc_html__( 'Choose the number of words you want to cut from the content to be the excerpt of search and archive', 'course-builder' ),
					'priority'        => 20,
					'default'         => 20,
					'choices'         => array(
						'min'  => '10',
						'max'  => '100',
						'step' => '5',
					),
					'active_callback' => array(
						array(
							'setting'  => 'excerpt_archive_content_display',
							'operator' => '==',
							'value'    => true,
						),
					),
				),

				// Turn On Meta tags
				array(
					'type'     => 'switch',
					'id'       => 'blog_archive_display_meta',
					'label'    => esc_html__( 'Display Post Meta', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display blog posts Meta on archive page.', 'course-builder' ),
					'default'  => 1,
					'priority' => 21,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),

				// Turn On Readmore
				array(
					'type'     => 'switch',
					'id'       => 'readmore_archive_content_display',
					'label'    => esc_html__( 'Display Read More', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display Read More button for blog posts.', 'course-builder' ),
					'default'  => 1,
					'priority' => 21,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),

				// Turn On Top Box
				array(
					'type'     => 'switch',
					'id'       => 'topbox_archive_content_display',
					'label'    => esc_html__( 'Display Top Box', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display Top Box.', 'course-builder' ),
					'default'  => 0,
					'priority' => 21,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),

				//Load More Style
				array(
					'type'     => 'select',
					'id'       => 'blog_archive_nav_style',
					'label'    => esc_html__( 'Blog Pagination', 'course-builder' ),
					'tooltip'  => esc_html__( 'Allows to choose pagination for blog archive page.', 'course-builder' ),
					'default'  => 'pagination',
					'priority' => 10,
					'multiple' => 0,
					'choices'  => array(
						'loadmore'   => esc_html__( 'Load More', 'course-builder' ),
						'pagination' => esc_html__( 'Pagination', 'course-builder' ),
					),
				),
			),
		),
	)
) );

// Blog Single Group
thim_customizer()->add_group( array(
	'id'       => 'blog_single_setting_group',
	'section'  => 'blog_general',
	'priority' => 20,
	'groups'   => array(
		array(
			'id'     => 'blog_single_page_group',
			'label'  => esc_html__( 'Single Page', 'course-builder' ),
			'fields' => array(

				// Turn On Navigation
				array(
					'type'     => 'switch',
					'id'       => 'blog_single_pagetitle',
					'label'    => esc_html__( 'Single Post Page Title', 'course-builder' ),
					'tooltip'  => esc_html__( 'Show/hide page title on all single post page', 'course-builder' ),
					'default'  => 0,
					'priority' => 25,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),

				// Show Feature Image
				array(
					'type'     => 'switch',
					'id'       => 'blog_single_feature_image',
					'label'    => esc_html__( 'Featured Image', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display single blog post featured image.', 'course-builder' ),
					'default'  => 1,
					'priority' => 10,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),
				// Turn On Navigation
				array(
					'type'     => 'switch',
					'id'       => 'blog_single_nav',
					'label'    => esc_html__( 'Navigation', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display single blog post navigation.', 'course-builder' ),
					'default'  => 1,
					'priority' => 25,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),
				// Turn On Author
				array(
					'type'     => 'switch',
					'id'       => 'blog_single_author',
					'label'    => esc_html__( 'Author', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display blog post author.', 'course-builder' ),
					'default'  => 0,
					'priority' => 25,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),

				// Turn On Comments
				array(
					'type'     => 'switch',
					'id'       => 'blog_single_comment',
					'label'    => esc_html__( 'Comments', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display blog post comments.', 'course-builder' ),
					'default'  => 1,
					'priority' => 20,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),
				// Turn On Related Post
				array(
					'type'     => 'switch',
					'id'       => 'blog_single_related_post',
					'label'    => esc_html__( 'Number of Related Posts', 'course-builder' ),
					'tooltip'  => esc_html__( 'Turn on to display related blog posts.', 'course-builder' ),
					'default'  => 0,
					'priority' => 30,
					'choices'  => array(
						true  => esc_html__( 'On', 'course-builder' ),
						false => esc_html__( 'Off', 'course-builder' ),
					),
				),
				// Select Post Numbers For Related Post
				array(
					'type'            => 'slider',
					'id'              => 'blog_single_related_post_number',
					'label'           => esc_html__( 'Numbers of Related Post', 'course-builder' ),
					'default'         => 3,
					'priority'        => 40,
					'choices'         => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
					'active_callback' => array(
						array(
							'setting'  => 'blog_single_related_post',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
			),
		),
	)
) );
