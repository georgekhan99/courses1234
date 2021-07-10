<?php
/**
 * Custom Functions
 */

/**
 * Check a plugin active
 *
 * @param $plugin_var
 *
 * @return bool
 */

/**
 * Display the link to course forum
 */
if ( ! function_exists( 'thim_course_forum_link' ) ) {
	function thim_course_forum_link() {
		if ( class_exists( 'bbPress' ) && class_exists( 'LP_Addon_bbPress' ) ) {
			LP_Addon_bbPress::instance()->forum_link();
		}
	}
}
function thim_plugin_active( $plugin_dir, $plugin_file = null ) {
	$plugin_file = $plugin_file ? $plugin_file : ( $plugin_dir . '.php' );
	$plugin      = $plugin_dir . '/' . $plugin_file;

	$active_plugins_network = get_site_option( 'active_sitewide_plugins' );

	if ( isset( $active_plugins_network[$plugin] ) ) {
		return true;
	}

	$active_plugins = get_option( 'active_plugins' );

	if ( in_array( $plugin, $active_plugins ) ) {
		return true;
	}

	return false;
}

/**
 * Get header layouts
 *
 * @return string CLASS for header layouts
 */
function thim_header_layout_class() {
	$thim_options = get_theme_mods();

	echo ' template-' . get_theme_mod( 'header_template', 'layout-1' );

	if ( get_theme_mod( 'show_sticky_menu', true ) ) {
		echo ' sticky-header';
	}

	if ( get_theme_mod( 'header_show_magic_line', false ) ) {
		echo ' header-magic-line';
	}
	if ( isset( $thim_options['header_retina_logo'] ) && $thim_options['header_retina_logo'] <> '' ) {
		echo ' has-retina-logo';
	}
	if ( isset( $thim_options['header_sticky_logo_retina'] ) && $thim_options['header_sticky_logo_retina'] <> '' ) {
		echo ' has-retina-logo-sticky';
	}

    if ( get_theme_mod( 'sticky_menu_style', 'same' ) === 'custom' ) {
        echo ' custom-sticky';
    }

	$header_palette = get_theme_mod( 'header_palette', 'white' );
	echo ' palette-' . $header_palette;
	switch ( $header_palette ) {
		case 'transparent':
			echo ' header-overlay';
			break;
		case 'white':
			echo ' header-default';
			break;
		default:
			if ( get_theme_mod( 'header_position', 'default' ) === 'default' ) {
				echo ' header-default';
			} else {
				echo ' header-overlay';
			}

			break;
	}
}

/**
 * Get Header Logo
 *
 * @return string
 */
if ( ! function_exists( 'thim_header_logo' ) ) {
	function thim_header_logo() {
		$thim_logo_retina        = get_theme_mod( 'header_retina_logo', false );
		$thim_sticky_logo_retina = get_theme_mod( 'header_sticky_logo_retina', false );
		$thim_logo               = get_theme_mod( 'header_logo', false );
		$sticky_logo             = get_theme_mod( 'header_sticky_logo', false );
		$thim_mobile_logo        = get_theme_mod( 'header_mobile_logo', false );
		$style                   = $data_logo = '';
		$logo_alt                = get_bloginfo( 'name' );
		if ( ! empty( $thim_logo ) ) {
			if ( is_numeric( $thim_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $thim_logo, 'full' );
				if ( get_post_meta( $thim_logo, '_wp_attachment_image_alt', true ) ) {
					$logo_alt = get_post_meta( $thim_logo, '_wp_attachment_image_alt', true );
				}
				if ( $logo_attachment ) {
					$src   = $logo_attachment[0];
					$style = 'width="' . $logo_attachment[1] . '" height="' . $logo_attachment[2] . '"';
				} else {
					// Default image
					$src = THIM_URI . "assets/images/logo.png";
				}
			} else {
				$src = $thim_logo;
			}
		} else {
			// Default image
			$src = THIM_URI . "assets/images/logo.png";
		}
		$src = thim_ssl_secure_url( $src );
		// thim logo retina
		if ( ! empty( $thim_logo_retina ) ) {
			if ( is_numeric( $thim_logo_retina ) ) {
				$thim_logo_retina_attachment = wp_get_attachment_image_src( $thim_logo_retina, 'full' );
				if ( $thim_logo_retina_attachment ) {
					$src_logo_retina = $thim_logo_retina_attachment[0];
				}
			} else {
				$src_logo_retina = $thim_logo_retina;
			}
			$data_logo .= ' data-retina="' . thim_ssl_secure_url( $src_logo_retina ) . '"';
		}
		// thim sticky logo retina
		if ( ! empty( $thim_sticky_logo_retina ) ) {
			if ( is_numeric( $thim_sticky_logo_retina ) ) {
				$thim_logo_sticky_retina_attachment = wp_get_attachment_image_src( $thim_sticky_logo_retina, 'full' );
				if ( $thim_logo_sticky_retina_attachment ) {
					$src_logo_sticky_retina = $thim_logo_sticky_retina_attachment[0];
				}
			} else {
				$src_logo_sticky_retina = $thim_sticky_logo_retina;
			}
			$data_logo .= ' data-sticky_retina="' . thim_ssl_secure_url( $src_logo_sticky_retina ) . '"';
		}
		// sticky logo
		if ( ! empty( $sticky_logo ) ) {
			if ( is_numeric( $sticky_logo ) ) {
				$sticky_logo_attachment = wp_get_attachment_image_src( $sticky_logo, 'full' );
				if ( $sticky_logo_attachment ) {
					$src_sticky = $sticky_logo_attachment[0];
				}
			} else {
				$src_sticky = $sticky_logo;
			}
			$data_logo .= ' data-sticky="' . thim_ssl_secure_url( $src_sticky ) . '"';
		}
		// mobile logo
		if ( ! empty( $thim_mobile_logo ) ) {
			if ( is_numeric( $thim_mobile_logo ) ) {
				$thim_mobile_logo_attachment = wp_get_attachment_image_src( $thim_mobile_logo, 'full' );
				if ( $thim_mobile_logo_attachment ) {
					$src_mobile_logo = $thim_mobile_logo_attachment[0];
				}
			} else {
				$src_mobile_logo = $thim_mobile_logo;
			}
			$data_logo .= ' data-mobile="' . thim_ssl_secure_url( $src_mobile_logo ) . '"';
			if ( wp_is_mobile() ) {
				$src = $src_mobile_logo;
			}
		}

		echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="thim-logo">';
		echo '<img src="' . $src . '" alt="' . esc_attr( $logo_alt ) . '" ' . $style . $data_logo . '>';
		echo '</a>';
	}
}
add_action( 'thim_header_logo', 'thim_header_logo' ); //TODO check for speed issue
//add_action( 'thim_popup_logo', 'thim_header_logo' );

/**
 * Get Header Sticky logo
 *
 * @return string
 */
if ( ! function_exists( 'thim_header_sticky_logo' ) ) {
	function thim_header_sticky_logo() {
		$site_title = esc_attr( get_bloginfo( 'name', 'display' ) );
		if ( get_theme_mod( 'header_sticky_logo' ) != '' ) {
			$thim_logo_stick_logo     = get_theme_mod( 'header_sticky_logo' );
			$thim_logo_stick_logo_src = $thim_logo_stick_logo; // For the default value
			if ( is_numeric( $thim_logo_stick_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $thim_logo_stick_logo, 'full' );
				if ( $logo_attachment ) {
					$thim_logo_stick_logo_src = $logo_attachment[0];
				} else {
					$thim_logo_stick_logo_src = THIM_URI . 'assets/images/logo.png';
				}
			}
			$thim_logo_size = @getimagesize( $thim_logo_stick_logo_src );
			$logo_size      = $thim_logo_size[3];

			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="sticky-logo">
					<img src="' . $thim_logo_stick_logo_src . '" alt="' . $site_title . '" ' . $logo_size . ' />';

			if ( get_theme_mod( 'header_sticky_logo_retina', false ) ) {
				$thim_retina_logo_src = get_theme_mod( 'header_sticky_logo_retina' );
				if ( is_numeric( $thim_retina_logo_src ) ) {
					$logo_attachment      = wp_get_attachment_image_src( $thim_retina_logo_src, 'full' );
					$thim_retina_logo_src = $logo_attachment[0];
				}

				$thim_logo_size = @getimagesize( $thim_retina_logo_src );
				$logo_size      = $thim_logo_size[3];

				echo '<img class="retina-logo-sticky" src="' . esc_url( $thim_retina_logo_src ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"  ' . $logo_size . '/>';
			}
			echo '</a>';

		} else {
			$thim_logo_stick_logo_src = THIM_URI . 'assets/images/logo.png';
			$thim_logo_size           = @getimagesize( $thim_logo_stick_logo_src );
			$logo_size                = $thim_logo_size[3];

			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="sticky-logo">
					<img src="' . $thim_logo_stick_logo_src . '" alt="' . $site_title . '" ' . $logo_size . ' /></a>';
		}
	}
}
//add_action( 'thim_header_sticky_logo', 'thim_header_sticky_logo' );

/**
 * Get Page Title Content For Single
 *
 * @return string HTML for Page title bar
 */
function thim_get_single_page_title_content() {
	$post_id = get_the_ID();

	if ( get_post_type( $post_id ) == 'post' ) {
		$categories = get_the_category();
	} elseif ( get_post_type( $post_id ) == 'attachment' ) {
		echo '<h2 class="title">' . esc_html__( 'Attachment', 'course-builder' ) . '</h2>';

		return;
	} else {// Custom post type
		$categories = get_the_terms( $post_id, 'taxonomy' );
	}
	if ( ! empty( $categories ) ) {
		echo '<h2 class="title">' . esc_html( $categories[0]->name ) . '</h2>';
	}
}

/**
 * Get Page Title Content For Date Format
 *
 * @return string HTML for Page title bar
 */
function thim_get_page_title_date() {
	if ( is_year() ) {
		echo '<h2 class="title">' . esc_html__( 'Year', 'course-builder' ) . '</h2>';
	} elseif ( is_month() ) {
		echo '<h2 class="title">' . esc_html__( 'Month', 'course-builder' ) . '</h2>';
	} elseif ( is_day() ) {
		echo '<h2 class="title">' . esc_html__( 'Day', 'course-builder' ) . '</h2>';
	}

	$date  = '';
	$day   = intval( get_query_var( 'day' ) );
	$month = intval( get_query_var( 'monthnum' ) );
	$year  = intval( get_query_var( 'year' ) );
	$m     = get_query_var( 'm' );

	if ( ! empty( $m ) ) {
		$year  = intval( substr( $m, 0, 4 ) );
		$month = intval( substr( $m, 4, 2 ) );
		$day   = substr( $m, 6, 2 );

		if ( strlen( $day ) > 1 ) {
			$day = intval( $day );
		} else {
			$day = 0;
		}
	}

	if ( $day > 0 ) {
		$date .= $day . ' ';
	}
	if ( $month > 0 ) {
		global $wp_locale;
		$date .= $wp_locale->get_month( $month ) . ' ';
	}
	$date .= $year;
	echo '<div class="description">' . esc_attr( $date ) . '</div>';
}

/**
 * Get Page Title Content
 *
 * @return string HTML for Page title bar
 */
if ( ! function_exists( 'thim_page_title_content' ) ) {
	function thim_page_title_content() {
		if ( is_front_page() ) {// Front page
			echo '<h2 class="title">' . get_bloginfo( 'name' ) . '</h2>';
			echo '<div class="description">' . get_bloginfo( 'description' ) . '</div>';
		} elseif ( is_home() ) {// Post page
			echo '<h2 class="title">' . esc_html__( 'Blog', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . get_bloginfo( 'description' ) . '</div>';
		} elseif ( is_page() ) {// Page
			echo '<h2 class="title">' . get_the_title() . '</h2>';
		} elseif ( is_single() ) {// Single
			thim_get_single_page_title_content();
		} elseif ( is_author() ) {// Author
			echo '<h2 class="title">' . esc_html__( 'Author', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . get_the_author() . '</div>';
		} elseif ( is_search() ) {// Search
			echo '<h2 class="title">' . esc_html__( 'Search', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . get_search_query() . '</div>';
		} elseif ( is_tag() ) {// Tag
			echo '<h2 class="title">' . esc_html__( 'Tag', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . single_tag_title( '', false ) . '</div>';
		} elseif ( is_category() ) {// Archive
			echo '<h2 class="title">' . esc_html__( 'Category', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . single_cat_title( '', false ) . '</div>';
		} elseif ( is_404() ) {
			echo '<h2 class="title">' . esc_html__( '404 Page', 'course-builder' ) . '</h2>';
		} elseif ( is_date() ) {
			thim_get_page_title_date();
		}
	}
}
add_action( 'thim_page_title_content', 'thim_page_title_content' );

/**
 * Get breadcrumb for page
 *
 * @return string
 */
function thim_get_breadcrumb_items_other() {
	global $author;
	$userdata   = get_userdata( $author );
	$categories = get_the_category();
	if ( is_front_page() ) { // Do not display on the homepage
		return;
	}
	if ( is_home() ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html__( 'Blog', 'course-builder' ) . '</span><meta itemprop="position" content="2"></li>';
	} else {
		if ( is_category() ) { // Category page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $categories[0]->cat_name ) . '</span><meta itemprop="position" content="2"></li>';
		} else {
			if ( is_tag() ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( single_term_title( '', false ) ) . '">' . esc_html( single_term_title( '', false ) ) . '</span><meta itemprop="position" content="2"></li>';
			} else {
				if ( is_year() ) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span><meta itemprop="position" content="2"></li>';
				} else {
					if ( is_author() ) { // Auhor archive
						echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( $userdata->display_name ) . '">' . esc_attr__( 'Author', 'course-builder' ) . ' ' . esc_html( $userdata->display_name ) . '</span><meta itemprop="position" content="2"></li>';
					} else {
						if ( get_query_var( 'paged' ) ) {
							echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Page', 'course-builder' ) . ' ' . get_query_var( 'paged' ) . '">' . esc_html__( 'Page', 'course-builder' ) . ' ' . esc_html( get_query_var( 'paged' ) ) . '</span><meta itemprop="position" content="2"></li>';
						} else {
							if ( is_search() ) {
								echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Search results for:', 'course-builder' ) . ' ' . esc_attr( get_search_query() ) . '">' . esc_html__( 'Search results for:', 'course-builder' ) . ' ' . esc_html( get_search_query() ) . '</span><meta itemprop="position" content="2"></li>';
							} elseif ( is_404() ) {
								echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( '404 Page', 'course-builder' ) . '">' . esc_html__( '404 Page', 'course-builder' ) . '</span><meta itemprop="position" content="2"></li>';
							} elseif ( is_post_type_archive() ) {
								echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . post_type_archive_title( '', false ) . '">' . post_type_archive_title( '', false ) . '</span><meta itemprop="position" content="2"></li>';
							}
						}
					}
				}
			}
		}
	}
}

/**
 * Get content breadcrumbs
 *
 * @return string
 */
if ( ! function_exists( 'thim_breadcrumbs' ) ) {
	function thim_breadcrumbs() {
		if ( function_exists( 'learn_press_is_profile' ) && learn_press_is_profile() ) {
			$user = learn_press_get_profile_user();

			if ( $user ) {
				$user_meta = get_user_meta( $user->ID );
				$user_meta = array_map(
					function ( $a ) {
						return $a[0];
					}, $user_meta
				);

				thim_get_user_socials( $user_meta );
			}

			return;
		}

		global $post;
		if ( is_front_page() ) { // Do not display on the homepage
			return;
		}
		$categories   = get_the_category();
		$thim_options = get_theme_mods();
		$icon         = '<i class="fa fa-angle-right" aria-hidden="true"></i>';

		// Build the breadcrums
		echo '<ul itemscope itemtype="https://schema.org/BreadcrumbList" id="breadcrumbs" class="breadcrumbs">';
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url() ) . '" title="' . esc_attr__( 'Home', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Home', 'course-builder' ) . '</span></a><meta itemprop="position" content="1"><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
		if ( is_single() ) { // Single post (Only display the first category)
			if ( isset( $categories[0] ) ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" title="' . esc_attr( $categories[0]->cat_name ) . '"><span itemprop="name">' . esc_html( $categories[0]->cat_name ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span><meta itemprop="position" content="2"></li>';
			}

			if ( get_post_type() === 'lp_course' ) {
				$terms = get_terms( 'course_category' ); // Get all terms of a taxonomy
				if ( $terms && ! is_wp_error( $terms ) ) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_category_link( $terms[0]->term_id ) ) . '" title="' . esc_attr( $terms[0]->name ) . '"><span itemprop="name">' . esc_html( $terms[0]->name ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span><meta itemprop="position" content="2"></li>';
				}
			}

			if ( get_post_type() === 'tp_event' ) {
				$terms = get_terms( 'tp_event_category' ); // Get all terms of a taxonomy
				if ( isset( $terms[0] ) && ! is_wp_error( $terms ) ) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_category_link( $terms[0]->term_id ) ) . '" title="' . esc_attr( $terms[0]->name ) . '"><span itemprop="name">' . esc_html( $terms[0]->name ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span><meta itemprop="position" content="2"></li>';
				} else {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'tp_event' ) ) . '" title="' . esc_attr__( 'Events', 'course-builder' ) . '"><span itemprop="name">' . esc_attr__( 'Events', 'course-builder' ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span><meta itemprop="position" content="2"></li>';
				}
			}

			if ( get_post_type() === 'portfolio' ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span><meta itemprop="position" content="2"></li>';
			}
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . get_the_title() . '</span><meta itemprop="position" content="3" /></li>';

		} else {
			if ( is_page() ) {
				// Standard page
				if ( $post->post_parent ) {
					$anc = get_post_ancestors( $post->ID );
					$anc = array_reverse( $anc );
					// Parent page loop
					foreach ( $anc as $ancestor ) {
						echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $ancestor ) ) . '" title="' . esc_attr( get_the_title( $ancestor ) ) . '"><span itemprop="name">' . esc_html( get_the_title( $ancestor ) ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span><meta itemprop="position" content="2"></li>';
					}
				}

				// Current page
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '"> ' . esc_html( get_the_title() ) . '</span><meta itemprop="position" content="2"></li>';
			} elseif ( is_day() ) {// Day archive
				// Year link
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></a><meta itemprop="position" content="2"><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
				// Month link
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></a><meta itemprop="position" content="3"><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
				// Day display
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'jS' ) ) . '"> ' . esc_html( get_the_time( 'jS' ) ) . ' ' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span><meta itemprop="position" content="4"></li>';

			} else {
				if ( is_month() ) {
					// Year link
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></a><meta itemprop="position" content="2"><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'M' ) ) . '">' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span><meta itemprop="position" content="3"></li>';
				}
			}
		}
		thim_get_breadcrumb_items_other();
		echo '</ul>';
	}
}

