<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Courses_Carousel' ) ) {

	class Thim_SC_Courses_Carousel {

		/**
		 * Shortcode name
		 * @var string
		 */
		protected $name = '';

		/**
		 * Shortcode description
		 * @var string
		 */
		protected $description = '';

		/**
		 * Shortcode base
		 * @var string
		 */
		protected $base = '';


		public function __construct() {

			//======================== CONFIG ========================
			$this->name        = esc_attr__( 'Thim: Courses Carousel', 'course-builder' );
			$this->description = esc_attr__( 'Display a courses carousel.', 'course-builder' );
			$this->base        = 'courses-carousel';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-courses-carousel', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/courses-carousel-custom.js', array(
				'jquery',
				'owlcarousel'
			),THIM_CB_VERSION, true );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map(
				array(
					'name'        => $this->name,
					'base'        => 'thim-' . $this->base,
					'category'    => esc_attr__( 'Thim Shortcodes', 'course-builder' ),
					'description' => $this->description,
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-courses-carousel.png',
					'params'      => array(
						// Title Course

						// Thumbnail Course
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Show courses by:', 'course-builder' ),
							'param_name'  => 'list_courses',
							'admin_label' => true,
							'value'       => array(
								esc_html__( 'Latest', 'course-builder' )   => 'latest',
								esc_html__( 'Popular', 'course-builder' )  => 'popular',
								esc_html__( 'Category', 'course-builder' ) => 'category',
							)
						),

						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Select Category', 'course-builder' ),
							'param_name'  => 'cat_courses',
							'admin_label' => true,
							"description" => esc_attr__( "Select which category if you choose to show courses by category.", 'course-builder' ),
							'dependency'  => array(
								'element' => 'list_courses',
								'value'   => 'category',
							),
							'value'       => thim_get_cat_courses( 'course_category', 'All' ),
						),

						array(
							'type'             => 'checkbox',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Show Featured Courses', 'course-builder' ),
							'param_name'       => 'featured_courses',
							'edit_field_class' => 'vc_col-sm-6',
							'description'      => esc_html__( 'Check yes to only show the featured courses.', 'course-builder' ),
							'value'            => '',
						),

						array(
							"type"             => "dropdown",
							"heading"          => esc_attr__( "Styles", 'course-builder' ),
							"param_name"       => "style",
							'edit_field_class' => 'vc_col-sm-6',
							"value"            => array(
								esc_attr__( "Default", 'course-builder' ) => 'default',
								esc_attr__( "Style 1", 'course-builder' ) => 'style-1',
							),
						),

						array(
							'type'             => 'checkbox',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Show arrow navigation', 'course-builder' ),
							'param_name'       => 'course_navigation',
							'edit_field_class' => 'vc_col-sm-6',
							'std'              => '',
						),
						array(
							'type'             => 'checkbox',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Show dots navigation', 'course-builder' ),
							'param_name'       => 'course_dots',
							'edit_field_class' => 'vc_col-sm-6',
							'std'              => ''
						),
						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of columns', 'course-builder' ),
							'param_name'       => 'course_columns',
							'value'            => array(
								esc_attr__( "3", 'course-builder' ) => '3',
								esc_attr__( "4", 'course-builder' ) => '4',
							),
							'edit_field_class' => 'vc_col-sm-6',
						),
						array(
							'type'             => 'number',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of visible courses:', 'course-builder' ),
							'description'      => esc_html__( 'Number of courses to display in this block', 'course-builder' ),
							'param_name'       => 'course_number',
							'edit_field_class' => 'vc_col-sm-6',
							'value'            => '3',
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Courses Carousel shortcode to use in CSS customizations.', 'course-builder' ),
						),
					)
				)
			);
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts ) {

			$params = shortcode_atts( array(
				'list_courses'      => 'latest',
				'cat_courses'       => '',
				'style'             => 'default',
				'featured_courses'  => '',
				'course_navigation' => '',
				'course_dots'       => '',
				'course_columns'    => '3',
				'course_number'     => '3',
				'course_post'       => '',
				'el_class'          => '',

			), $atts );

			$params['course_carousel'] = $this->base;

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
			wp_enqueue_script( 'thim-courses-carousel' );

			thim_get_template( $path . $params['style'], array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

		// Get list category
		public function thim_get_course_categories( $cats = false ) {
			global $wpdb;
			$query = $wpdb->get_results( $wpdb->prepare(
				"
				  SELECT      t1.term_id, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  AND t1.count > %d
				  ",
				'course_category', 0
			) );

			if ( empty( $cats ) ) {
				$cats = array();
			}

			$cats[ esc_attr__( 'All', 'course-builder' ) ] = 0;

			if ( ! empty( $query ) ) {
				foreach ( $query as $key => $value ) {
					$cats[ $value->term_id ] = $value->name;
				}
			}

			return $cats;

		}

	}

	new Thim_SC_Courses_Carousel();
}