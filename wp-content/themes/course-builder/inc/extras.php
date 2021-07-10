<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function thim_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$page_title = thim_page_title();
	if ( $page_title['show_text'] ) {
		$classes[] = 'pagetitle-show';
	} else {
		$classes[] = 'pagetitle-hide';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$classes[] = 'bg-type-' . get_theme_mod( 'background_boxed_type', 'color' );

	$classes[] = 'thim-body-' . get_theme_mod( 'thim_page_builder_chosen', 'visual_composer' );

	if ( get_theme_mod( 'enable_responsive', true ) ) {
		$classes[] = 'responsive';
	} else {
		$classes[] = 'disable-responsive';
	}

	if ( get_theme_mod( 'lp_login_popup', true ) && is_singular( 'lp_course' ) ) {
		$classes[] = 'lp_login_popup';
	}

	if ( get_theme_mod( 'event_login_popup', true ) && is_singular( 'tp_event' ) ) {
		$classes[] = 'event_login_popup';
	}

	if ( get_theme_mod( 'enable_box_shadow', true ) ) {
		$classes[] = 'box-shadow';
	}

	if ( get_theme_mod( 'auto_login' ) == false ) {
		$classes[] = 'auto-login';
	} else {
		$classes[] = 'dis-auto-login';
	}
	
	if ( get_theme_mod( 'thim_enable_mix_color', false ) == true ) {
		$classes[] = 'mix-colors';
	}

	if ( get_theme_mod( 'feature_rtl_support', false ) ) {
		$classes[] = 'rtl';
	} else {
		$classes[] = 'ltr';
	}

	if ( is_page() ) {
		$extra_class = get_post_meta( get_the_ID(), 'thim_extra_class', true );
		if ( $extra_class ) {
			$classes[] = $extra_class;
		}
	}

	if ( class_exists( 'LearnPress' ) ) {

//		if ( thim_is_new_learnpress( '3.0' ) ) {
//			$classes[] = 'learnpress-v3';
//		}

		if ( LP()->settings->get( 'buy_through_membership' ) == 'yes' ) {
			$buy_through_membership = true;
		} else {
			$buy_through_membership = false;
		}

		if ( $buy_through_membership ) {
			$classes[] = "buy-through-membership";
		}

		if ( is_singular( 'lp_course' ) ) {
			$course = LP_Global::course();
			if ( ! $course ) {
				return;
			}
			$is_course_in_membership = (bool) get_post_meta( $course->get_id(), '_lp_pmpro_levels', false );

			if ( $is_course_in_membership ) {
				$classes[] = "in-membership";
			}

			$classes[] = $course->is_free() ? 'course-free' : 'course-no-free';
		}

		$version = 'learnpress-v3';
 		$classes[] = $version;

	}

	$header_palette = get_theme_mod( 'header_palette', 'white' );
	switch ( $header_palette ) {
		case 'transparent':
			$classes[] = 'header-template-overlay';
			break;
		case 'white':
			$classes[] = 'header-template-default';
			break;
		default:
			if ( get_theme_mod( 'header_position', 'default' ) === 'default' ) {
				$classes[] = 'header-template-default';
			} else {
				$classes[] = 'header-template-overlay';
			}
			break;
	}

	return $classes;
}

add_filter( 'body_class', 'thim_body_classes' );

/**
 * Primary menu
 */
function thim_primary_menu() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'items_wrap'     => '%3$s'
		) );
	} else {
		wp_nav_menu( array(
			'theme_location' => '',
			'container'      => false,
			'items_wrap'     => '%3$s'
		) );
	}
}

/**
 * Display the classes for the #wrapper-container element.
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function thim_wrapper_container_class( $class = '' ) {
	// Separates classes with a single space, collates classes for body element
	echo 'class="' . join( ' ', thim_get_wrapper_container_class( $class ) ) . '"';
}

/**
 * Retrieve the classes for the #wrapper-container element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 *
 * @return array Array of classes.
 */
function thim_get_wrapper_container_class( $class = '' ) {
	$classes = array();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	/**
	 * Filter the list of CSS #wrapper-container classes
	 *
	 * @param array $classes An array of #wrapper-container classes.
	 * @param array $class An array of additional classes added to the #wrapper-container.
	 */
	$classes = apply_filters( 'thim_wrapper_container_class', $classes, $class );

	return array_unique( $classes );
}


/**
 * Adds custom classes to the array of #wrapper-container classes.
 *
 * @param array $classes Classes for the #wrapper-container element.
 *
 * @return array
 */
function thim_wrapper_container_classes( $classes ) {
	$classes[] = 'content-pusher';

	if ( get_theme_mod( 'box_content_layout' ) == 'boxed' ) {
		$classes[] = 'boxed-area';
	}

	if ( get_theme_mod( 'show_line_after_topbar', false ) == true ) {
		$classes[] = 'line-topbar';
	}

	if ( get_theme_mod( 'mobile_menu_position', 'creative-left' ) == 'creative-left' ) {
		$classes[] = 'creative-left';
	} else {
		$classes[] = 'creative-right';
	}

	$classes[] = 'bg-type-' . get_theme_mod( 'background_main_type', 'color' );

	return $classes;
}

add_filter( 'thim_wrapper_container_class', 'thim_wrapper_container_classes' );


/**
 * Add lang to html tag
 *
 * @return @string
 */
if ( ! function_exists( 'thim_language_attributes' ) ) {
	function thim_language_attributes() {
		echo 'lang="' . get_bloginfo( 'language' ) . '"';
	}

	add_filter( 'language_attributes', 'thim_language_attributes', 10 );
}


/**
 * Optimize: Remove Emoji scripts
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Optimize: script_version
 */
//if ( get_theme_mod( 'feature_remove_version', false ) ) {
//	function thim_optimize_remove_script_version( $src ) {
//		$parts = explode( '?ver', $src );
//
//		return $parts[0];
//	}
//
//	add_filter( 'script_loader_src', 'thim_optimize_remove_script_version', 15, 1 );
//	add_filter( 'style_loader_src', 'thim_optimize_remove_script_version', 15, 1 );
//}


/**
 * Support SSL (https)
 */
function thim_ssl_secure_url( $sources ) {
	$scheme = parse_url( site_url(), PHP_URL_SCHEME );
	if ( 'https' == $scheme ) {
		if ( stripos( $sources, 'http://' ) === 0 ) {
			$sources = 'https' . substr( $sources, 4 );
		}

		return $sources;
	}

	return $sources;
}

function thim_ssl_secure_image_srcset( $sources ) {
	$scheme = parse_url( site_url(), PHP_URL_SCHEME );
	if ( 'https' == $scheme ) {
		foreach ( $sources as &$source ) {
			if ( stripos( $source['url'], 'http://' ) === 0 ) {
				$source['url'] = 'https' . substr( $source['url'], 4 );
			}
		}

		return $sources;
	}

	return $sources;
}

add_filter( 'wp_calculate_image_srcset', 'thim_ssl_secure_image_srcset' );
add_filter( 'wp_get_attachment_url', 'thim_ssl_secure_url', 1000 );
add_filter( 'image_widget_image_url', 'thim_ssl_secure_url' );