/**
 * Breadcrumb for LearnPress
 */
if ( ! function_exists( 'thim_learnpress_breadcrumb' ) ) {
	function thim_learnpress_breadcrumb() {

		// Do not display on the homepage
		if ( is_front_page() || is_404() ) {
			return;
		}

		// Get the query & post information
		global $post;
		$icon = '<span class="breadcrum-icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>';
		// Build the breadcrums
		echo '<ul itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs" class="breadcrumbs">';

		// Home page
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr__( 'Home', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Home', 'course-builder' ) . '</span></a><meta itemprop="position" content="1">' . $icon . '</li>';

		if ( is_single() ) {

			$categories = get_the_terms( $post, 'course_category' );

			if ( get_post_type() == 'lp_course' ) {
				// All courses
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_course' ) ) . '" title="' . esc_attr__( 'All courses', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'All courses', 'course-builder' ) . '</span></a><meta itemprop="position" content="2">' . $icon . '</li>';
			}
			if ( get_post_type() == 'lp_collection' ) {
				// All courses
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_collection' ) ) . '" title="' . esc_attr__( 'Collections', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Collections', 'course-builder' ) . '</span></a><meta itemprop="position" content="2">' . $icon . '</li>';
			} else {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( get_post_meta( $post->ID, '_lp_course', true ) ) ) . '" title="' . esc_attr( get_the_title( get_post_meta( $post->ID, '_lp_course', true ) ) ) . '"><span itemprop="name">' . esc_html( get_the_title( get_post_meta( $post->ID, '_lp_course', true ) ) ) . '</span></a><meta itemprop="position" content="2">' . $icon . '</li>';
			}

			// Single post (Only display the first category)
			if ( isset( $categories[0] ) ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $categories[0] ) ) . '" title="' . esc_attr( $categories[0]->name ) . '"><span itemprop="name">' . esc_html( $categories[0]->name ) . '</span></a><meta itemprop="position" content="2">' . $icon . '</li>';
			}
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span><meta itemprop="position" content="3"></li>';

		} else {
			if ( is_tax( 'course_category' ) || is_tax( 'course_tag' ) ) {
				// All courses
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_course' ) ) . '" title="' . esc_attr__( 'All courses', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'All courses', 'course-builder' ) . '</span></a><meta itemprop="position" content="2">' . $icon . '</li>';

				// Category page
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( single_term_title( '', false ) ) . '">' . esc_html( single_term_title( '', false ) ) . '</span><meta itemprop="position" content="3"></li>';
			} else {
				if ( ! empty( $_REQUEST['s'] ) && ! empty( $_REQUEST['ref'] ) && ( $_REQUEST['ref'] == 'course' ) ) {
					// All courses
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_course' ) ) . '" title="' . esc_attr__( 'All courses', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'All courses', 'course-builder' ) . '</span></a><meta itemprop="position" content="2">' . $icon . '</li>';

					// Search result
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Search results for:', 'course-builder' ) . ' ' . esc_attr( get_search_query() ) . '">' . esc_html__( 'Search results for:', 'course-builder' ) . ' ' . esc_html( get_search_query() ) . '</span><meta itemprop="position" content="3"></li>';
				} else {
					if ( get_post_type() == 'lp_collection' ) {
						// All courses
						echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_collection' ) ) . '" title="' . esc_attr__( 'Collections', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Collections', 'course-builder' ) . '</span></a><meta itemprop="position" content="2"></li>';
					} else {
						echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'All courses', 'course-builder' ) . '">' . esc_html__( 'All courses', 'course-builder' ) . '</span><meta itemprop="position" content="2"></li>';
					}
				}
			}
		}

		echo '</ul>';
	}
}

/**
 * Get list sidebars
 */
if ( ! function_exists( 'thim_get_list_sidebar' ) ) {
	function thim_get_list_sidebar() {
		global $wp_registered_sidebars;

		$sidebar_array = array();
		$dp_sidebars   = $wp_registered_sidebars;

		$sidebar_array[''] = esc_attr__( '-- Select Sidebar --', 'course-builder' );

		foreach ( $dp_sidebars as $sidebar ) {
			$sidebar_array[$sidebar['name']] = $sidebar['name'];
		}

		return $sidebar_array;
	}
}

/**
 * Turn on and get the back to top
 *
 * @return string HTML for the back to top
 */
if ( ! class_exists( 'thim_back_to_top' ) ) {
	function thim_back_to_top() {
		if ( get_theme_mod( 'feature_backtotop', true ) ) {
			?>
			<div id="back-to-top">
				<?php
				get_template_part( 'templates/footer/back-to-top' );
				?>
			</div>
			<?php
		}
	}
}
add_action( 'thim_space_body', 'thim_back_to_top', 10 );

/**
 * Switch footer layout
 *
 * @return string HTML footer layout
 */
if ( ! function_exists( 'thim_footer_layout' ) ) {
	function thim_footer_layout() {
		$template_name = 'templates/footer/' . get_theme_mod( 'footer_template', 'default' );
		get_template_part( $template_name );
	}
}

/**
 * Footer Widgets
 *
 * @return bool
 * @return string
 */
if ( ! function_exists( 'thim_footer_widgets' ) ) {
	function thim_footer_widgets() {
		$footer_style = get_theme_mod( 'footer_style' );
		$footer_col   = get_theme_mod( 'footer_columns' );
		$col          = 12 / get_theme_mod( 'footer_columns', 6 );
		for ( $i = 1; $i <= get_theme_mod( 'footer_columns', 4 ); $i ++ ): ?>
			<?php
			if ( get_theme_mod( 'footer_columns' ) == 5 ) {
				if ( $footer_style == 'style_new' ) {
					if ( $i == 1 ) {
						$col = '4';
					} else {
						$col = '2';
					}
				} else {
					if ( $i == 1 || $i == 5 ) {
						$col = '3';
					} else {
						$col = '2';
					}
				}
			}

			if ( get_theme_mod( 'footer_columns' ) == 4 ) {
				if ( $footer_style == 'style_kit' ) {
					if ( $i == 1 || $i == 4 ) {
						$col = '4';
					} else {
						$col = '2';
					}
				}
			}

			?>
			<?php if ( is_active_sidebar( 'footer-sidebar-' . $i ) ) { ?>
				<div
					class="footer-col footer-col<?php echo esc_attr( $footer_col ); ?> col-xs-12 col-md-<?php echo esc_attr( $col ); ?>">
					<?php dynamic_sidebar( 'footer-sidebar-' . $i ); ?>
				</div>
			<?php } ?>
		<?php endfor;
	}
}


/**
 * Footer After Main Widgets
 *
 * @return bool
 * @return string
 */

if ( ! function_exists( 'thim_footer_after_main_widgets' ) ) {
	function thim_footer_after_main_widgets() {
		if ( is_active_sidebar( 'after_main' ) ) {
			dynamic_sidebar( 'after_main' );
		}
	}
}


/**
 * Footer Sticky Widgets
 *
 * @return bool
 * @return string
 */
if ( ! function_exists( 'thim_footer_sticky_widgets' ) ) {
	function thim_footer_sticky_widgets() {
		if ( is_active_sidebar( 'footer_sticky' ) ) {
			dynamic_sidebar( 'footer_sticky' );
		}
	}
}

/**
 * Footer Copyright bar
 *
 * @return bool
 * @return string
 */
if ( ! function_exists( 'thim_copyright_bar' ) ) {
	function thim_copyright_bar() {
		if ( get_theme_mod( 'copyright_bar', true ) ) : ?>
			<div class="copyright-text">
				<?php
				$link_default   = sprintf( '&copy; 2017 <a href="%1$s" ref="nofollow">Course Builder</a> Theme. All rights reserved.', esc_url( 'https://wordpresslms.thimpress.com/' ) );
				$copyright_text = get_theme_mod( 'copyright_text', $link_default );
				echo wp_kses(
					$copyright_text, array(
						'a'      => array( 'href' => array() ),
						'br'     => array(),
						'strong' => array(),
						'li'     => array(),
						'img'    => array( 'src' => array() ),
						'ol'     => array(),
						'i'      => array(),
						'sub'    => array(),
						'sup'    => array()
					)
				);
				?>
			</div>
		<?php endif;
	}
}

/**
 * Footer menu
 *
 * @return bool
 * @return array
 */
