<?php
/*
    Plugin Name: LearnPress - Tabs
    Plugin URI: http://thimpress.com/learnpress
    Description: Tabs add-on for LearnPress. Allow add custom tab into course.
    Author: Khoapq
    Version: 0.1.0
    Author URI: http://thimpress.com
    Tags: learnpress, lms
    Text Domain: learnpress-tabs
    Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LP_ADDON_TABS_FILE', __FILE__ );
define( 'LP_ADDON_TABS_PATH', dirname( __FILE__ ) );


/**
 * Register metabox for Tabs
 */
add_filter( 'rwmb_meta_boxes', 'thim_register_metabox_tabs' );
function thim_register_metabox_tabs( $meta_boxes ) {
	$prefix       = 'thim_';
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Add Tabs', 'course-builder' ),
		'post_types' => 'lp_course',
		'fields'     => array(
			array(
				'id'          => $prefix . 'tabs',
				'type'        => 'group',
				'clone'       => true,
				'sort_clone'  => true,
				'collapsible' => true,
				'group_title' => esc_html__( 'Tab', 'course-builder' ),
				'fields'      => array(
					array(
						'id'        => 'display',
						'name'      => esc_html__( 'Visibility', 'course-builder' ),
						'type'      => 'select',
						'options'   => apply_filters( 'learpress_custom_tab_display',
							array(
								false        => esc_html__( 'Draft', 'course-builder' ),
								true         => esc_html__( 'Public', 'course-builder' ),
								'instructor' => esc_html__( 'Instructor', 'course-builder' ),
								'learning'   => esc_html__( 'Student enrolled', 'course-builder' ),
								'landing'    => esc_html__( 'Student NOT enroll', 'course-builder' ),
							)

						),
						'desc_none' => ''

					),
					array(
						'id'   => 'title',
						'type' => 'text',
						'name' => esc_html__( 'Title', 'course-builder' ),
					),
					array(
						'id'        => 'type',
						'name'      => esc_html__( 'Type', 'course-builder' ),
						'type'      => 'select',
						'options'   => array(
							'text' => 'Text',
							'post' => 'Post',
							'page' => 'Page',
						),
						'desc_none' => ''

					),
					array(
						'id'        => 'text',
						'name'      => esc_html__( 'Content', 'course-builder' ),
						'type'      => 'wysiwyg',
						'hidden'    => [ 'type', '!=', 'text' ],
						'desc_none' => ''

					),
					array(
						'id'         => 'post',
						'type'       => 'post',
						'name'       => esc_html__( 'Post', 'course-builder' ),
						'post_type'  => 'post',
						'field_type' => 'select_advanced',
						'hidden'     => [ 'type', '!=', 'post' ],
						'desc_none'  => '',
					),
					array(
						'id'         => 'page',
						'type'       => 'post',
						'name'       => esc_html__( 'Page', 'course-builder' ),
						'post_type'  => 'page',
						'field_type' => 'select_advanced',
						'hidden'     => [ 'type', '!=', 'page' ],
						'desc_none'  => '',
					),
				),
			),
		),
	);

	return $meta_boxes;
}


/**
 * Add Tabs to learning page.
 */

