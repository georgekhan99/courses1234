<?php

/**
 * Config demo data
 */

$is_support = get_theme_support( 'thim-demo-data' );

if ( ! class_exists( 'Thim_DemoData_Config' ) ) {
	class Thim_DemoData_Config {

		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_filter( 'thim_theme_links_guide_user', array( $this, 'config_links_guide_user' ), 9999 );
			add_filter( 'thim_core_importer_base_path_demo_data', array( $this, 'base_path_demo_data' ) );
			add_filter( 'thim_core_list_child_themes', array( $this, 'list_child_themes' ) );
		}

		function init() {
			$is_support = get_theme_support( 'thim-demo-data' );

			if ( ! $is_support ) {
				return;
			}

			add_filter( 'thim_core_importer_base_uri_demo_data', array( $this, 'base_uri_demo_data' ) );
			add_filter( 'thim_core_importer_base_path_demo_data', array( $this, 'base_path_demo_data' ) );
			add_filter( 'thim_core_importer_directory_revsliders', array( $this, 'directory_revsliders' ) );
			add_filter( 'thim_core_importer_path_demo_image', array( $this, 'path_demo_image' ) );
			add_filter( 'thim_core_importer_uri_demo_image', array( $this, 'uri_demo_image' ) );
			add_action( 'thim_core_importer_next_step', array( $this, 'download_demo_data' ), 10, 2 );
		}


		/**
		 * Info theme into dashboard
		 * @return array
		 */
		function config_links_guide_user() {
			return array(
				'docs'      => 'http://docspress.thimpress.com/course-builder/',
				'support'   => 'https://thimpress.com/forums/forum/course-builder/',
				'knowledge' => 'https://thimpress.com/knowledge-base/',
//				'video_introduce' => 'https://www.youtube.com/watch?v=IkBeINhkc70',
//				'video_customize' => 'https://www.youtube.com/watch?v=3xhKx2rSQ08',
			);
		}


		/**
		 * List child themes.
		 *
		 * @return array
		 */
		function list_child_themes() {
			return array(
				'course-builder-child' => array(
					'name'       => 'Course Builder Child',
					'slug'       => 'course-builder-child',
					'screenshot' => 'https://raw.githubusercontent.com/ThimPressWP/demo-data/master/course-builder/child-themes/course-builder-child.png',
					'source'     => 'https://thimpresswp.github.io/demo-data/course-builder/child-themes/course-builder-child.zip',
					'version'    => '1.0.0'
				),
			);
		}


		/**
		 * Download and unzip demo data.
		 *
		 * @since 1.1.0
		 *
		 * @param $done
		 * @param $next
		 *
		 * @throws Thim_Error
		 */
		function download_demo_data( $done, $next ) {
			if ( $done !== 'plugins' ) {
				return;
			}

			$demo_data = Thim_Importer_AJAX::get_current_demo_data();
			$demo_key  = $demo_data['demo'];
			$url       = 'https://thimpresswp.github.io/demo-data/course-builder/demos/' . $demo_key . '.zip';

			$package = Thim_File_Helper::download_file( $url );
			if ( is_wp_error( $package ) ) {
				throw Thim_Error::create( $package->get_error_message(), 8, esc_attr__( 'Please try again later.', 'course-builder' ) );
			}

			$path_file = THIM_CB_PATH . 'data/demos/' . $demo_key . '.zip';
			$dir       = pathinfo( $path_file, PATHINFO_DIRNAME );
			$unzip     = Thim_File_Helper::unzip_file( $package, $dir );
			if ( is_wp_error( $unzip ) ) {
				throw Thim_Error::create( $unzip->get_error_message(), 0, esc_attr__( 'Please try again later.', 'course-builder' ) );
			}
		}


		/**
		 * Filter base uri demo data.
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		function base_uri_demo_data() {
			return THIM_CB_URL . 'data/demos/';
		}

		/**
		 * Filter base path demo data.
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		function base_path_demo_data() {
			return THIM_CB_PATH . 'data/demos/';
		}

		/**
		 * Filter directory revolution sliders.
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		function directory_revsliders() {
			return 'https://thimpresswp.github.io/demo-data/course-builder/revsliders/';
		}

		/**
		 * Filter path demo image.
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		function path_demo_image() {
			return THIM_CB_PATH . 'assets/images/demo-image.jpg';
		}

		/**
		 * Filter uri demo image.
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		function uri_demo_image() {
			return THIM_CB_URL . 'assets/images/demo-image.jpg';
		}

	}

	new Thim_DemoData_Config();
}