if ( ! function_exists( 'thim_copyright_menu' ) ) {
	function thim_copyright_menu() {
		if ( get_theme_mod( 'copyright_menu', true ) ) :
			if ( has_nav_menu( 'copyright_menu' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'copyright_menu',
						'container'      => false,
						'items_wrap'     => '<ul id="copyright-menu" class="list-inline">%3$s</ul>',
						'depth'          => 1,
					)
				);
			}
		endif;
	}
}

/**
 * Theme Feature: RTL Support.
 *
 * @return @string
 */
if ( ! function_exists( 'thim_feature_rtl_support' ) ) {
	function thim_feature_rtl_support() {
		if ( get_theme_mod( 'feature_rtl_support', false ) ) {
			echo " dir=\"rtl\"";
		}
	}

	add_filter( 'language_attributes', 'thim_feature_rtl_support', 10 );
}


/**
 * Theme Feature: Open Graph insert doctype
 *
 * @param $output
 */
if ( ! function_exists( 'thim_doctype_opengraph' ) ) {
	function thim_doctype_opengraph( $output ) {
		if ( get_theme_mod( 'feature_open_graph_meta', true ) ) {
			return $output . ' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"';
		}
	}

	add_filter( 'language_attributes', 'thim_doctype_opengraph' );
}

/**
 * Theme Feature: Preload
 *
 * @return string HTML for preload
 */
if ( ! function_exists( 'thim_preloading' ) ) {
	function thim_preloading() {
		$preloading = get_theme_mod( 'theme_feature_preloading', false );
		if ( $preloading ) {

			echo '<div id="thim-preloading">';

			thim_loading_icon();

			echo '</div>';

		}
	}

	add_action( 'thim_before_body', 'thim_preloading', 10 );
}

/**
 * Theme Feature: loading icon
 *
 * @return string HTML for loading icon
 */
if ( ! function_exists( 'thim_loading_icon' ) ) {
	function thim_loading_icon() {
		$loading = get_theme_mod( 'theme_feature_loading', 'chasing-dots' );

		echo '<div class="thim-loading-icon">';

		switch ( $loading ) {
			case 'custom-image':
				$loading_image = get_theme_mod( 'theme_feature_loading_custom_image', false );
				if ( $loading_image ) {
					include locate_template( 'templates/features/loading/' . $loading . '.php' );
				}
				break;
			default:
				include locate_template( 'templates/features/loading/' . $loading . '.php' );
				break;
		}

		echo '</div>';
	}

}

/**
 * Theme Feature: Open Graph meta tag
 *
 * @param string
 */
if ( ! function_exists( 'thim_add_opengraph' ) ) {
	function thim_add_opengraph() {
		global $post;

		//check if post is object otherwise you're not in singular post
		if ( ! is_object( $post ) ) {
			return;
		}

		if ( get_theme_mod( 'feature_open_graph_meta', true ) ) {
			if ( is_single() ) {
				if ( has_post_thumbnail( $post->ID ) ) {
					$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
					$img_src = esc_attr( $img_src[0] );
				} else {
					$img_src = THIM_URI . 'assets/images/opengraph.png';
				}
				if ( $excerpt = $post->post_excerpt ) {
					$excerpt = strip_tags( $post->post_excerpt );
					$excerpt = str_replace( "", "'", $excerpt );
				} else {
					$excerpt = get_bloginfo( 'description' );
				}
				?>

				<meta property="og:title" content="<?php echo the_title(); ?>"/>
				<meta property="og:description" content="<?php echo esc_attr( $excerpt ); ?>"/>
				<meta property="og:type" content="article"/>
				<meta property="og:url" content="<?php echo the_permalink(); ?>"/>
				<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
				<meta property="og:image" content="<?php echo esc_attr( $img_src ); ?>"/>

				<?php
			} else {
				return;
			}
		}
	}

	add_action( 'wp_head', 'thim_add_opengraph', 10 );
}


/**
 * Theme Feature: Google theme color
 */
if ( ! function_exists( 'thim_google_theme_color' ) ) {
	function thim_google_theme_color() {
		if ( get_theme_mod( 'feature_google_theme', false ) ) { ?>
			<meta name="theme-color"
				  content="<?php echo esc_attr( get_theme_mod( 'feature_google_theme_color', '#333333' ) ) ?>">
			<?php
		}
	}

	add_action( 'wp_head', 'thim_google_theme_color', 10 );
}

/**
 * Responsive: enable or disable responsive
 *
 * @return string
 * @return bool
 */
if ( ! function_exists( 'thim_enable_responsive' ) ) {
	function thim_enable_responsive() {
		if ( get_theme_mod( 'enable_responsive', true ) ) {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		}
	}

	add_action( 'wp_head', 'thim_enable_responsive', 1 );
}


/**
 * Override ajax-loader contact form
 *
 * $return mixed
 */

function thim_wpcf7_ajax_loader() {
	return THIM_URI . 'assets/images/icons/ajax-loader.gif';
}

add_filter( 'wpcf7_ajax_loader', 'thim_wpcf7_ajax_loader' );


/**
 * aq_resize function fake.
 * Aq_Resize
 */
if ( ! class_exists( 'Aq_Resize' ) ) {
	function thim_aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
		return $url;
	}
}

/**
 * @param $id
 * @param $size
 * @param $type : default is post
 *
 * @return string
 */
if ( ! function_exists( 'thim_get_thumbnail' ) ) {
	function thim_get_thumbnail( $id, $size = 'thumbnail', $type = 'post', $link = true, $classes = '' ) {
		$width         = 0;
		$height        = 0;
		$attachment_id = $id;
		if ( $type === 'post' ) {
			$attachment_id = get_post_thumbnail_id( $id );
		}

		if ( $size != 'full' && ! in_array( $size, get_intermediate_image_sizes() ) ) {
			//custom size
			$thumbnail_size = explode( 'x', $size );
			$width          = $thumbnail_size[0];
			$height         = $thumbnail_size[1];
			//				$img_src        = thim_aq_resize( $src[0], $width, $height, true );
			$src = wp_get_attachment_image_src( $attachment_id, array( $width, $height ) );
			if ( $src ) {
				$img_src = $src[0];
			}
		} else {
			$src = wp_get_attachment_image_src( $attachment_id, $size );
			if ( $src ) {
				$img_src = $src[0];
				$width   = $src[1];
				$height  = $src[2];
			}
		}
		$html = '';
		if ( ! empty( $img_src ) ) {
			$html .= '<img ' . image_hwstring( $width, $height ) . ' src="' . esc_attr( $img_src ) . '" alt="' . get_the_title( $id ) . '" class="' . $classes . '">';
		} else {
			$html .= '<img src="' . esc_url( THIM_URI . 'assets/images/demo-image.jpg' ) . '" alt="" title="">';
		}

		if ( $link ) {
			$html .= '<a href="' . esc_url( get_permalink( $id ) ) . '" class="img-link"></a>';
		}

		return $html;
	}
}

/**
 * @param      $id
 * @param      $size
 */
if ( ! function_exists( 'thim_thumbnail' ) ) {
	function thim_thumbnail( $id, $size, $type = 'post', $link = true, $classes = '' ) {
		echo thim_get_thumbnail( $id, $size, $type, $link, $classes );
	}
}

