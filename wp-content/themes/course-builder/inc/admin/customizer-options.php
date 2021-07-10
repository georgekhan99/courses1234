<?php
/**
 * Create Course_Builder_Customize
 *
 */

/**
 * Class Thim_Customize_Options
 */
class Thim_Customize_Options {
	/**
	 * Thim_Customize_Options constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'thim_deregister' ] );
		add_action( 'thim_customizer_register', [ $this, 'thim_create_customize_options' ] );
	}

	/**
	 * Deregister customize default unnecessary
	 *
	 * @param $wp_customize
	 */
	public function thim_deregister( $wp_customize ) {
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'header_image' );
		$wp_customize->remove_control( 'blogdescription' );
		$wp_customize->remove_control( 'blogname' );
		$wp_customize->remove_control( 'display_header_text' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'bp_nouveau_customizer_sections' );
		$wp_customize->remove_section( 'custom_css' );
		// Rename existing section
		$wp_customize->add_section( 'title_tagline', array(
			'title'    => esc_html__( 'Logo', 'course-builder' ),
			'panel'    => 'general',
			'priority' => 20,
		) );
	}

	/**
	 * Create customize
	 *
	 * @param $wp_customize
	 */
	public function thim_create_customize_options( $wp_customize ) {

		//	Auto include sections
		$DIR = THIM_DIR . "inc/admin/customizer-sections/";

		include $DIR . "blog-general.php";
		include $DIR . "blog-layouts.php";
		include $DIR . "blog-sharing.php";
		include $DIR . "blog.php";

		if ( class_exists( 'WPEMS' ) ) {
			include $DIR . "event-layouts.php";
			include $DIR . "events-sharing.php";
			include $DIR . "event-features.php";
			include $DIR . "events.php";
            include $DIR . "pagetitle-event.php";
		}

        if ( class_exists( 'BuddyPress' ) ) {
            include $DIR . "buddypress.php";
        }

		include $DIR . "footer-copyright.php";
		include $DIR . "footer-options.php";
		include $DIR . "footer.php";
		include $DIR . "general-custom-js.php";
		include $DIR . "general-404-page.php";
		include $DIR . "general-custom-css.php";
		include $DIR . "general-features.php";
		include $DIR . "general-layouts.php";
		include $DIR . "general-logo.php";
		include $DIR . "general-styling-boxed-bg.php";
		include $DIR . "general-styling.php";
		include $DIR . "general-typography-heading.php";
		include $DIR . "general-utilities.php";
		include $DIR . "general-sidebar.php";
		include $DIR . "general-typography.php";
		include $DIR . "general.php";
		include $DIR . "header-general.php";
		include $DIR . "header-main-menu.php";
		include $DIR . "header-sticky-menu.php";
		include $DIR . "header-sub-menu.php";
		include $DIR . "header-topbar.php";
		include $DIR . "header.php";
		include $DIR . "widgets.php";
		include $DIR . "nav-menus.php";

		if ( class_exists( 'LearnPress' ) ) {
			include $DIR . "learnpress-archive.php";
			include $DIR . "learnpress-layouts.php";
			include $DIR . "learnpress-sharing.php";
			include $DIR . "learnpress-features.php";
			include $DIR . "learnpress-single.php";
			include $DIR . "learnpress.php";
            include $DIR . "pagetitle-courses.php";
		}

		include $DIR . "pagetitle-404-page.php";
		include $DIR . "pagetitle-breadcrumb.php";
		include $DIR . "pagetitle-styling.php";
		include $DIR . "pagetitle.php";
		include $DIR . "responsive.php";
		include $DIR . "responsive-menu-header.php";
		include $DIR . "responsive-menu-offcanvas.php";

		if ( class_exists( 'bbPress' ) ) {
            include $DIR . "forums.php";
            include $DIR . "forums-general.php";
            include $DIR . "pagetitle-forums.php";
        }

		if ( class_exists( 'WooCommerce' ) ) {
			include $DIR . "woocommerce-layouts.php";
			include $DIR . "woocommerce-settings.php";
			include $DIR . "woocommerce.php";
            include $DIR . "pagetitle-products.php";
		}

		if ( class_exists( 'Thim_Portfolio' ) ) {
            include $DIR . "portfolio-layout.php";
            include $DIR . "portfolio.php";
            include $DIR . "pagetitle-portfolio.php";
        }

        if ( class_exists( 'LP_Addon_Collections' ) ) {
            include $DIR . "collection-settings.php";
            include $DIR . "collection-layouts.php";
            include $DIR . "collection.php";
            include $DIR . "pagetitle-collections.php";
        }

	}
}

$thim_customize = new Thim_Customize_Options();