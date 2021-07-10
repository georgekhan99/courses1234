<?php
/**
 * Wrapper Layout
 *
 */

/**
 * Thim wrapper layout
 *
 * @return string
 */
if ( !function_exists( 'thim_wrapper_layout' ) ) :
	function thim_wrapper_layout() {

		global $wp_query;
		$postid            = get_the_ID();
		$thim_options      = get_theme_mods();
		$wrapper_layout    = $using_custom_layout = $cat_ID = '';
		$wrapper_class_col = 'col-sm-12 col-md-9 flex-first';
		if ( get_post_type() == "product" ) {
			$prefix = 'woocommerce_';
		} elseif ( get_post_type() == "tp_event" ) {
			$prefix = 'event_';
		} elseif ( get_post_type() == "lpr_course" || get_post_type() == "lpr_quiz" || get_post_type() == "lp_course" || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
			$prefix = 'learnpress_';
		} elseif ( get_post_type() == "portfolio" ) {
			$prefix = 'portfolio_';
		} elseif ( get_post_type() == "lp_collection" ) {
			$prefix = 'collection_';
		} elseif ( get_post_type() == "forum" || get_post_type() == "topic" ) {
			$prefix = 'forums_';
		} else {
			if ( get_post_type() == "post" ) {
				$prefix = 'blog_';
			} else {
				$prefix = '';
			}
		}

		// get id category
//		$cat_obj = $wp_query->get_queried_object();
//		if ( isset( $cat_obj->term_id ) ) {
//			$cat_ID = $cat_obj->term_id;
//		}

		$using_custom_layout     = get_post_meta( $postid, 'thim_enable_custom_layout', true );
		$customize_custom_layout = get_post_meta( $postid, 'thim_custom_layout', true );

		//Get layout from customizer
		if ( is_page() ) {
			if ( isset( $thim_options['page_layout'] ) ) {
				$wrapper_layout = get_theme_mod( 'page_layout' );
			}

			// Get custom layout for page options ( metabox).
			if ( $using_custom_layout && $customize_custom_layout ) {
				$wrapper_layout = get_post_meta( $postid, 'thim_custom_layout', true );
			}

		} elseif ( is_single() ) {

			if ( isset( $thim_options['' . $prefix . 'single_layout'] ) ) {
				$wrapper_layout = get_theme_mod( '' . $prefix . 'single_layout' );
			}

			// Get custom layout for single post options ( meta-box).
			if ( $using_custom_layout && $customize_custom_layout ) {
				$wrapper_layout = get_post_meta( $postid, 'thim_custom_layout', true );
			}

			if ( is_singular( 'lp_course' ) ) {

				$course    = learn_press_get_the_course();
				$course_id = thim_is_new_learnpress( '3.0' ) ? $course->get_id() : $course->id;
				$user      = learn_press_get_current_user();
				if ( $user->has_course_status( $course_id, array(
						'enrolled',
						'finished'
					) ) || !$course->is_require_enrollment()
				) {
					//learning
					$wrapper_layout = 'no-sidebar';
				} else {
					//landing
					$layouts = get_theme_mod( 'learnpress_single_course_style', 1 );
					$layouts = isset( $_GET['layout'] ) ? $_GET['layout'] : $layouts;
					if ( $layouts == 2 ) {
						//landing & style 2
						$wrapper_layout = 'no-sidebar';
					} else {
						$wrapper_layout = get_theme_mod( 'learnpress_single_layout' );
					}
				}
			}

			if ( is_singular( 'forum' ) ) {
				$wrapper_layout = get_theme_mod( 'forums_single_layout' );
			}

			if ( thim_check_is_course_taxonomy() ) {
				if ( isset( $thim_options[$prefix . 'archive_layout'] ) ) {

					$wrapper_layout = $thim_options[$prefix . 'archive_layout'];
				}
			}


		} else {

			if ( isset( $thim_options[$prefix . 'archive_layout'] ) ) {

				$wrapper_layout = $thim_options[$prefix . 'archive_layout'];
			}
			// Get custom layout for category,... from category options.
			// Code a here.

		}


//		// Get layout for custom post type (testimonial, ourteam, ...) // Code a here.
//		if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
//			$wrapper_layout = 'no-sidebar';
//		}

		if ( !$using_custom_layout && !$customize_custom_layout ) {
			if ( function_exists( 'learn_press_is_profile' ) && learn_press_is_profile() ) {
				$wrapper_layout = 'no-sidebar';
			}
		}

		if ( isset( $_GET['layout'] ) ) {
			$wrapper_layout = trim( $_GET['layout'] );
		}

		// Get class layout
		if ( $wrapper_layout == 'no-sidebar' || $wrapper_layout == '1' || $wrapper_layout == '2' ) {
			$wrapper_class_col = "col-sm-12 full-width";
		}
		if ( $wrapper_layout == 'sidebar-left' ) {
			$wrapper_class_col = "col-sm-12 col-md-9 flex-last";
		}
		if ( $wrapper_layout == 'sidebar-right' ) {
			$wrapper_class_col = 'col-sm-12 col-md-9 flex-first';
		}
		if ( $wrapper_layout == 'full-sidebar' ) {
			$wrapper_class_col = 'col-sm-12 col-md-6 flex-unordered';
		}

		return $wrapper_class_col;
	}