function thim_page_title( $output_value = null ) {

	global $wp_query;
	$GLOBALS['post']      = @$wp_query->post;
	$thim_heading_top_src = $custom_title = $custom_description = $text_color = $sub_color = '';
	$main_bg_color        = get_theme_mod( 'page_title_background_color', 'rgba(0,0,0,0.6)' );
	$output_title         = $output_description = $output_overlay_css = $output_main_css = '';

	$output = array(
		'show_text'       => get_theme_mod( 'page_title_show_text', true ),
		'title'           => '',
		'description'     => '',
		'overlay_css'     => '',
		'main_css'        => '',
		'show_title'      => true,
		'show_sub_title'  => true,
		'show_breadcrumb' => get_theme_mod( 'show_breadcrumb', true ),
	);

	if ( function_exists( 'learn_press_is_profile' ) && ( learn_press_is_profile() == true ) ) {
		$output['layout']          = 'layout-1';
		$output['show_breadcrumb'] = false;
	} else {
		$output['layout'] = get_theme_mod( 'page_title_layout', 'layout-1' );
	}

	$cat_obj = $wp_query->get_queried_object();
	if ( isset( $cat_obj->term_id ) ) {
		$cat_ID = $cat_obj->term_id;
	} else {
		$cat_ID = "";
	}

	// CUSTOMIZE
	if ( get_theme_mod( 'page_title_custom_title' ) ) {
		$custom_title = get_theme_mod( 'page_title_custom_title' );
	}

	if ( get_theme_mod( 'page_title_custom_description' ) ) {
		$custom_description = get_theme_mod( 'page_title_custom_description' );
	}

	$thim_heading_top_src = THIM_URI . "assets/images/page-title/bg.jpg";
	if ( get_theme_mod( 'page_title_background_image' ) ) {
		$thim_heading_top_img = get_theme_mod( 'page_title_background_image' );

		if ( is_post_type_archive( 'lp_collection' ) && get_theme_mod( 'page_title_collections_archive_background_image' ) ) {
			$thim_heading_top_img = get_theme_mod( 'page_title_collections_archive_background_image' );
		}

		if ( is_post_type_archive( 'product' ) && get_theme_mod( 'page_title_product_background_image' ) ) {
			$thim_heading_top_img = get_theme_mod( 'page_title_product_background_image' );
		}

		if ( is_post_type_archive( 'lp_course' ) && get_theme_mod( 'page_title_course_archive_background_image' ) ) {
			$thim_heading_top_img = get_theme_mod( 'page_title_course_archive_background_image' );
		}

		if ( is_post_type_archive( 'portfolio' ) && get_theme_mod( 'page_title_portfolio_archive_background_image' ) ) {
			$thim_heading_top_img = get_theme_mod( 'page_title_portfolio_archive_background_image' );
		}

		if ( is_post_type_archive( 'tp_event' ) && get_theme_mod( 'page_title_event_archive_background_image' ) ) {
			$thim_heading_top_img = get_theme_mod( 'page_title_event_archive_background_image' );
		}

		if ( ( get_post_type() == 'forum' || get_post_type() == 'topic' ) && ( is_archive() || is_category() ) ) {
			$thim_heading_top_img = get_theme_mod( 'page_title_forum_archive_background_image' );
		}

		if ( is_404() ) {
			$thim_heading_top_img = get_theme_mod( 'page_title_404_background_image' );
		}

		$thim_heading_top_src = $thim_heading_top_img; // For the default value

		if ( is_numeric( $thim_heading_top_img ) ) {
			$thim_heading_top_attachment = wp_get_attachment_image_src( $thim_heading_top_img, 'full' );
			$thim_heading_top_src        = $thim_heading_top_attachment[0];
		}
	}


	if ( is_singular( 'post' ) ) {
		$output['show_text'] = get_theme_mod( 'blog_single_pagetitle', true );
	}

	//CUSTOM METABOX
	$postid = get_queried_object_id();

	if ( is_archive() || is_category() ) {
		$using_custom_heading = get_term_meta( $postid, 'thim_enable_custom_title', true );
	} else {
		$using_custom_heading = get_post_meta( $postid, 'thim_enable_custom_title', true );
	}

	// Hide page title in learning course
	if ( is_singular( 'lp_course' ) ) {
		if ( function_exists( 'thim_is_learning' ) && thim_is_learning() ) {
			$output['show_text']       = false;
			$output['show_title']      = false;
			$output['show_breadcrumb'] = false;
		}
	}

	if ( is_singular( 'lp_collection' ) ) {
		$output['show_text']       = true;
		$output['show_title']      = true;
		$output['show_breadcrumb'] = true;
	}

	if ( $using_custom_heading ) {
		if ( is_archive() || is_category() ) {
			$custom_background         = get_term_meta( $postid, 'thim_group_custom_title_bg_img', true );
			$custom_background_overlay = get_term_meta( $postid, 'thim_group_custom_title_bg_color', true );

			$custom_title_hide_page_title  = get_term_meta( $postid, 'thim_group_custom_title_hide_page_title', true );
			$custom_title_display_title    = get_term_meta( $postid, 'thim_group_custom_title_hide_title', true );
			$custom_title                  = get_term_meta( $postid, 'thim_group_custom_title_new_title', true );
			$custom_description            = get_term_meta( $postid, 'thim_group_custom_title_custom_sub_title', true );
			$custom_title_hide_sub_title   = get_term_meta( $postid, 'thim_group_custom_title_hide_sub_title', true );
			$custom_title_hide_breadcrumbs = get_term_meta( $postid, 'thim_group_custom_title_hide_breadcrumbs', true );
			$custom_layout                 = get_term_meta( $postid, 'thim_group_custom_title_layout', true );

		} else {
			$custom_background         = get_post_meta( $postid, 'thim_group_custom_title_bg_img', true );
			$custom_background_overlay = get_post_meta( $postid, 'thim_group_custom_title_bg_color', true );

			$custom_title_hide_page_title  = get_post_meta( $postid, 'thim_group_custom_title_hide_page_title', true );
			$custom_title_display_title    = get_post_meta( $postid, 'thim_group_custom_title_hide_title', true );
			$custom_title                  = get_post_meta( $postid, 'thim_group_custom_title_new_title', true );
			$custom_description            = get_post_meta( $postid, 'thim_group_custom_title_custom_sub_title', true );
			$custom_title_hide_sub_title   = get_post_meta( $postid, 'thim_group_custom_title_hide_sub_title', true );
			$custom_title_hide_breadcrumbs = get_post_meta( $postid, 'thim_group_custom_title_hide_breadcrumbs', true );
			$custom_layout                 = get_post_meta( $postid, 'thim_group_custom_title_layout', true );
		}

		if ( $custom_title_hide_page_title ) {
			$output['show_text'] = false;
		}
		if ( $custom_layout ) {
			$output['layout'] = $custom_layout;
		}
		if ( $custom_title_display_title ) {
			$output['show_title'] = false;
		}
		if ( $custom_title_hide_sub_title ) {
			$output['show_sub_title'] = false;
		}
		if ( $custom_title_hide_breadcrumbs ) {
			$output['show_breadcrumb'] = false;
		}

		if ( $custom_background != '' ) {
			if ( is_archive() ) {
				$thim_heading_top_src = $custom_background['url'];
			} else {
				$thim_heading_top_img        = (int) $custom_background;
				$thim_heading_top_attachment = wp_get_attachment_image_src( $thim_heading_top_img, 'full' );
				$thim_heading_top_src        = $thim_heading_top_attachment[0];
			}

		}
		$main_bg_color = $custom_background_overlay;
	}

	// STYLE CSS
	$c_css_style = $overlay_css_style = $title_css_style = $title_css = '';
	$c_css_style .= ( $thim_heading_top_src != '' ) ? 'background-image:url(' . $thim_heading_top_src . ');' : '';

	$title_css_style .= ( $text_color != '' ) ? 'color: ' . $text_color . ';' : '';
	$c_css_sub_color = ( $sub_color != '' ) ? 'style="color:' . $sub_color . '"' : '';

	$title_css       = ( $title_css_style != '' ) ? 'style="' . $title_css_style . '"' : '';
	$output_main_css = ( $c_css_style != '' ) ? 'style="' . $c_css_style . '"' : '';

	if ( $main_bg_color ) {
		$overlay_css_style .= 'background-color: ' . $main_bg_color . ';';
	}

	$output_overlay_css = ( $overlay_css_style != '' ) ? 'style="' . $overlay_css_style . '"' : '';

	if ( is_single() ) {
		$typography = 'h1 ' . $title_css;
	} else {
		$typography = 'h1 ' . $title_css;
	}

	if ( ( get_post_type() == "product" ) ) {
		if ( is_post_type_archive( 'product' ) ) {
			$output['show_breadcrumb'] = get_theme_mod( 'product_show_breadcrumb', true );
			$output['show_text']       = get_theme_mod( 'product_page_title_show_text', true );
			$output['layout']          = get_theme_mod( 'product_page_title_layout', 'layout-1' );

			if ( get_theme_mod( 'product_page_title_custom_description' ) ) {
				$custom_description = get_theme_mod( 'product_page_title_custom_description' );
			}
		}
		$output_title       .= '<' . $typography . '>' . woocommerce_page_title( false );
		$output_title       .= '</' . $typography . '>';
		$output_description .= ( $custom_description != '' ) ? '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>' : '';
	} elseif ( ( is_category() || is_archive() || is_search() || is_404() ) ) {
		$output['show_title']      = true;
		$output['show_breadcrumb'] = true;

		if ( is_post_type_archive( 'lp_collection' ) ) {
			$output['show_breadcrumb'] = get_theme_mod( 'collections_show_breadcrumb', true );
			$output['show_text']       = get_theme_mod( 'collections_page_title_show_text', true );
			$output['layout']          = get_theme_mod( 'collections_page_title_layout', 'layout-1' );
			if ( get_theme_mod( 'collections_page_title_custom_title' ) ) {
				$custom_title = get_theme_mod( 'collections_page_title_custom_title' );
			}
			if ( get_theme_mod( 'collections_page_title_custom_description' ) ) {
				$custom_description = get_theme_mod( 'collections_page_title_custom_description' );
			}
		}

		if ( is_post_type_archive( 'lp_course' ) ) {
			$output['show_breadcrumb'] = get_theme_mod( 'course_show_breadcrumb', true );
			$output['show_text']       = get_theme_mod( 'course_page_title_show_text', true );
			$output['layout']          = get_theme_mod( 'course_page_title_layout', 'layout-1' );
			if ( get_theme_mod( 'course_page_title_custom_title' ) ) {
				$custom_title = get_theme_mod( 'course_page_title_custom_title' );
			}
			if ( get_theme_mod( 'course_page_title_custom_description' ) ) {
				$custom_description = get_theme_mod( 'course_page_title_custom_description' );
			}
		}

		if ( is_post_type_archive( 'portfolio' ) ) {
			$output['show_breadcrumb'] = get_theme_mod( 'portfolio_show_breadcrumb', true );
			$output['show_text']       = get_theme_mod( 'portfolio_page_title_show_text', true );
			$output['layout']          = get_theme_mod( 'portfolio_page_title_layout', 'layout-1' );
			if ( get_theme_mod( 'portfolio_page_title_custom_title' ) ) {
				$custom_title = get_theme_mod( 'portfolio_page_title_custom_title' );
			}
			if ( get_theme_mod( 'portfolio_page_title_custom_description' ) ) {
				$custom_description = get_theme_mod( 'portfolio_page_title_custom_description' );
			}
		}

		if ( is_post_type_archive( 'tp_event' ) ) {
			$output['show_breadcrumb'] = get_theme_mod( 'event_show_breadcrumb', true );
			$output['show_text']       = get_theme_mod( 'event_page_title_show_text', true );
			$output['layout']          = get_theme_mod( 'event_page_title_layout', 'layout-1' );
			if ( get_theme_mod( 'event_page_title_custom_title' ) ) {
				$custom_title = get_theme_mod( 'event_page_title_custom_title' );
			}
			if ( get_theme_mod( 'event_page_title_custom_description' ) ) {
				$custom_description = get_theme_mod( 'event_page_title_custom_description' );
			}
		}

		if ( get_post_type() == "forum" ) {
			$output['show_breadcrumb'] = get_theme_mod( 'forums_show_breadcrumb', true );
			$output['show_text']       = get_theme_mod( 'forums_page_title_show_text', true );
			$output['layout']          = get_theme_mod( 'forums_page_title_layout', 'layout-1' );
			if ( get_theme_mod( 'forums_page_title_custom_title' ) ) {
				$custom_title = get_theme_mod( 'forums_page_title_custom_title' );
			}

			if ( get_theme_mod( 'forums_page_title_custom_description' ) ) {
				$custom_description = get_theme_mod( 'forums_page_title_custom_description' );
			}
		}

		if ( is_404() ) {
			$output['show_breadcrumb'] = get_theme_mod( '404_show_breadcrumb', true );
			$output['show_text']       = get_theme_mod( '404_page_title_show_text', true );
			$output['layout']          = get_theme_mod( '404_page_title_layout', 'layout-1' );
			if ( get_theme_mod( '404_page_title_custom_title' ) ) {
				$custom_title = get_theme_mod( '404_page_title_custom_title' );
			}
			if ( get_theme_mod( '404_page_title_custom_description' ) ) {
				$custom_description = get_theme_mod( '404_page_title_custom_description' );
			}
		}

		$output_title .= '<' . $typography . '>';
		$output_title .= ( trim( $custom_title ) != '' ) ? $custom_title : thim_archive_title();
		$output_title .= '</' . $typography . '>';

		$custom_description = category_description( $cat_ID ) ? category_description( $cat_ID ) : $custom_description;
		$output_description .= '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>';

	} elseif ( is_page() || is_single() ) {
		if ( is_single() ) {
			$single_title = get_the_title( get_the_ID() );
			$output_title .= '<' . $typography . '>' . $single_title;
			$output_title .= '</' . $typography . '>';
			if ( get_post_type() == "post" ) {
				if ( $custom_title ) {
					$single_title = $custom_title;
				} else {
					$single_title = esc_html__( 'Blog', 'course-builder' );
				}
				$output_title = '<' . $typography . '>' . $single_title;
				$output_title .= '</' . $typography . '>';
			}
			if ( get_post_type() == "our_team" ) {
				$output_title = '<' . $typography . '>' . esc_html__( 'Our Team', 'course-builder' );
				$output_title .= '</' . $typography . '>';
			}
			if ( get_post_type() == "portfolio" ) {
				if ( $custom_title ) {
					$single_title = $custom_title;
				} else {
					$single_title = esc_html__( 'Portfolio', 'course-builder' );
				}
				$output_title = '<' . $typography . '>' . $single_title;
				$output_title .= '</' . $typography . '>';
			}
			if ( get_post_type() == "lp_course" || get_post_type() == "lp_collection" ) {

				$excerpt_content = $wp_query->queried_object->post_excerpt;

				if ( get_post_type() == "lp_collection" ) {
					$output_title = '<' . $typography . '>' . get_the_title();
					$output_title .= '</' . $typography . '>';

					if ( $excerpt_content ) {
						$custom_description = $excerpt_content;
					}
				}

				if ( get_post_type() == "lp_course" ) {

					$single_layout = isset( $_GET['layout'] ) ? $_GET['layout'] : get_theme_mod( 'learnpress_single_course_style', 1 );

					if ( $using_custom_heading ) {
						$custom_title        = get_post_meta( $postid, 'thim_group_custom_title_new_title', true );
						$custom_descriptions = get_post_meta( $postid, 'thim_group_custom_title_custom_sub_title', true );

						$output_title = '<' . $typography . '>' . $custom_title;
						$output_title .= '</' . $typography . '>';

						$custom_description = $custom_descriptions;

					} else {
						$output_title = '<' . $typography . '>' . get_the_title();
						$output_title .= '</' . $typography . '>';

						if ( $excerpt_content ) {
							$custom_description = $excerpt_content;
						} else {
							$custom_description = '';
						}
					}


					if ( $single_layout == 1 ) {
						$course = LP()->global['course'];

						if ( learn_press_is_enrolled_course() ) {
							return;
						}

						$custom_description .= '<div class="price">';

						ob_start();
						learn_press_get_template( 'single-course/price.php' );
						$html_price = ob_get_contents();
						ob_end_clean();

						$custom_description .= $html_price;

						$custom_description .= '</div>';
					}
				}

			}
			if ( get_post_type() == "tp_event" ) {
				if ( $custom_title ) {
					$single_title = $custom_title;
				} else {
					$single_title = esc_html__( 'Event', 'course-builder' );
				}
				$output_title = '<' . $typography . '>' . $single_title;
				$output_title .= '</' . $typography . '>';
			}

			$output_description .= ( $custom_description != '' ) ? '<div class="banner-description" ' . $c_css_sub_color . '>' . $custom_description . '</div>' : '';

		} else {
			$output_title       = '<' . $typography . '>';
			$output_title       .= ( trim( $custom_title ) != '' ) ? $custom_title : get_the_title();
			$output_title       .= '</' . $typography . '>';
			$output_description .= ( $custom_description != '' ) ? '<div class="banner-description" ' . $c_css_sub_color . '>' . $custom_description . '</div>' : '';


		}
	} elseif ( is_front_page() || is_home() ) {
		$output_title       = '<h1>';
		$output_title       .= ( trim( $custom_title ) != '' ) ? $custom_title : esc_html__( 'Blog', 'course-builder' );
		$output_title       .= '</h1>';
		$output_description .= ( $custom_description != '' ) ? '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>' : '';
	} else {
		$output_title       = '<' . $typography . '>';
		$output_title       .= ( trim( $custom_title ) != '' ) ? $custom_title : get_the_title( get_the_ID() );
		$output_title       .= '</' . $typography . '>';
		$output_description .= ( $custom_description != '' ) ? '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>' : '';
	}

	// Custom title MB

	$output['title']       = $output_title;
	$output['description'] = $output_description;
	$output['overlay_css'] = $output_overlay_css;
	$output['main_css']    = $output_main_css;

	if ( ( $output['show_text'] == false ) && ( $output_overlay_css == '' ) && ( $output_main_css == '' ) ) {
		$output['show_title'] = false;
	}

	if ( $output_value ) {
		return $output[$output_value];
	} else {
		return $output;
	}
}

/**
 * Check new version of LearnPress
 *
 * @return mixed
 */
if ( ! function_exists( 'thim_is_new_learnpress' ) ) {
	function thim_is_new_learnpress( $version ) {
		return version_compare( LEARNPRESS_VERSION, $version, '>=' );
	}
}

/**
 * Filter redirect plugin tp chameleon
 */
if ( ! function_exists( 'thim_tp_chameleon_redirect' ) ) {
	function thim_tp_chameleon_redirect( $option ) {
		if ( ( ! is_admin() && ! is_home() && ! is_front_page() ) || is_customize_preview() ) {
			return false;
		} else {
			return $option;
		}
	}
}
add_filter( 'tp_chameleon_redirect_iframe', 'thim_tp_chameleon_redirect' );

/**
 * Filter image all-demo tp-chameleon
 */
if ( ! function_exists( 'thim_override_demo_image_tp_chameleon' ) ) {
	function thim_override_demo_image_tp_chameleon() {
		return THIM_URI . 'inc/admin/all-demo.png';
	}
}
add_filter( 'tp_chameleon_get_image_sprite_demos', 'thim_override_demo_image_tp_chameleon' );


/**
 * Filter demos path
 */
function thim_filter_site_demos( $demo_datas ) {
	$demo_data_file_path = get_template_directory() . '/inc/data/demos.php';
	if ( is_file( $demo_data_file_path ) ) {
		require $demo_data_file_path;
	}

	return $demo_datas;
}

add_filter( 'tp_chameleon_get_site_demos', 'thim_filter_site_demos' );

/**
 * Check is course
 */