if ( ! function_exists( 'thim_course_tabs_content' ) ) {
	function thim_course_tabs_content( $tab ) {
		$arr = array();
		$course             = learn_press_get_course();
		$user               = learn_press_get_current_user();
		$theme_options_data = get_theme_mods();
		$group_tab          = isset( $theme_options_data['group_tabs_course'] ) ? $theme_options_data['group_tabs_course'] : array(
			'overview',
			'curriculum',
			'announcements',
			'instructor',
			'students-list',
			'review',
            'faqs'
		);

		//active tab
		$request_tab = ! empty( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : '';
		$has_active  = false;
		if ( $request_tab != '' ) {
			foreach ( $tab as $k => $v ) {
				$v['id'] = ! empty( $v['id'] ) ? $v['id'] : 'tab-' . $k;

				if ( $request_tab === $v['id'] ) {
					$v['current'] = true;
					$has_active   = $k;
				}
				$tab[ $k ] = $v;
			}
		} else {
			/**
			 * Active Curriculum tab if user has enrolled course
			 */
			if ( $course && $user->has_course_status( $course->get_id(), array(
					'enrolled',
					'finished'
				) ) && ! empty( $tab['curriculum'] ) && array_keys( $group_tab, "curriculum" )
			) {
				$tab['curriculum']['current'] = true;
				$has_active                        = 'curriculum';
			}
		}

		foreach ( $tab as $k => $v ) {
			switch ( $k ) {

				case 'overview':
					$new_prioty = array_keys( $group_tab, "overview" );
					if ( $new_prioty ) {
						$v['priority'] = $new_prioty[0];
						$arr[ $k ]     = $v;
					}

					break;
				case 'curriculum':
					$new_prioty = array_keys( $group_tab, "curriculum" );
					if ( $new_prioty ) {
						$v['priority'] = $new_prioty[0];
						$arr[ $k ]     = $v;
					}

					break;
				case 'announcements':
					$new_prioty = array_keys( $group_tab, "announcements" );
					if ( $new_prioty ) {
						$v['priority'] = $new_prioty[0];
						$arr[ $k ]     = $v;
					}

					break;
				case 'instructor':
					$new_prioty = array_keys( $group_tab, "instructor" );
					if ( $new_prioty ) {
						$v['priority'] = $new_prioty[0];
						$arr[ $k ]     = $v;
					}

					break;
				case 'students-list':
					$new_prioty = array_keys( $group_tab, "students-list" );
					if ( $new_prioty ) {
						$v['priority'] = $new_prioty[0];
						$arr[ $k ]     = $v;
					}

					break;
				case 'reviews':
					$new_prioty = array_keys( $group_tab, "review" );
					if ( $new_prioty ) {
						$v['priority'] = $new_prioty[0];
						$arr[ $k ]     = $v;
					}

					break;
                case 'faqs':
                    $new_prioty = array_keys( $group_tab, "faqs" );
                    if ( $new_prioty ) {
                        $v['priority'] = $new_prioty[0];
                        $arr[ $k ]     = $v;
                    }

                    break;
			}
		}

		return $arr;
	}
}
add_filter( 'learn-press/course-tabs', 'thim_course_tabs_content', 9999 );


add_filter( 'learn-press/course-tabs', 'thim_course_custom_tabs', 99999 );
function thim_course_custom_tabs( $tabs ) {
	//	$prefix = 'thim_';
	//  $group_values = rwmb_meta( $prefix . 'tabs' );
	$group_values = get_post_meta( get_the_ID(), 'thim_tabs', true );

	if ( ! empty( $group_values ) ) {
		foreach ( $group_values as $key => $group_value ) {
			$display = isset( $group_value['display'] ) ? $group_value['display'] : '';
			$title   = isset( $group_value['title'] ) ? $group_value['title'] : '';

			if ( ( $display !== '0' ) && $title ) {
				if ( $display !== 'landing' ) {
					$user_id      = get_current_user_id();
					$current_user = get_userdata( $user_id );
					$course       = learn_press_get_the_course();

					$course_author = $course->get_instructor()->get_id();
					if ( $display == 'instructor' ) {
						$id             = thim_is_new_learnpress( '3.0' ) ? $course->get_id() : $course->ID;
						$co_instructors = get_post_meta( $id, '_lp_co_teacher' );
						// if is author or co-instructor or administrator
						if ( $current_user ) {
							if ( $user_id == $course_author || in_array( $user_id, $co_instructors ) || in_array( 'administrator', $current_user->roles ) ) {
								$tabs[ 'tabs_' . $key ] = array(
									'title'    => $title,
									'priority' => 40 + $key,
									'tab'      => $group_value,
									'callback' => 'thim_course_custom_tab_callback'
								);
							}
						}
					} else {
						$tabs[ 'tabs_' . $key ] = array(
							'title'    => $title,
							'priority' => 40 + $key,
							'tab'      => $group_value,
							'callback' => 'thim_course_custom_tab_callback'
						);
					}
				}
			}
		}
	}

	return $tabs;
}

/**
 * Custom tab callback
 *
 * @param $key
 * @param $args
 */
function thim_course_custom_tab_callback( $key, $args ) {
	$tab     = $args['tab'];
	$type    = isset( $tab['type'] ) ? $tab['type'] : 'text';
	$content = '';
	switch ( $type ) {
		case 'post':
			$post_id = isset( $tab['post'] ) ? $tab['post'] : '';
			if ( $post_id ) {
				$content = get_post_field( 'post_content', $post_id );
			}
			break;
		case 'page':
			$post_id = isset( $tab['page'] ) ? $tab['page'] : '';
			if ( $post_id ) {
				$content = get_post_field( 'post_content', $post_id );
			}
			break;
		default:
			$content = isset( $tab['text'] ) ? $tab['text'] : '';
			break;
	}
	$args['tab_content'] = $content;
	learn_press_tabs_template( 'learning-tab.php', array( $args ) );
}

/**
 * Add custom tab to landing page.
 */
add_action( 'learn_press_content_landing_summary', 'thim_course_custom_tabs_landing', 61 );
add_action( 'learn-press/content-landing-summary', 'thim_course_custom_tabs_landing', 61 );
function thim_course_custom_tabs_landing() {
	$prefix = 'thim_';

	$group_values = rwmb_meta( $prefix . 'tabs' );
	if ( ! empty( $group_values ) ) {
		$id = 0;
		foreach ( $group_values as $key => $group_value ) {
			$display = isset( $group_value['display'] ) ? $group_value['display'] : '';
			$title   = isset( $group_value['title'] ) ? $group_value['title'] : '';
			if ( ( $display == '1' || $display == 'landing' ) && $title ) {
				$args    = $group_value;
				$type    = isset( $group_value['type'] ) ? $group_value['type'] : 'text';
				$content = '';
				switch ( $type ) {
					case 'post':
						$post_id = isset( $group_value['post'] ) ? $group_value['post'] : '';
						if ( $post_id ) {
							$content = get_post_field( 'post_content', $post_id );
						}
						break;
					case 'page':
						$post_id = isset( $group_value['page'] ) ? $group_value['page'] : '';
						if ( $post_id ) {
							$content = get_post_field( 'post_content', $post_id );
						}
						break;
					default:
						$content = isset( $group_value['text'] ) ? $group_value['text'] : '';
						break;
				}
				$args['tab_content'] = $content;
				?>

				<div class="custom-tab" id="tab-tabs_<?php echo $id; ?>">
					<h3 class="tab-title">
						<?php echo esc_html( $args['title'] ); ?>
					</h3>
					<div class="tab-content">
						<?php echo do_shortcode( $args['tab_content'] ); ?>
					</div>
				</div>

				<?php
				$id++;
			}
		}
	}
}


/**
 * Get template, allow overwrite
 *
 * @param      $name
 * @param null $args
 */
function learn_press_tabs_template( $name, $args = null ) {
	learn_press_get_template( $name, $args, learn_press_template_path() . '/addons/tabs/', LP_ADDON_TABS_PATH . '/templates/' );
}