endif;


add_action( 'thim_wrapper_loop_start', 'thim_wrapper_loop_start' );
/**
 * Get wrapper layout start
 *
 * @return string
 */
if ( !function_exists( 'thim_wrapper_loop_start' ) ) :
	function thim_wrapper_loop_start() {
		$class_no_padding = '';
		if ( get_post_type() == "product" ) {
			$prefix = 'woocommerce_';
		} elseif ( get_post_type() == "post" ) {
			$prefix = 'blog_';
		} elseif ( get_post_type() == "portfolio" ) {
			$prefix = 'portfolio_';
		} elseif ( get_post_type() == "tp_event" ) {
			$prefix = 'event_';
		} elseif ( get_post_type() == "lp_course" || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
			$prefix = 'learnpress_';
		} elseif ( get_post_type() == "lp_collection" ) {
			$prefix = 'collection_';
		} elseif ( get_post_type() == "forum" || get_post_type() == "topic" ) {
			$prefix = 'forums_';
		} else {
			$prefix = '';
		}


		if ( is_page() || is_single() ) {
			$mtb_no_padding = get_post_meta( get_the_ID(), 'thim_no_padding_content', true );
			if ( $mtb_no_padding ) {
				$class_no_padding = 'no-padding';
			}
		}
		$wrapper_class_col = thim_wrapper_layout();
		if ( is_404() ) {
			$wrapper_class_col = 'col-sm-12 full-width';
		}

		$container = 'container';
		if ( is_singular( 'lp_course' ) ) {
			$course    = learn_press_get_the_course();
			$course_id = thim_is_new_learnpress( '3.0' ) ? $course->get_id() : $course->id;
			$user      = learn_press_get_current_user();
			if ( $user->has_course_status( $course_id, array(
					'enrolled',
					'finished'
				) ) || !$course->is_require_enrollment()
			) {
				$container = '';
			}
		}

		echo '<div class="' . $container . ' site-content ' . $class_no_padding . '"><div class="row">';

		if ( $wrapper_class_col == 'col-sm-12 col-md-6 flex-unordered' ) {
			$postid = get_the_ID();
			if ( is_page() ) {
				$get_sidebar_left = get_theme_mod( 'page_layout_sidebar_left' );
				// get sidebar from MTB
				$sidebar_left = get_post_meta( $postid, 'thim_custom_sidebar_left', true );
				if ( $sidebar_left ) {
					$get_sidebar_left = get_post_meta( $postid, 'thim_custom_sidebar_left', true );
				}
			} elseif ( is_single() ) {
				$get_sidebar_left = get_theme_mod( '' . $prefix . 'single_layout_sidebar_left' );
				// get sidebar from MTB
				$sidebar_left = get_post_meta( $postid, 'thim_custom_sidebar_left', true );
				if ( $sidebar_left ) {
					$get_sidebar_left = get_post_meta( $postid, 'thim_custom_sidebar_left', true );
				}
			} else {
				$get_sidebar_left = get_theme_mod( '' . $prefix . 'archive_layout_sidebar_left' );
			}
			echo '<aside id="secondary-left" class="widget-area col-sm-12 col-md-3 sticky-sidebar sidebar-left">';
			dynamic_sidebar( $get_sidebar_left );
			echo '</aside>';
		}
		echo '<main id="main" class="site-main ' . $wrapper_class_col . '" >';
	}