if ( ! function_exists( 'thim_check_is_course' ) ) {
	function thim_check_is_course() {
		if ( function_exists( 'learn_press_is_courses' ) && learn_press_is_courses() ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Check is course taxonomy
 */
if ( ! function_exists( 'thim_check_is_course_taxonomy' ) ) {
	function thim_check_is_course_taxonomy() {
		if ( function_exists( 'learn_press_is_course_taxonomy' ) && learn_press_is_course_taxonomy() ) {
			return true;
		} else {
			return false;
		}
	}
}


//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter( 'pre_user_description', 'wp_filter_kses' );

//add sanitization for WordPress posts
remove_filter( 'pre_user_description', 'wp_filter_post_kses', 100 );

// Filter html tags biographical user Info
add_filter( 'insert_user_meta', 'thim_insert_description_user_meta', 10, 3 );
function thim_insert_description_user_meta( $meta, $user, $update ) {
	if ( ! empty( $_REQUEST['description'] ) && array_key_exists( 'description', $meta ) ) {
		$meta['description'] = preg_replace( '~</?(script|iframe|form)>~', '', $_REQUEST['description'] );
	}

	return $meta;
}


/**
 * Print ajax
 *
 * @return string
 */
add_action( 'wp_head', 'thim_lazy_ajax', 1000 );
function thim_lazy_ajax() {
	?>
	<script type="text/javascript">
		if (typeof ajaxurl === 'undefined') {
			/* <![CDATA[ */
			var ajaxurl = "<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>";
			/* ]]> */
		}
	</script>
	<?php
}

if ( ! function_exists( 'thim_get_default_post_thumbnail' ) ) {
	function thim_get_default_post_thumbnail( $post_id, $size, $style ) {
		$thumb = get_the_post_thumbnail( $post_id, $size );
		if ( empty( $thumb ) ) {
			return '';
		}

		if ( ! is_single() ) {
			switch ( $style ) {
				case 'grid' :
					$thumb = thim_get_thumbnail( get_the_ID(), '485x291', 'post', false );
					break;
				default:
					//list
					$thumb = thim_get_thumbnail( get_the_ID(), '1200x520', 'post', false );
					break;
			}
		}

		$html = '<a class="post-image" href="' . esc_url( get_permalink() ) . '">';
		$html .= $thumb;
		$html .= '</a>';

		return $html;
	}
}


/**
 * Show entry format images, video, gallery, audio, etc.
 *
 * @return void
 */
if ( ! function_exists( 'thim_top_entry' ) ):
	function thim_top_entry( $size ) {
		$html = '';

		$style = isset( $_GET['style'] ) ? $_GET['style'] : get_theme_mod( 'archive_post_layout', 'list' );

		switch ( get_post_format() ) {
			case 'image':
				$image = thim_get_image(
					array(
						'size'     => $size,
						'format'   => 'src',
						'meta_key' => 'thim_image',
						'echo'     => false,
					)
				);

				if ( ! $image ) {
					break;
				}

				$html = sprintf( '<a class="post-image" href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s"></a>', esc_url( get_permalink() ), esc_attr( the_title_attribute( 'echo=0' ) ), $image );
				break;
			case 'gallery':
				wp_enqueue_script( 'flexslider' );
				$images = thim_meta( 'thim_gallery', "type=image&single=false&size=$size" );
				$thumbs = thim_meta( 'thim_gallery', "type=image&single=false&size=thumbnail" );
				if ( empty( $images ) ) {
					break;
				}
				$html .= '<div class="flexslider">';
				$html .= '<ul class="slides">';
				foreach ( $images as $key => $image ) {
					if ( ! empty( $image['url'] ) ) {
						$html .= sprintf( '<li data-thumb="%s"><a href="%s" class="hover-gradient"><img src="%s" alt="gallery"></a></li>', $thumbs[$key]['url'], esc_url( get_permalink() ), esc_url( $image['url'] ) );
					}
				}
				$html .= '</ul>';
				$html .= '</div>';
				break;
			case 'audio':
				$audio = thim_meta( 'thim_audio' );
				if ( ! $audio ) {
					break;
				}
				// If URL: show oEmbed HTML or jPlayer
				if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
					//jsplayer
					wp_enqueue_style( 'thim-pixel-industry', THIM_CORE_ADMIN_URI . '/assets/js/jplayer/skin/pixel-industry/pixel-industry.css' );
					wp_enqueue_script( 'thim-jplayer', THIM_CORE_ADMIN_URI . '/assets/js/jplayer/jquery.jplayer.min.js', array( 'jquery' ), '', true );

					// Try oEmbed first
					if ( $oembed = @wp_oembed_get( $audio ) ) {
						$html .= $oembed;
					} // Use jPlayer
					else {
						$id   = uniqid();
						$html .= "<div data-player='$id' class='jp-jplayer' data-audio='$audio'></div>";
						$html .= thim_jplayer( $id );
					}
				} // If embed code: just display
				else {
					$html .= $audio;
				}
				break;
			case 'video':
				$video_link = thim_meta( 'thim_video' );

				if ( empty( $video_link ) ) {
					break;
				}

				if ( is_singular( 'post' ) ) { // show embed code in single post
					if ( filter_var( $video_link, FILTER_VALIDATE_URL ) ) { // If URL: show oEmbed HTML
						if ( $oembed = @wp_oembed_get( $video_link ) ) {
							$html .= $oembed;
						}
					} else { // If embed code: just display
						$html .= $video_link;
					}
				} else {
					$html .= thim_get_default_post_thumbnail( get_the_ID(), $size, $style );
				}
				break;
			default:
				$html .= thim_get_default_post_thumbnail( get_the_ID(), $size, $style );
		}
		if ( $html ) {
			echo "<div class='post-formats-wrapper'>$html</div>";
		}
	}
endif;
add_action( 'thim_top_entry', 'thim_top_entry' );

/*
 * Get video ID
 * */
if ( ! function_exists( 'thim_get_video_id' ) ) {
	function thim_get_video_id( $url ) {
		$video_id = '';

		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) { // URL
			// Get host name
			$host = explode( '.', str_replace( 'www.', '', strtolower( parse_url( $url, PHP_URL_HOST ) ) ) );
			$host = isset( $host[0] ) ? $host[0] : $host;

			if ( $host == 'youtube' || $host == 'youtu' ) {
				$pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

				preg_match( $pattern, $url, $matches );
				$video_id = $matches[1];
			} elseif ( $host == 'vimeo' ) {
				$pattern = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/';

				preg_match( $pattern, $url, $matches );
				if ( is_array( $matches ) ) {
					$video_id = $matches[count( $matches ) - 1];
				}
			} else {
				$url_arr  = explode( "/", $url );
				$video_id = $url_arr[count( $url_arr ) - 1];
			}

		} else { // Embed code
			$url = wp_unslash( $url );
			preg_match( '/src="([^"]+)"/', $url, $match );

			$videoURL  = $match[1];
			$urlArr    = explode( "/", $videoURL );
			$urlArrNum = count( $urlArr );

			$video_id = $urlArr[$urlArrNum - 1];
		}

		return $video_id;
	}
}

if ( ! function_exists( 'thim_get_video_thumbnail_src' ) ) {
	function thim_get_video_thumbnail_src( $url ) {
		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			$video_link = wp_unslash( $url );
			preg_match( '/src="([^"]+)"/', $video_link, $match );
			$url = $match[1];
		}

		$host     = explode( '.', str_replace( 'www.', '', strtolower( parse_url( $url, PHP_URL_HOST ) ) ) );
		$video_id = thim_get_video_id( $url );

		if ( in_array( "vimeo", $host ) ) {
			$response = wp_remote_get( esc_url_raw( "http://vimeo.com/api/v2/video/{$video_id}.json" ) );
			if ( is_wp_error( $response ) ) {
				return false;
			}
			$data = wp_remote_retrieve_body( $response );
			$data = json_decode( $data, true );

			$hash = ( explode( "_640", $data[0]['thumbnail_large'] ) );

			$src = $hash[0] . $hash[1];

			return $src;
		} elseif ( in_array( "youtube", $host ) || in_array( "youtu", $host ) ) {
			$api      = apply_filters( 'thim_youtube_v3_api', 'AIzaSyCSC8oqEMTR_DUAQsoF__SdGQIgux-sSCA' );
			$response = wp_remote_get( "https://www.googleapis.com/youtube/v3/videos/?id={$video_id}&key={$api}&part=snippet&fields=items(id,snippet(title,description,thumbnails))" );
			if ( is_wp_error( $response ) ) {
				return false;
			}
			$data = wp_remote_retrieve_body( $response ); // string
			$data = json_decode( $data, true ); // associative  arrays

			$video_detail = $data['items'][0]['snippet']['thumbnails'];
			$src          = isset( $video_detail['maxres']['url'] ) ? $video_detail['maxres']['url'] : $video_detail['standard']['url'];

			return $src;
		} else { // Return video detail for remain video provider
			if ( function_exists( '_wp_oembed_get_object' ) ) {
				require_once( ABSPATH . WPINC . '/class-oembed.php' );
			}

			$oembed   = _wp_oembed_get_object();
			$provider = $oembed->get_provider( $url );
			$data     = $oembed->fetch( $provider, $url );

			if ( $data ) {
				$data = (array) $data;

				return $data;
			}
		}
	}
}

if ( ! function_exists( 'thim_set_video_thumbnail_as_featured_image' ) ) {
	function thim_set_video_thumbnail_as_featured_image( $post_id, $post, $update ) {

		if ( $post->post_type != 'post' || get_post_format( $post_id ) != 'video' || ! $update ) {
			return;
		}

		$video_thumbnail_attached = get_post_meta( $post_id, 'thim_video_thumbnail_attached', true );

		if ( empty( $_POST['thim_video'] ) ) {
			wp_delete_attachment( intval( $video_thumbnail_attached ), true );
			update_post_meta( $post_id, 'thim_video_thumbnail_attached', '0' );

			return;
		}

		$video_link = $_POST['thim_video'];
		$src        = thim_get_video_thumbnail_src( $video_link );
		// validate image src
		if ( ! filter_var( $src, FILTER_VALIDATE_URL ) ) {
			return;
		}
		$ext  = array( 'jpeg', 'jpg', 'gif', 'png' );
		$info = (array) pathinfo( parse_url( $src, PHP_URL_PATH ) );
		if ( ! isset( $info['extension'] ) || ! in_array( strtolower( $info['extension'] ), $ext, true ) ) {
			return;
		}

		// only want to do this if the post has no thumbnail
		if ( ! has_post_thumbnail( $post_id ) ) {
			$video_thumbnail_current = media_sideload_image( $src, $post_id, esc_html__( 'The Featured Image of Post', 'course-builder' ), 'id' );
			if ( is_wp_error( $video_thumbnail_current ) ) {
				return;
			}

			if ( ! $video_thumbnail_attached ) {
				update_post_meta( $post_id, 'thim_video_thumbnail_attached', $video_thumbnail_current );
				set_post_thumbnail( $post_id, intval( $video_thumbnail_current ) );
			} elseif ( $video_thumbnail_current != $video_thumbnail_attached ) {
				wp_delete_attachment( intval( $video_thumbnail_attached ), true );
				update_post_meta( $post_id, 'thim_video_thumbnail_attached', $video_thumbnail_current );
				set_post_thumbnail( $post_id, intval( $video_thumbnail_current ) );
			}
		}

	} // set_youtube_as_featured_image
}
add_action( 'save_post', 'thim_set_video_thumbnail_as_featured_image', 15, 3 );


/**
 * Get post meta
 *
 * @param $key
 * @param $args
 * @param $post_id
 *
 * @return string
 * @return bool
 */
if ( ! function_exists( 'thim_meta' ) ) {
	function thim_meta( $key, $args = array(), $post_id = null ) {
		$post_id = empty( $post_id ) ? get_the_ID() : $post_id;

		$args = wp_parse_args(
			$args, array(
				'type' => 'text',
			)
		);

		// Image
		if ( in_array( $args['type'], array( 'image' ) ) ) {
			if ( isset( $args['single'] ) && $args['single'] == "false" ) {
				// Gallery
				$temp          = array();
				$data          = array();
				$attachment_id = get_post_meta( $post_id, $key, false );
				if ( ! $attachment_id ) {
					return $data;
				}

				if ( empty( $attachment_id ) ) {
					return $data;
				}
				foreach ( $attachment_id as $k => $v ) {
					$image_attributes = wp_get_attachment_image_src( $v, $args['size'] );
					$temp['url']      = $image_attributes[0];
					$data[]           = $temp;
				}

				return $data;
			} else {
				// Single Image
				$attachment_id    = get_post_meta( $post_id, $key, true );
				$image_attributes = wp_get_attachment_image_src( $attachment_id, $args['size'] );

				return $image_attributes;
			}
		}

		return get_post_meta( $post_id, $key, $args );
	}
}


/**
 * Get image features
 *
 * @param $args
 *
 * @return array|void
 */
