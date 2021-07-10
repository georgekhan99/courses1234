<?php
/**
 * Panel and Group Typography
 *
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'typography',
		'panel'    => 'general',
		'priority' => 60,
		'title'    => esc_html__( 'Typography', 'course-builder' ),
	)
);

// Body_Typography_Group
thim_customizer()->add_group( array(
	'id'       => 'body_typography',
	'section'  => 'typography',
	'priority' => 10,
	'groups'   => array(
		array(
			'id'     => 'body_group',
			'label'  => esc_html__( 'Body', 'course-builder' ),
			'fields' => array(
				array(
					'id'        => 'font_body',
					'label'     => esc_html__( 'Body Font', 'course-builder' ),
					'tooltip'   => esc_html__( 'Allows to change font properties for body element.', 'course-builder' ),
					'type'      => 'typography',
					'priority'  => 10,
					'default'   => array(
						'font-family'    => 'Roboto',
						'variant'        => '300',
						'font-size'      => '18px',
						'line-height'    => '1.25',
						'letter-spacing' => '0',
						'color'          => '#888888',
						'text-transform' => 'none',
                        'subsets'        => array( 'greek,greek-ext' ),
					),
					'transport' => 'postMessage',
					'js_vars'   => array(
						array(
							'choice'   => 'font-family',
							'element'  => 'body',
							'property' => 'font-family',
						),
						array(
							'choice'   => 'variant',
							'element'  => 'body',
							'property' => 'font-weight',
						),
						array(
							'choice'   => 'font-size',
							'element'  => 'body',
							'property' => 'font-size',
						),
						array(
							'choice'   => 'line-height',
							'element'  => 'body',
							'property' => 'line-height',
						),
						array(
							'choice'   => 'letter-spacing',
							'element'  => 'body',
							'property' => 'letter-spacing',
						),
						array(
							'choice'   => 'color',
							'element'  => 'body',
							'property' => 'color',
						),
						array(
							'choice'   => 'text-transform',
							'element'  => 'body',
							'property' => 'text-transform',
						),
					)
				),
			),
		),
	)
) );