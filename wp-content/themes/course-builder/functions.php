<?php
/**
 * Theme functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * .*/

define( 'THIM_DIR', trailingslashit( get_template_directory() ) );
define( 'THIM_URI', trailingslashit( get_template_directory_uri() ) );
define( 'THIM_THEME_VERSION', '3.2.7');

if ( ! function_exists( 'thim_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function thim_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on this theme, use a find and replace
		 * to change 'course-builder' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'course-builder', THIM_DIR . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Add support Woocommerce
		add_theme_support( 'woocommerce' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'course-builder' ),
			)
		);

		if ( get_theme_mod( 'copyright_menu', true ) ) {
			register_nav_menus(
				array(
					'copyright_menu' => esc_html__( 'Copyright Menu', 'course-builder' ),
				)
			);
		}

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
		);

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support(
			'post-formats', array(
			'aside',
			'image',
			'video',
			'audio',
			'quote',
			'link',
			'gallery',
			'chat',
		)
		);

		add_theme_support( 'custom-background' );

		add_theme_support( 'thim-core' );


		add_theme_support( 'thim-demo-data' );

		add_theme_support( 'thim-extend-vc-sc' );

		add_post_type_support( 'page', 'excerpt' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Editor color palette.
		add_theme_support(
			'editor-color-palette', array(

			array(
				'name'  => esc_html__( 'Primary Color', 'course-builder' ),
				'slug'  => 'primary',
				'color' => get_theme_mod( 'body_primary_color', '#1EA69A' ),
			),

			array(
				'name'  => esc_html__( 'Title Color', 'course-builder' ),
				'slug'  => 'title',
				'color' => get_theme_mod( 'thim_font_title_color', '#202121' ),
			),

			array(
				'name'  => esc_html__( 'Body Color', 'course-builder' ),
				'slug'  => 'body',
				'color' => get_theme_mod( 'thim_font_body_color', '#888888' ),
			),

			array(
				'name'  => esc_html__( 'Border Color', 'course-builder' ),
				'slug'  => 'border',
				'color' => '#e7e7e7',
			),
		)
		);

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'course-builder' ),
					'shortName' => __( 'S', 'course-builder' ),
					'size'      => 13,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'course-builder' ),
					'shortName' => __( 'M', 'course-builder' ),
					'size'      => 16,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'course-builder' ),
					'shortName' => __( 'L', 'course-builder' ),
					'size'      => 30,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'course-builder' ),
					'shortName' => __( 'XL', 'course-builder' ),
					'size'      => 48,
					'slug'      => 'huge',
				),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'thim_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function thim_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'thim_content_width', 640 );
}