endif;


add_action( 'thim_wrapper_loop_end', 'thim_wrapper_loop_end' );
/**
 * Get wrapper layout end
 *
 * @return string
 */
if ( !function_exists( 'thim_wrapper_loop_end' ) ) :
	function thim_wrapper_loop_end() {
		$postid = get_the_ID();
		if ( get_post_type() == "product" ) {
			$prefix = 'woocommerce_';
		} elseif ( get_post_type() == "post" ) {
			$prefix = 'blog_';
		} elseif ( get_post_type() == "tp_event" ) {
			$prefix = 'event_';
		} elseif ( get_post_type() == "lp_course" || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
			$prefix = 'learnpress_';
		} elseif ( get_post_type() == "portfolio" ) {
			$prefix = 'portfolio_';
		} elseif ( get_post_type() == "lp_collection" ) {
			$prefix = 'collection_';
		} elseif ( get_post_type() == "forum" || get_post_type() == "topic" ) {
			$prefix = 'forums_';
		} else {
			$prefix = '';
		}


		$wrapper_class_col = thim_wrapper_layout();
		if ( is_404() ) {
			$wrapper_class_col = 'col-sm-12 full-width';
		}
		echo '</main>';

		if ( $wrapper_class_col != 'col-sm-12 full-width' && $wrapper_class_col != 'col-sm-12 col-md-6 flex-unordered' ) {
			if ( get_post_type() == "product" ) {
				get_sidebar( 'shop' );
			} elseif ( get_post_type() == "lp_course" || get_post_type() == 'lp_quiz' || get_post_type() == 'lp_collection' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
				get_sidebar( 'courses' );
			} elseif ( get_post_type() == "tp_event" ) {
				get_sidebar( 'events' );
			} elseif ( function_exists( 'is_buddypress' ) && is_buddypress() ) {
				get_sidebar( 'buddypress' );
			} elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
				get_sidebar( 'forums' );
			} else {
				get_sidebar();
			}
		}

		if ( $wrapper_class_col == 'col-sm-12 col-md-6 flex-unordered' ) {
			if ( is_page() ) {
				$get_sidebar_right = get_theme_mod( 'page_layout_sidebar_right' );
				// get sidebar from MTB
				$sidebar_right = get_post_meta( $postid, 'thim_custom_sidebar_right', true );
				if ( $sidebar_right ) {
					$get_sidebar_right = get_post_meta( $postid, 'thim_custom_sidebar_right', true );
				}
			} elseif ( is_single() ) {
				$get_sidebar_right = get_theme_mod( '' . $prefix . 'single_layout_sidebar_right' );
				// get sidebar from MTB
				$sidebar_right = get_post_meta( $postid, 'thim_custom_sidebar_right', true );
				if ( $sidebar_right ) {
					$get_sidebar_right = get_post_meta( $postid, 'thim_custom_sidebar_right', true );
				}
			} else {
				$get_sidebar_right = get_theme_mod( '' . $prefix . 'archive_layout_sidebar_right' );
			}

			echo '<aside id="secondary-right" class="widget-area col-sm-12 col-md-3 sticky-sidebar">';
			dynamic_sidebar( $get_sidebar_right );
			echo '</aside>';
		}

		echo '</div></div>';
	}
endif;