if ( ! function_exists( 'thim_get_image' ) ) {
	function thim_get_image( $args = array() ) {
		$default = apply_filters(
			'thim_get_image_default_args', array(
				'post_id'  => get_the_ID(),
				'size'     => 'thumbnail',
				'format'   => 'html', // html or src
				'attr'     => '',
				'meta_key' => '',
				'scan'     => true,
				'default'  => '',
				'echo'     => true,
			)
		);

		$args = wp_parse_args( $args, $default );

		if ( ! $args['post_id'] ) {
			$args['post_id'] = get_the_ID();
		}

		// Get image from cache
		$key         = md5( serialize( $args ) );
		$image_cache = wp_cache_get( $args['post_id'], 'thim_get_image' );

		if ( ! is_array( $image_cache ) ) {
			$image_cache = array();
		}

		if ( empty( $image_cache[$key] ) ) {
			// Get post thumbnail
			if ( has_post_thumbnail( $args['post_id'] ) ) {
				$id   = get_post_thumbnail_id();
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}

			// Get the first image in the custom field
			if ( ! isset( $html, $src ) && $args['meta_key'] ) {
				$id = get_post_meta( $args['post_id'], $args['meta_key'], true );

				// Check if this post has attached images
				if ( $id ) {
					$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
					list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
				}
			}

			// Get the first attached image
			if ( ! isset( $html, $src ) ) {
				$image_ids = array_keys(
					get_children(
						array(
							'post_parent'    => $args['post_id'],
							'post_type'      => 'attachment',
							'post_mime_type' => 'image',
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						)
					)
				);

				// Check if this post has attached images
				if ( ! empty( $image_ids ) ) {
					$id   = $image_ids[0];
					$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
					list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
				}
			}

			// Get the first image in the post content
			if ( ! isset( $html, $src ) && ( $args['scan'] ) ) {
				preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );

				if ( ! empty( $matches ) ) {
					$html = $matches[0];
					$src  = $matches[1];
				}
			}

			// Use default when nothing found
			if ( ! isset( $html, $src ) && ! empty( $args['default'] ) ) {
				if ( is_array( $args['default'] ) ) {
					$html = @$args['html'];
					$src  = @$args['src'];
				} else {
					$html = $src = $args['default'];
				}
			}

			// Still no images found?
			if ( ! isset( $html, $src ) ) {
				return false;
			}

			$output = 'html' === strtolower( $args['format'] ) ? $html : $src;

			$image_cache[$key] = $output;
			wp_cache_set( $args['post_id'], $image_cache, 'thim_get_image' );
		} // If image already cached
		else {
			$output = $image_cache[$key];
		}

		$output = apply_filters( 'thim_get_image', $output, $args );

		if ( ! $args['echo'] ) {
			return $output;
		}

		echo ent2ncr( $output );
	}
}

//admin custom style
add_action( 'admin_enqueue_scripts', 'thim_admin_custom_styles' );
function thim_admin_custom_styles() {
	wp_enqueue_style( 'thim-admin-custom', get_template_directory_uri() . '/assets/css/admin.css', array(), true );
	wp_enqueue_script( 'thim-admin-custom-script', get_template_directory_uri() . '/assets/js/admin-custom-script.js', array() );
}

/**
 * Filter lost password link
 *
 * @param $url
 *
 * @return string
 */
if ( ! function_exists( 'thim_get_lost_password_url' ) ) {
	function thim_get_lost_password_url() {
		$url = add_query_arg( 'action', 'lostpassword', thim_get_login_page_url() );

		return $url;
	}
}

/**
 * Get login page url
 *
 * @return false|string
 */
if ( ! function_exists( 'thim_get_login_page_url' ) ) {
	function thim_get_login_page_url( $redirect_url = '' ) {
		if ( $page = get_option( 'thim_login_page' ) ) {
			return ! empty( $redirect_url ) ? add_query_arg( 'redirect_to', urlencode( $redirect_url ), get_permalink( $page ) ) : get_permalink( $page );
		} else {
			global $wpdb;
			$page = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT p.ID FROM $wpdb->posts AS p INNER JOIN $wpdb->postmeta AS pm ON p.ID = pm.post_id
			WHERE 	pm.meta_key = %s
			AND 	pm.meta_value = %s
			AND		p.post_type = %s
			AND		p.post_status = %s",
					'thim_login_page',
					'1',
					'page',
					'publish'
				)
			);
			if ( ! empty( $page[0] ) ) {
				return ! empty( $redirect_url ) ? add_query_arg( 'redirect_to', urlencode( $redirect_url ), get_permalink( $page[0] ) ) : get_permalink( $page[0] );
			}
		}

		return wp_login_url( $redirect_url );

	}
}

/**
 * Filter register link
 *
 * @param $register_url
 *
 * @return string|void
 */
if ( ! function_exists( 'thim_get_register_url' ) ) {
	function thim_get_register_url( $redirect_url = '' ) {
		$url = add_query_arg( 'action', 'register', thim_get_login_page_url( $redirect_url ) );

		return $url;
	}
}

/**
 * Redirect to custom login page
 */
if ( ! function_exists( 'thim_login_failed' ) ) {
	function thim_login_failed() {
		if ( ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'thim_login_ajax' ) || ( isset( $_REQUEST['lp-ajax'] ) && $_REQUEST['lp-ajax'] == 'login' ) || ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			return;
		}

		wp_redirect( add_query_arg( 'result', 'failed', thim_get_login_page_url() ) );
		exit;
	}

	add_action( 'wp_login_failed', 'thim_login_failed', 1000 );
}

/**
 * Remove hook tp-event-auth
 */
if ( class_exists( 'TP_Event_Authentication' ) ) {
	if ( ! version_compare( get_option( 'event_auth_version' ), '1.0.3', '>=' ) ) {
		$auth = TP_Event_Authentication::getInstance()->auth;

		remove_action( 'login_form_login', array( $auth, 'redirect_to_login_page' ) );
		remove_action( 'login_form_register', array( $auth, 'login_form_register' ) );
		remove_action( 'login_form_lostpassword', array( $auth, 'redirect_to_lostpassword' ) );
		remove_action( 'login_form_rp', array( $auth, 'resetpass' ) );
		remove_action( 'login_form_resetpass', array( $auth, 'resetpass' ) );

		remove_action( 'wp_logout', array( $auth, 'wp_logout' ) );
		remove_filter( 'login_url', array( $auth, 'login_url' ) );
		remove_filter( 'login_redirect', array( $auth, 'login_redirect' ) );
	}
}
/**
 * Filter event login url
 */
add_filter( 'tp_event_login_url', 'thim_get_login_page_url' );
add_filter( 'event_auth_login_url', 'thim_get_login_page_url' );

if ( ! function_exists( 'thim_is_lp_profile_page' ) ) {
	function thim_is_lp_profile_page() {
		if ( class_exists( 'LearnPress' ) ) {
			return learn_press_is_profile();
		}

		return false;
	}
}

if ( ! function_exists( 'thim_is_lp_courses_page' ) ) {
	function thim_is_lp_courses_page() {
		if ( class_exists( 'LearnPress' ) ) {
			return learn_press_is_courses();
		}

		return false;
	}
}

/*
 * Hide/show advertisement in dashboard
 * */
if ( get_theme_mod( 'thim_learnpress_hidden_ads', false ) ) {
	remove_action( 'admin_footer', 'learn_press_footer_advertisement', - 10 );
}

/**
 * Add filter login redirect
 */
/*add_filter( 'login_redirect', 'thim_login_redirect', 1000 );
if ( ! function_exists( 'thim_login_redirect' ) ) {
	function thim_login_redirect() {
		if ( empty( $_REQUEST['redirect_to'] ) ) {
			$redirect_url = get_theme_mod( 'thim_login_redirect' );
			if ( ! empty( $redirect_url ) ) {
				return $redirect_url;
			} else {
				return home_url();
			}
		} else {
			return $_REQUEST['redirect_to'];
		}
	}
}*/

/**
 * Process ajax login-popup
 */
add_action( 'wp_ajax_nopriv_thim_login_ajax', 'thim_login_ajax_callback' );
//add_action( 'wp_ajax_thim_login_ajax', 'thim_login_ajax_callback' );
if ( ! function_exists( 'thim_login_ajax_callback' ) ) {
	function thim_login_ajax_callback() {
		if ( empty( $_REQUEST['data'] ) ) {
			$response_data = array(
				'code'    => - 1,
				'message' => '<p class="message message-error">' . esc_html__( 'Something wrong. Please try again.', 'course-builder' ) . '</p>'
			);
		} else {

			parse_str( $_REQUEST['data'], $login_data );

			$_REQUEST = $login_data;

			$_POST['wp-submit'] = $login_data['wp-submit'];


			$user_verify = wp_signon( $login_data, is_ssl() );

			$code    = 1;
			$message = '';

			if ( is_wp_error( $user_verify ) ) {
				if ( ! empty( $user_verify->errors ) ) {
					$errors = $user_verify->errors;
					if ( ! empty( $errors['invalid_username'] ) ) {
						$message = '<p class="message message-error">' . __( '<strong>ERROR</strong>: Invalid username or email.', 'course-builder' ) . '</p>';
					} else {
						if ( ! empty( $errors['incorrect_password'] ) ) {
							$message = '<p class="message message-error">' . __( '<strong>ERROR</strong>: The password you entered is incorrect.', 'course-builder' ) . '</p>';
						} else {
							if ( ! empty( $errors['cptch_error'] ) && is_array( $errors['cptch_error'] ) ) {
								foreach ( $errors['cptch_error'] as $key => $value ) {
									$message .= '<p class="message message-error">' . $value . '</p>';
								}
							} else {
								$message = '<p class="message message-error">' . __( '<strong>ERROR</strong>: Something wrong. Please try again.', 'course-builder' ) . '</p>';
							}
						}
					}
				} else {
					$message = '<p class="message message-error">' . __( '<strong>ERROR</strong>: Something wrong. Please try again.', 'course-builder' ) . '</p>';
				}
				$code = - 1;
			} else {
				$message = '<p class="message message-success">' . esc_html__( 'Login successful, redirecting...', 'course-builder' ) . '</p>';
			}

			$response_data = array(
				'code'    => $code,
				'message' => $message
			);

			if ( ! empty( $login_data['redirect_to'] ) ) {
				$response_data['redirect'] = $login_data['redirect_to'];
			}
		}
		echo json_encode( $response_data );
		die(); // this is required to return a proper result
	}
}

/**
 * Register failed
 *
 * @param $sanitized_user_login
 * @param $user_email
 * @param $errors
 */
if ( ! function_exists( 'thim_register_failed' ) ) {
	function thim_register_failed( $errors ) {

		if ( ! empty( $_POST['is_popup_register'] ) ) {
			return $errors;
		}


		if ( $errors->get_error_code() ) {

			//setup your custom URL for redirection
			$url = add_query_arg( 'action', 'register', thim_get_login_page_url() );

			foreach ( $errors->errors as $e => $m ) {
				$url = add_query_arg( $e, '1', $url );
			}
			wp_redirect( $url );
			exit;
		}

		return $errors;
	}

	add_action( 'registration_errors', 'thim_register_failed', 99, 3 );
}

/**
 * Handling registration AJAX request
 */
if ( get_option( 'users_can_register' ) ) {
	add_action( 'wp_ajax_nopriv_thim_register_ajax', 'thim_register_ajax_callback' );
}

if ( ! function_exists( 'thim_register_ajax_callback' ) ) {
	function thim_register_ajax_callback() {

		$has_auto_login = get_theme_mod( 'auto_login', false );

		// First check the nonce, if it fails the function will break
		$secure = check_ajax_referer( 'ajax_register_nonce', 'register_security', false );

		if ( ! $secure ) {
			$response_data = array(
				'message' => '<p class="message message-error">' . esc_html__( 'Something wrong. Please try again.', 'course-builder' ) . '</p>'
			);

			wp_send_json_error( $response_data );
		}

		parse_str( $_POST['data'], $data );

		if ( $has_auto_login == true ) {
			foreach ( $data as $k => $v ) {
				$_POST[$k] = $v;
			}

			$_POST['is_popup_register'] = 1;
		}

		$info = array();

		$info['user_login']    = sanitize_user( $data['user_login'] );
		$info['first_name']    = sanitize_text_field( $data['first_name'] );//new field
		$info['last_name']     = sanitize_text_field( $data['last_name'] );//new field
		$info['user_email']    = sanitize_email( $data['user_email'] );
		$info['user_pass']     = sanitize_text_field( $data['password'] );
		$info['lp_info_phone'] = sanitize_text_field( $data['lp_info_phone'] ); //wd

		if ( $has_auto_login == false ) {
			$confirm_password = sanitize_text_field( $data['repeat_password'] );

			if ( $info['user_pass'] !== $confirm_password ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'Those passwords didn\'t match. Try again.', 'course-builder' ) . '</p>'
				);

				wp_send_json_error( $response_data );
			}
		}

		// Register the user
		$user_register = wp_insert_user( $info );


		if ( is_wp_error( $user_register ) ) {
			$error = $user_register->get_error_codes();

			if ( in_array( 'empty_user_login', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( $user_register->get_error_message( 'empty_user_login' ), 'course-builder' ) . '</p>'
				);

			} elseif ( in_array( 'existing_user_login', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'This username is already registered.', 'course-builder' ) . '</p>'
				);
			} elseif ( in_array( 'existing_user_email', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'This email address is already registered.', 'course-builder' ) . '</p>'
				);
			} elseif ( in_array( 'empty_username', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'Please enter a username!', 'course-builder' ) . '</p>'
				);
			} elseif ( in_array( 'invalid_username', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'The username is invalid. Please try again!', 'course-builder' ) . '</p>'
				);
			} elseif ( in_array( 'username_exists', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'This username is already registered. Please choose another one!', 'course-builder' ) . '</p>'
				);
			} elseif ( in_array( 'empty_email', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'Please type your e-mail address!', 'course-builder' ) . '</p>'
				);
			} elseif ( in_array( 'invalid_email', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'The email address isn\'t correct. Please try again!', 'course-builder' ) . '</p>'
				);
			} elseif ( in_array( 'email_exists', $error ) ) {
				$response_data = array(
					'message' => '<p class="message message-error">' . esc_html__( 'This email is already registered. Please choose another one!', 'course-builder' ) . '</p>'
				);
			}

			wp_send_json_error( $response_data );


		} else {
			if ( $has_auto_login == false ) {
				wp_new_user_notification( $user_register, null, 'admin' );

				$creds                  = array();
				$creds['user_login']    = $info['user_login'];
				$creds['user_password'] = $info['user_pass'];
				$creds['first_name']    = $info['first_name'];//new field
				$creds['last_name']     = $info['last_name'];//new field
				$creds['lp_info_phone'] = $info['lp_info_phone']; //sc

				$user_signon = wp_signon( $creds, false );

				if ( is_wp_error( $user_signon ) ) {
					$response_data = array(
						'message' => '<p class="message message-error">' . esc_html__( 'Wrong username or password.', 'course-builder' ) . '</p>'
					);

					wp_send_json_error( $response_data );
				} else {
					wp_set_current_user( $user_signon->ID );
					wp_set_auth_cookie( $user_signon->ID );

					$response_data = array(
						'message' => '<p class="message message-success">' . esc_html__( 'Registration successful, redirecting...', 'course-builder' ) . '</p>'
					);

					wp_send_json_success( $response_data );
				}

			} else {
				//wp_new_user_notification( $user_register, null, 'both' );

				$response_data = array(
					'message' => '<p class="message message-success">' . esc_html__( 'Registration is successful. Confirmation will be e-mailed to you.', 'course-builder' ) . '</p>'
				);

				wp_send_json_success( $response_data );
			}
		}

	}
}
/*
 * Process ajax reset password
 * */