add_action( 'after_setup_theme', 'thim_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function thim_widgets_init() {
	unregister_sidebar( 'course-sidebar' );
	unregister_sidebar( 'archive-courses-sidebar' );
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'course-builder' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Appears in the Sidebar section of the site.', 'course-builder' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	if ( get_theme_mod( 'header_topbar_display', false ) ) {
		register_sidebar(
			array(
				'name'          => esc_attr__( 'Top bar', 'course-builder' ),
				'id'            => 'topbar',
				'description'   => esc_attr__( 'Display in top bar.', 'course-builder' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	if ( get_theme_mod( 'header_sidebar_right_display', true ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Header Right', 'course-builder' ),
				'id'            => 'header_right',
				'description'   => esc_html__( 'Appears in Header right.', 'course-builder' ),
				'before_widget' => '<div class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Below Main', 'course-builder' ),
			'id'            => 'after_main',
			'description'   => esc_html__( 'Display widgets in below main content.', 'course-builder' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);


	register_sidebar(
		array(
			'name'          => esc_html__( 'Below Off-Canvas Menu', 'course-builder' ),
			'id'            => 'off_canvas_menu',
			'description'   => esc_html__( 'Display below off-canvas menu.', 'course-builder' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	$footer_columns = get_theme_mod( 'footer_columns', 6 );
	if ( $footer_columns ) {
		for ( $i = 1; $i <= $footer_columns; $i ++ ) {
			register_sidebar(
				array(
					'name'          => sprintf( esc_attr__( 'Footer Column %s', 'course-builder' ), $i ),
					'id'            => 'footer-sidebar-' . $i,
					'description'   => sprintf( esc_attr__( 'Display widgets in footer column %s.', 'course-builder' ), $i ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				)
			);
		}
	}

	/**
	 * Not remove
	 * Function create sidebar on wp-admin.
	 */
	$sidebars = apply_filters( 'thim_core_list_sidebar', array() );
	if ( count( $sidebars ) > 0 ) {
		foreach ( $sidebars as $sidebar ) {
			$new_sidebar = array(
				'name'          => $sidebar['name'],
				'id'            => $sidebar['id'],
				'description'   => '',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			);

			register_sidebar( $new_sidebar );
		}
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Below Footer', 'course-builder' ),
			'id'            => 'footer_sticky',
			'description'   => esc_html__( 'Display below of footer.', 'course-builder' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	if ( get_theme_mod( 'learnpress_top_sidebar_archive_display', true ) ) {
		register_sidebar(
			array(
				'name'          => esc_attr__( 'Courses - Widget Area Top', 'course-builder' ),
				'id'            => 'top_sidebar_courses',
				'description'   => esc_attr__( 'Display widgets on top of course archive pages.', 'course-builder' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);
	}

	if ( class_exists( 'LearnPress' ) ) {

		register_sidebar(
			array(
				'name'          => esc_attr__( 'Courses - Sidebar', 'course-builder' ),
				'id'            => 'sidebar_courses',
				'description'   => esc_attr__( 'Sidebar of Courses', 'course-builder' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop - Sidebar', 'course-builder' ),
				'id'            => 'sidebar_shop',
				'description'   => esc_html__( 'Sidebar Of Shop', 'course-builder' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<div class="sc-heading article_heading"><h3 class="widget-title heading_primary">',
				'after_title'   => '</h3></div>',
			)
		);
	}

	if ( class_exists( 'bbPress' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Forums - Sidebar', 'course-builder' ),
				'id'            => 'sidebar_forums',
				'description'   => esc_html__( 'Sidebar of Forums', 'course-builder' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	if ( class_exists( 'BuddyPress' ) ) {
		unregister_sidebar( 'buddypress' );
		unregister_sidebar( 'sidebar-buddypress-members' );
		unregister_sidebar( 'sidebar-buddypress-groups' );
	}

	if ( class_exists( 'WPEMS' ) ) {
		register_sidebar(
			array(
				'name'          => esc_attr__( 'Event - Sidebar', 'course-builder' ),
				'id'            => 'sidebar_events',
				'description'   => esc_attr__( 'Sidebar of Events', 'course-builder' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

}

add_action( 'widgets_init', 'thim_widgets_init', 100 );

/**
 * Enqueue scripts and styles.
 */
function thim_scripts() {
	global $wp_query;

	// Enqueue Styles
	wp_enqueue_style( 'fontawesome', THIM_URI . 'assets/css/libs/awesome/font-awesome.css', array() );
	wp_enqueue_style( 'bootstrap', THIM_URI . 'assets/css/libs/bootstrap/bootstrap.css', array() );
	wp_enqueue_style( 'ionicons', THIM_URI . 'assets/css/libs/ionicons/ionicons.css', array() );
	wp_enqueue_style( 'magnific-popup', THIM_URI . 'assets/css/libs/magnific-popup/main.css', array() );
	wp_enqueue_style( 'owl-carousel', THIM_URI . 'assets/css/libs/owl-carousel/owl.carousel.css', array() );
	// End: Enqueue Styles

	if ( is_multisite() ) {
		wp_enqueue_style( 'thim-style', THIM_URI . 'style.css', array(), THIM_THEME_VERSION );
	} else {
		wp_enqueue_style( 'thim-style', get_stylesheet_uri(), array(), THIM_THEME_VERSION );
	}

	$var_css = '
			:root {
				--thim-body-primary-color: ' . get_theme_mod( 'body_primary_color', '#18C1F0' ) . ';
 			}
		';
	wp_add_inline_style( 'thim-style', $var_css );

	// Style default
	if ( ! thim_plugin_active( 'thim-core' ) ) {
		wp_enqueue_style( 'thim-default', THIM_URI . 'inc/data/default.css', array() );
	}

	//	RTL
	if ( get_theme_mod( 'feature_rtl_support', false ) || is_rtl() ) {
		wp_enqueue_style( 'thim-style-rtl', THIM_URI . 'style-rtl.css', array(), THIM_THEME_VERSION );
	}

	//	Enqueue Scripts
	wp_register_script( 'tether', THIM_URI . 'assets/js/libs/1_tether.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'thim-change-layout', THIM_URI . 'assets/js/libs/change-layout.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'circle-progress', THIM_URI . 'assets/js/libs/circle-progress.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'isotope', THIM_URI . 'assets/js/libs/isotope.pkgd.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'cookie', THIM_URI . 'assets/js/libs/jquery.cookie.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'flexslider', THIM_URI . 'assets/js/libs/jquery.flexslider-min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'variations', THIM_URI . 'assets/js/libs/variations-form.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'magnific-popup', THIM_URI . 'assets/js/libs/jquery.magnific-popup.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'thim-content-slider', THIM_URI . 'assets/js/libs/jquery.thim-content-slider.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'waypoints', THIM_URI . 'assets/js/libs/jquery.waypoints.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'owlcarousel', THIM_URI . 'assets/js/libs/owl.carousel.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'sly', THIM_URI . 'assets/js/libs/sly.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'theia-sticky-sidebar', THIM_URI . 'assets/js/libs/theia-sticky-sidebar.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_register_script( 'toggle-tabs', THIM_URI . 'assets/js/libs/toggle-tabs.js', array( 'jquery' ), THIM_THEME_VERSION, true );

	if ( ! is_singular( 'lp_course' ) ) {
		wp_enqueue_script( 'bootstrap', THIM_URI . 'assets/js/libs/bootstrap.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	}

	// End: Enqueue Scripts
	if ( ( is_archive() || 'post' == get_post_type() ) && ( 'loadmore' == get_theme_mod( 'blog_archive_nav_style', 'pagination' ) || ( ( isset( $_GET['pagination'] ) ? $_GET['pagination'] : '' ) === 'loadmore' ) ) ) {
		wp_enqueue_script(
			'thim-loadmore', THIM_URI . 'assets/js/libs/thim-loadmore.js', array(
			'jquery',
			'thim-change-layout'
		), '', true
		);
		wp_localize_script(
			'thim-loadmore', 'thim_loadmore_params', array(
			'ajaxurl'      => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			'posts'        => serialize( $wp_query->query_vars ), // everything about your loop is here
			'current_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			'max_page'     => $wp_query->max_num_pages
		)
		);
	}

	wp_enqueue_script(
		'thim-main', THIM_URI . 'assets/js/main.min.js', array(
		'jquery',
		'cookie',
		'owlcarousel',
		'theia-sticky-sidebar',
	), THIM_THEME_VERSION, true
	);

	if ( get_theme_mod( 'feature_smoothscroll', false ) ) {
		wp_enqueue_script( 'smoothscroll', THIM_URI . 'assets/js/libs/smoothscroll.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	}

	// End: Enqueue Scripts

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Dequeue script & CSS of WP Events Manager plugin.
	 */
	if ( is_home() ) {
		wp_dequeue_script( 'wpems-countdown-js' );
		wp_dequeue_script( 'wpems-countdown-plugin-js' );
	}
	wp_dequeue_script( 'wpems-owl-carousel-js' );
	wp_dequeue_style( 'wpems-owl-carousel-css' );
	wp_dequeue_style( 'wpems-magnific-popup-css' );
	wp_dequeue_script( 'wpems-magnific-popup-js' );


	/**
	 * learnPress-announcements
	 */
	if ( ! is_singular( 'lp_course' ) ) {
		wp_dequeue_style( 'jquery-ui-accordion' );
		wp_dequeue_style( 'lp_announcements' );
	}


	if ( is_singular( 'product' ) ) {
		wp_enqueue_script( 'prettyPhoto' );
		wp_enqueue_script( 'prettyPhoto-init' );
		wp_enqueue_style( 'woocommerce_prettyPhoto_css' );
	}

	/**
	 * Dequeue unnecessary js library in homepage
	 * */
	if ( is_front_page() ) {
		wp_dequeue_script( 'webfont' );
		if ( ! is_user_logged_in() ) {
			wp_dequeue_style( 'dashicons' );
		}
	}


}

add_action( 'wp_enqueue_scripts', 'thim_scripts', 100 );


/**
 * Implement the theme wrapper.
 */
include_once THIM_DIR . 'inc/libs/theme-wrapper.php';
include_once THIM_DIR . 'inc/libs/down_image_size.php';

/**
 * Implement the Custom Header feature.
 */
include_once THIM_DIR . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
include_once THIM_DIR . 'inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
include_once THIM_DIR . 'inc/extras.php';

/**
 * Extra setting on plugins, export & import with demo data.
 */
include_once THIM_DIR . 'inc/data/extra-plugin-settings.php';

/**
 * Metabox
 *
 * Add Custom metabox
 */
include_once THIM_DIR . 'inc/libs/Tax-meta-class/Tax-meta-class.php';
include_once THIM_DIR . 'inc/metabox.php';

/**
 * Load Jetpack compatibility file.
 */
include_once THIM_DIR . 'inc/jetpack.php';

/**
 * Custom wrapper layout for theme
 */
include_once THIM_DIR . 'inc/wrapper-layout.php';

/**
 * Custom widgets
 */
include_once THIM_DIR . 'inc/widgets/widgets.php';

/**
 * Custom functions
 */
include_once THIM_DIR . 'inc/custom-functions.php';

/**
 * Customizer additions.
 */
include_once THIM_DIR . 'inc/customizer.php';

/**
 * Custom LearnPress functions
 * */

if ( is_admin() && current_user_can( 'manage_options' ) ) {
	include_once THIM_DIR . 'inc/admin/installer/installer.php';
	include_once THIM_DIR . 'inc/admin/plugins-require.php';
}


/**
 * Woocommerce custom functions
 */
if ( class_exists( 'WooCommerce' ) ) {
	include_once THIM_DIR . 'woocommerce/custom-functions.php';
}

/**
 * WP Events Manager custom functions
 */
if ( class_exists( 'WPEMS' ) ) {
	include_once THIM_DIR . 'wp-events-manager/custom-functions.php';
}

/**
 * BuddyPress custom functions
 */
if ( class_exists( 'BuddyPress' ) ) {
	include_once THIM_DIR . 'buddypress/custom-functions.php';
}


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}