add_action( 'wp_ajax_nopriv_thim_reset_password_ajax', 'thim_reset_password_ajax_callback' );
//add_action( 'wp_ajax_thim_reset_password_ajax', 'thim_reset_password_ajax_callback' );

if ( ! function_exists( 'thim_reset_password_ajax_callback' ) ) {
	function thim_reset_password_ajax_callback() {
		$login_page = thim_get_login_page_url();
		$errors     = new WP_Error();
		$nonce      = $_POST['nonce'];

		if ( ! wp_verify_nonce( $nonce, 'rs_user_reset_password_action' ) ) {
			exit();
		}

		$pass1 = isset( $_POST['pass1'] ) ? $_POST['pass1'] : '';
		$pass2 = isset( $_POST['pass2'] ) ? $_POST['pass2'] : '';
		$key   = $_POST['user_key'];
		$login = $_POST['user_login'];

		$user = check_password_reset_key( $key, $login );

		if ( is_wp_error( $user ) ) {
			if ( $user->get_error_code() === 'expired_key' ) {
				$errors->add( 'expiredkey', esc_html__( 'Sorry, that key has expired. Please try again.', 'course-builder' ) );
			} else {
				$errors->add( 'invalidkey', esc_html__( 'Sorry, that key does not appear to be valid.', 'course-builder' ) );
			}
		}

		// check to see if user added some string
		if ( empty( $pass1 ) || empty( $pass2 ) ) {
			$errors->add( 'password_required', esc_html__( 'Password is required field', 'course-builder' ) );
		}

		// is pass1 and pass2 match?
		if ( isset( $pass1 ) && $pass1 != $pass2 ) {
			$errors->add( 'password_reset_mismatch', esc_html__( 'The passwords do not match.', 'course-builder' ) );
		}

		/**
		 * Fires before the password reset procedure is validated.
		 *
		 * @param object           $errors WP Error object.
		 * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
		 *
		 * @since 3.5.0
		 *
		 */
		do_action( 'validate_password_reset', $errors, $user );

		if ( ( ! $errors->get_error_code() ) && isset( $pass1 ) && ! empty( $pass1 ) && ! is_wp_error( $user ) ) {
			reset_password( $user, $pass1 );
			$errors->add( 'password_reset', esc_html__( 'Your password has been reset.', 'course-builder' ) );
			/*wp_redirect( add_query_arg(
				array(
					'result' => 'changed',
				), $login_page
			) );
			exit;*/
		}

		if ( $errors->get_error_code() ) {
			echo json_encode( $errors->errors );
		}

		die();
	}
}

add_filter( 'wsl_process_login_start', 'wsl_whitelist_endpoint' );

function wsl_whitelist_endpoint() {
	setcookie( LOGGED_IN_COOKIE, md5( rand() ), time() + 15, preg_replace( '|https?://[^/]+|i', '', WORDPRESS_SOCIAL_LOGIN_HYBRIDAUTH_ENDPOINT_URL ) );
}

/**
 * Set user password for theme's register form
 *
 * @param $user_id
 */
add_action( 'user_register', 'thim_register_extra_fields', 1000 );
if ( ! function_exists( 'thim_register_extra_fields' ) ) {
	function thim_register_extra_fields( $user_id ) {
		$theme_options_data = get_theme_mods();

		if ( empty( $theme_options_data['auto_login'] ) || ( isset( $theme_options_data['auto_login'] ) && $theme_options_data['auto_login'] == '0' ) ) {
			$user_data       = array();
			$user_data['ID'] = $user_id;

			if ( empty( $_POST['password'] ) || empty( $_POST['repeat_password'] ) || empty( $_POST['user_login'] ) || empty( $_POST['user_email'] ) ) {
				return;
			}

			if ( $_POST['password'] !== $_POST['repeat_password'] ) {
				return;
			}

			$user_data['user_login']    = $_POST['user_login'];
			$user_data['first_name']    = $_POST['first_name'];//new field
			$user_data['last_name']     = $_POST['last_name'];//new field
			$user_data['user_email']    = $_POST['user_email'];
			$user_data['user_pass']     = $_POST['password'] = $_POST['repeat_password'];
			$user_data['lp_info_phone'] = $_POST['lp_info_phone']; //sc

			$new_user_id = wp_update_user( $user_data );

			if ( is_wp_error( $new_user_id ) ) {
				echo $new_user_id->get_error_message();
			}

			// allow hook after register user
			do_action( 'wordpress-lms/after-register-user', $new_user_id, $_POST );

			// Login after registered
			wp_set_current_user( $user_id );
			wp_set_auth_cookie( $user_id );

			$redirect_url = ! empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : home_url();
			wp_redirect( $redirect_url );
			exit();
		}
	}
}

/**
 * Change link reset password in the email
 */
if ( ! function_exists( 'thim_replace_retrieve_password_message' ) ) {
	function thim_replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {

		$reset_link = add_query_arg(
			array(
				'action' => 'rp',
				'key'    => $key,
				'login'  => rawurlencode( $user_login )
			), thim_get_login_page_url()
		);

		// Create new message
		$message = esc_html__( 'Someone has requested a password reset for the following account:', 'course-builder' ) . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf( esc_html__( 'Username: %s', 'course-builder' ), $user_login ) . "\r\n\r\n";
		$message .= esc_html__( 'If this was a mistake, just ignore this email and nothing will happen.', 'course-builder' ) . "\r\n\r\n";
		$message .= esc_html__( 'To reset your password, visit the following address:', 'course-builder' ) . "\r\n\r\n";
		$message .= $reset_link . "\r\n";

		return $message;
	}
}

/**
 * Determining engine environment
 */
if ( ! function_exists( 'is_wpe' ) && ! function_exists( 'is_wpe_snapshot' ) ) {
	add_filter( 'retrieve_password_message', 'thim_replace_retrieve_password_message', 10, 4 );
}

/**
 * Do password reset
 */
if ( ! function_exists( 'thim_do_password_reset' ) ) {
	function thim_do_password_reset() {

		$login_page = thim_get_login_page_url();
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

			if ( ! isset( $_REQUEST['key'] ) || ! isset( $_REQUEST['login'] ) ) {
				return;
			}

			$key   = $_REQUEST['key'];
			$login = $_REQUEST['login'];

			$user = check_password_reset_key( $key, $login );

			if ( ! $user || is_wp_error( $user ) ) {
				if ( $user && $user->get_error_code() === 'expired_key' ) {
					wp_redirect(
						add_query_arg(
							array(
								'action'      => 'rp',
								'expired_key' => '1',
							), $login_page
						)
					);
				} else {
					wp_redirect(
						add_query_arg(
							array(
								'action'      => 'rp',
								'invalid_key' => '1',
							), $login_page
						)
					);
				}
				exit;
			}

			if ( isset( $_POST['password_reset'] ) ) {

				if ( empty( $_POST['password_reset'] ) ) {
					// Password is empty
					wp_redirect(
						add_query_arg(
							array(
								'action'           => 'rp',
								'key'              => $_REQUEST['key'],
								'login'            => $_REQUEST['login'],
								'invalid_password' => '1',
							), $login_page
						)
					);
					exit;
				}

				// Parameter checks OK, reset password
				reset_password( $user, $_POST['password_reset'] );
				wp_redirect(
					add_query_arg(
						array(
							'result' => 'changed',
						), $login_page
					)
				);
			} else {
				_e( 'Invalid request.', 'course-builder' );
			}

			exit;
		}
	}
}
//add_action( 'login_form_rp', 'thim_do_password_reset', 1000 );
//add_action( 'login_form_resetpass', 'thim_do_password_reset', 1000 );

/**
 * Filters Paid Membership pro login redirect & register redirect
 */
remove_filter( 'login_redirect', 'pmpro_login_redirect', 10 );
add_filter( 'pmpro_register_redirect', '__return_false' );

/**
 * Redirect to custom register page in case multi sites
 *
 * @param $url
 *
 * @return mixed
 */
if ( ! function_exists( 'thim_multisite_register_redirect' ) ) {
	function thim_multisite_register_redirect( $url ) {

		if ( is_multisite() ) {
			$url = add_query_arg( 'action', 'register', thim_get_login_page_url() );
		}

		$user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';
		$user_email = isset( $_POST['user_email'] ) ? $_POST['user_email'] : '';
		$errors     = register_new_user( $user_login, $user_email );
		if ( ! is_wp_error( $errors ) ) {
			$redirect_to = ! empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : 'wp-login.php?checkemail=registered';
			wp_safe_redirect( $redirect_to );
			exit();
		}

		return $url;
	}
}
add_filter( 'wp_signup_location', 'thim_multisite_register_redirect' );


/************************* Compatible LP 3 ***************************************/
if ( class_exists( 'LearnPress' ) ) {

	/**
	 * Filter Learnpress override path.
	 *
	 * @return string
	 */
	function thim_lp_template_path() {
		if ( thim_is_new_learnpress( '4.0.0-beta-0' ) ) {
			return 'learnpress-v4';
		} else {
			return 'learnpress-v3';
		}
	}

	add_filter( 'learn_press_template_path', 'thim_lp_template_path', 999 );

	if ( thim_is_new_learnpress( '4.0.0-beta-0' ) ) {
		require_once THIM_DIR . 'inc/learnpress-v4-functions.php';
	} else {
		require_once THIM_DIR . 'learnpress-v3/custom-functions.php';
	}
	require_once THIM_DIR . 'inc/learnpress-functions.php';

}
/**
 * Process extra register fields
 *
 * @param $login
 * @param $email
 * @param $errors
 */
if ( ! function_exists( 'thim_check_extra_register_fields' ) ) {
	function thim_check_extra_register_fields( $login, $email, $errors ) {
		$theme_options_data = get_theme_mods();
		if ( empty( $theme_options_data['auto_login'] ) || ( isset( $theme_options_data['auto_login'] ) && $theme_options_data['auto_login'] == '0' ) ) {
			if ( $_POST['password'] !== $_POST['repeat_password'] ) {
				$errors->add( 'passwords_not_matched', "<strong>ERROR</strong>: Passwords must match" );
			}
		}
	}
}
add_action( 'register_post', 'thim_check_extra_register_fields', 10, 3 );


if ( ! function_exists( 'thim_login_url_blog_comment_form' ) ) {
	function thim_login_url_blog_comment_form( $defaults ) {
		$post_id = get_the_ID();

		$defaults['must_log_in'] = '<p class="must-log-in">' . sprintf(
			/* translators: %s: login URL */
				__( 'You must be <a href="%s">logged in</a> to post a comment.', 'course-builder' ),
				add_query_arg( 'redirect_to', apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ), thim_get_login_page_url() )
			) . '</p>';

		return $defaults;
	}

	add_filter( 'comment_form_defaults', 'thim_login_url_blog_comment_form' );
}

if ( ! function_exists( 'thim_get_user_meta' ) ) {
	function thim_get_user_meta( $a ) {
		return $a[0];
	}
}

// Show breadcrumb bbPress plugin
if ( ! function_exists( 'thim_bbpress_breadcrumb' ) ) {
	function thim_bbpress_breadcrumb() {
		if ( ! class_exists( 'bbPress' ) ) {
			return;
		}

		$args = array(
			'before'       => '<ul itemprop="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs" class="breadcrumbs">',
			'after'        => '</ul>',
			'sep'          => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
			'sep_before'   => '<span class="breadcrum-icon">',
			'sep_after'    => '</span>',
			'home_text'    => esc_html_x( 'Home', 'bbPress breadcrumb', 'course-builder' ),
			'crumb_before' => '<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">',
			'crumb_after'  => '</li>',
		);

		bbp_breadcrumb( $args );
	}
}

/**
 * Related portfolio
 */
if ( ! function_exists( 'thim_related_portfolio' ) ) {
	function thim_related_portfolio( $post_id ) {

		?>
		<div class="related-portfolio col-md-12">
			<div class="module_title"><h4
					class="widget-title"><?php esc_html_e( 'Related Items', 'course-builder' ); ?></h4>
			</div>

			<?php //Get Related posts by category	-->
			$args      = array(
				'posts_per_page' => 3,
				'post_type'      => 'portfolio',
				'post_status'    => 'publish',
				'post__not_in'   => array( $post_id )
			);
			$port_post = get_posts( $args );
			?>

			<ul class="wapper_portfolio row">
				<?php
				foreach ( $port_post as $post ) : setup_postdata( $post ); ?>

					<li class="item_portfolio col-sm-4">
						<?php

						$image_id = get_post_thumbnail_id( $post->ID );

						$imgurl = wp_get_attachment_image_src( $image_id, array( 480, 320 ) );
						//						$image_crop = thim_aq_resize( $imgurl[0], '480', '320', true );
						$image_crop = $imgurl[0];

						$image_url = '<img src="' . $image_crop . '" alt= ' . get_the_title() . ' title = ' . get_the_title() . ' />';


						echo '<div class="portfolio-image">' . $image_url . '
							<div class="portfolio-hover"><div class="thumb-bg""><div class="mask-content">';
						echo '<div class="info">';
						echo '<h3><a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" >' . get_the_title( $post->ID ) . '</a></h3>';
						$terms    = get_the_terms( $post->ID, 'portfolio_category' );
						$cat_name = '';
						if ( $terms && ! is_wp_error( $terms ) ) :
							foreach ( $terms as $term ) {
								if ( $cat_name ) {
									$cat_name .= ', ';
								}
								$cat_name .= '<a href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . '</a>';
							}
							echo '<div class="cat_portfolio">' . $cat_name . '</div>';
						endif;
						echo '</div></div></div></div></div>';
						?>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
	}
}

/**
 * Add google analytics & facebook pixel code
 */
if ( ! function_exists( 'thim_add_marketing_code' ) ) {
	function thim_add_marketing_code() {
		$theme_options_data = get_theme_mods();
		if ( ! empty( $theme_options_data['thim_google_analytics'] ) ) {
			?>
			<script>
				(function (i, s, o, g, r, a, m) {
					i['GoogleAnalyticsObject'] = r;
					i[r] = i[r] || function () {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date();
					a = s.createElement(o),
						m = s.getElementsByTagName(o)[0];
					a.async = 1;
					a.src = g;
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

				ga('create', '<?php echo esc_html( $theme_options_data['thim_google_analytics'] ); ?>', 'auto');
				ga('send', 'pageview');
			</script>
			<?php
		}
		if ( ! empty( $theme_options_data['thim_facebook_pixel'] ) ) {
			?>
			<script>
				!function (f, b, e, v, n, t, s) {
					if (f.fbq) return;
					n = f.fbq = function () {
						n.callMethod ?
							n.callMethod.apply(n, arguments) : n.queue.push(arguments)
					};
					if (!f._fbq) f._fbq = n;
					n.push = n;
					n.loaded = !0;
					n.version = '2.0';
					n.queue = [];
					t = b.createElement(e);
					t.async = !0;
					t.src = v;
					s = b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t, s)
				}(window, document, 'script',
					'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '<?php echo esc_html( $theme_options_data['thim_facebook_pixel'] ); ?>');
				fbq('track', 'PageView');
			</script>
			<noscript>
				<img height="1" width="1" style="display:none"
					 src="https://www.facebook.com/tr?id=<?php echo esc_attr( $theme_options_data['thim_facebook_pixel'] ); ?>&ev=PageView&noscript=1"/>
			</noscript>
			<?php
		}
	}
}
add_action( 'wp_footer', 'thim_add_marketing_code' );

/**
 * Field name custom css theme mods.
 */
if ( ! function_exists( 'thim_course_builder_field_name_custom_css_theme' ) ) {
	function thim_course_builder_field_name_custom_css_theme() {
		return 'thim_custom_css';
	}
}
add_filter( 'thim_core_field_name_custom_css_theme', 'thim_course_builder_field_name_custom_css_theme' );

/**
 * Add custom JS
 */
if ( ! function_exists( 'thim_add_custom_js' ) ) {
	function thim_add_custom_js() {
		$custom_js = get_theme_mod( 'thim_custom_js', '' );

		if ( ! empty( $custom_js ) ) {
			if ( strpos( $custom_js, '</script>' ) !== false ) {
				echo $custom_js;
			} else {
				?>
				<script data-cfasync="false" type="text/javascript">
					<?php echo $custom_js; ?>
				</script>
				<?php
			}
		}

		//Add code js to open login-popup if not logged in.
		if ( class_exists( 'LearnPress' ) ) {
			if ( is_singular( 'lp_course' ) ) {
				?>
				<script data-cfasync="true" type="text/javascript">

					(function ($) {
						"use strict";

						$(document).on('click touch', 'body:not(".logged-in") .enroll-course .button-enroll-course, body:not(".logged-in") form.purchase-course:not(".guest_checkout") .button', function (e) {
							e.preventDefault();

							if ($('body').hasClass('lp_login_popup')) {
								$('.thim-login-popup .login').trigger('click');

							} else {
								window.location.href = $(this).parent().find('input[name=redirect_to]').val();
							}

						});
					})(jQuery);
				</script>
				<?php
			}
		}

		if ( class_exists( 'WPEMS' ) ) {

			if ( is_singular( 'tp_event' ) ) {
				?>
				<script data-cfasync="true" type="text/javascript">

					(function ($) {
						"use strict";

						if ($('body').hasClass('event_login_popup') && $('.thim-login-popup').length) {
							$(document).on('click touch', 'body:not(".logged-in") .widget_book-event .event_auth_button', function (e) {
								e.preventDefault();
								$('.thim-login-popup .login').trigger('click');
							});
						}

					})(jQuery);
				</script>
				<?php
			}
		}
	}
}
add_action( 'wp_footer', 'thim_add_custom_js', 10000 );

add_action( 'wp_ajax_thim_gallery_popup', 'thim_gallery_popup' );
add_action( 'wp_ajax_nopriv_thim_gallery_popup', 'thim_gallery_popup' );
/**
 * Function ajax widget gallery-posts
 */
if ( ! function_exists( 'thim_gallery_popup' ) ) {
	function thim_gallery_popup() {
		global $post;
		$post_id = $_POST["post_id"];
		$post    = get_post( $post_id );

		$format = get_post_format( $post_id->ID );

		$error = true;
		$link  = get_edit_post_link( $post_id );
		ob_start();

		if ( $format == 'video' ) {
			$url_video = get_post_meta( $post_id, 'thim_video', true );
			if ( empty( $url_video ) ) {
				echo '<div class="thim-gallery-message"><a class="link" href="' . $link . '">' . esc_html__( 'This post doesn\'t have config video, please add the video!', 'course-builder' ) . '</a></div>';
			}
			// If URL: show oEmbed HTML
			if ( filter_var( $url_video, FILTER_VALIDATE_URL ) ) {
				if ( $oembed = @wp_oembed_get( $url_video ) ) {
					echo '<div class="video">' . $oembed . '</div>';
				}
			} else {
				echo '<div class="video">' . $url_video . '</div>';
			}

		} else {
			$image_id         = get_post_thumbnail_id( $post_id );
			$imgurl_thumbnail = wp_get_attachment_image_src( $image_id, 'full' );

			$images = thim_meta( 'thim_gallery', "type=image&single=false&size=full" );
			// Get category permalink
			if ( $imgurl_thumbnail ) {
				echo '<a href="' . $imgurl_thumbnail[0] . '">';
				echo '<img src="' . $imgurl_thumbnail[0] . '" />';
				echo '</a>';
			}

			if ( ! empty( $images ) ) {
				foreach ( $images as $k => $value ) {
					$url_image = $value['url'];
					if ( $url_image && $url_image != '' ) {
						echo '<a href="' . $url_image . '">';
						echo '<img src="' . $url_image . '" />';
						echo '</a>';
						$error = false;
					}
				}
			}
			if ( $error ) {
				if ( is_user_logged_in() ) {
					echo '<div class="thim-gallery-message"><a class="link" href="' . $link . '">' . esc_html__( 'This post doesn\'t have any gallery images, please add some!', 'course-builder' ) . '</a></div>';
				} else {
					echo '<div class="thim-gallery-message">' . esc_html__( 'This post doesn\'t have any gallery images, please add some!', 'course-builder' ) . '</div>';
				}

			}
		}

		$output = ob_get_contents();
		ob_end_clean();
		echo ent2ncr( $output );
		die();
	}
}

/**
 * Reset password failed
 */
if ( ! function_exists( 'thim_reset_password_failed' ) ) {
	function thim_reset_password_failed() {
		//setup your custom URL for redirection
		$url = add_query_arg( 'action', 'lostpassword', thim_get_login_page_url() );

		if ( empty( $_POST['user_login'] ) ) {
			$url = add_query_arg( 'empty', '1', $url );
			wp_redirect( $url );
			exit;
		} elseif ( strpos( $_POST['user_login'], '@' ) ) {
			$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
			if ( empty( $user_data ) ) {
				$url = add_query_arg( 'user_not_exist', '1', $url );
				wp_redirect( $url );
				exit;
			}
		} elseif ( ! username_exists( $_POST['user_login'] ) ) {
			$url = add_query_arg( 'user_not_exist', '1', $url );
			wp_redirect( $url );
			exit;
		}
	}
}
add_action( 'lostpassword_post', 'thim_reset_password_failed', 999 );

// Fix A Cookies Blocked Error
//setcookie( TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN );
//if ( SITECOOKIEPATH != COOKIEPATH ) {
//	setcookie( TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN );
//}

add_filter( 'theme_page_templates', 'thim_remove_page_template_slider_revolution' );
function thim_remove_page_template_slider_revolution( $pages_templates ) {
	unset( $pages_templates['../public/views/revslider-page-template.php'] );

	return $pages_templates;
}

/**
 * Check import demo data page-builder
 */
add_action( 'wp_ajax_thim_update_theme_mods', 'thim_import_demo_page_builder' );
if ( ! function_exists( 'thim_import_demo_page_builder' ) ) {
	function thim_import_demo_page_builder() {
		$thim_key   = sanitize_text_field( $_POST["thim_key"] );
		$thim_value = sanitize_text_field( $_POST["thim_value"] );
		if ( ! is_multisite() ) {
			$active_plugins = get_option( 'active_plugins' );

			if ( $thim_value == 'visual_composer' ) {
				if ( ( $key = array_search( 'siteorigin-panels/siteorigin-panels.php', $active_plugins ) ) !== false ) {
					unset( $active_plugins[$key] );
				}
				if ( ( $key = array_search( 'elementor/elementor.php', $active_plugins ) ) !== false ) {
					unset( $active_plugins[$key] );
				}
				if ( ( $key = array_search( 'anywhere-elementor/anywhere-elementor.php', $active_plugins ) ) !== false ) {
					unset( $active_plugins[$key] );
				}
				if ( ! in_array( 'js_composer/js_composer.php', $active_plugins ) ) {
					$active_plugins[] = 'js_composer/js_composer.php';
				}

			} else {
				if ( $thim_value == 'site_origin' ) {
					if ( ( $key = array_search( 'js_composer/js_composer.php', $active_plugins ) ) !== false ) {
						unset( $active_plugins[$key] );
					}
					if ( ( $key = array_search( 'elementor/elementor.php', $active_plugins ) ) !== false ) {
						unset( $active_plugins[$key] );
					}
					if ( ( $key = array_search( 'anywhere-elementor/anywhere-elementor.php', $active_plugins ) ) !== false ) {
						unset( $active_plugins[$key] );
					}
					if ( ! in_array( 'siteorigin-panels/siteorigin-panels.php', $active_plugins ) ) {
						$active_plugins[] = 'siteorigin-panels/siteorigin-panels.php';
					}

				} else {
					if ( $thim_value == 'elementor' ) {
						if ( ( $key = array_search( 'js_composer/js_composer.php', $active_plugins ) ) !== false ) {
							unset( $active_plugins[$key] );
						}
						if ( ( $key = array_search( 'siteorigin-panels/siteorigin-panels.php', $active_plugins ) ) !== false ) {
							unset( $active_plugins[$key] );
						}
						if ( ! in_array( 'elementor/elementor.php', $active_plugins ) ) {
							$active_plugins[] = 'elementor/elementor.php';
						}
						if ( ! in_array( 'anywhere-elementor/anywhere-elementor.php', $active_plugins ) ) {
							$active_plugins[] = 'anywhere-elementor/anywhere-elementor.php';
						}

					}
				}
			}
			update_option( 'active_plugins', $active_plugins );
		}

		if ( empty( $thim_key ) || empty( $thim_value ) ) {
			$output = 'update fail';
		} else {
			set_theme_mod( $thim_key, $thim_value );
			$output = 'update success';
		}

		echo ent2ncr( $output );
		die();
	}
}

// remove <br> tags from text widget content, from 4.8 version WP adds these tags
remove_filter( 'widget_text_content', 'wpautop' );

if ( ! function_exists( "thim_get_cat_courses" ) ) {
	function thim_get_cat_courses( $term = 'category', $show_all = '', $el = false ) {
		$args  = array(
			'pad_counts'   => 1,
			'hierarchical' => 1,
			'hide_empty'   => 1,
			'orderby'      => 'name',
			'menu_order'   => false
		);
		$terms = get_terms( $term, $args );
		$cats  = array();
		if ( $el == true ) {
			if ( $show_all ) {
				$cats['all'] = $show_all;
			}
		} else {
			if ( $show_all ) {
				$cats[$show_all] = 'all';
			}
		}
		if ( is_wp_error( $terms ) ) {
		} else {
			if ( empty( $terms ) ) {
			} else {
				foreach ( $terms as $term ) {
					if ( $el == true ) {
						$cats[$term->term_id] = $term->name;
					} else {
						$cats[$term->name] = $term->term_id;
					}
				}
			}
		}

		return $cats;
	}
}

/* Disable VC auto-update */
function thimpress_vc_disable_update() {
	if ( function_exists( 'vc_license' ) && function_exists( 'vc_updater' ) && ! vc_license()->isActivated() ) {
		remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10 );
		remove_filter(
			'pre_set_site_transient_update_plugins', array(
			vc_updater()->updateManager(),
			'check_update'
		)
		);

	}
}

add_action( 'admin_init', 'thimpress_vc_disable_update', 9 );