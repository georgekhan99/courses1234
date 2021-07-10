<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Courses_Block_1' ) ) {

	class Thim_SC_Courses_Block_1 {

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
			$this->name        = esc_attr__( 'Thim: Courses - Block 1', 'course-builder' );
			$this->description = esc_attr__( 'Display a courses block', 'course-builder' );
			$this->base        = 'courses-block-1';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );

		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-courses-block-1', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/courses-block-1-custom.js', array(
				'jquery',
				'magnific-popup'
			),THIM_CB_VERSION, true );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-courses-block-1.png',
				'description' => $this->description,
				'params'      => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Show courses by', 'course-builder' ),
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
						'value'       => thim_get_cat_courses('course_category'),
						"description" => esc_attr__( "Select which category if you choose to show courses by category.", 'course-builder' ),
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Featured Courses?', 'course-builder' ),
						'description' => esc_html__( 'Check yes to only show the featured courses.', 'course-builder' ),
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'param_name'  => 'featured_courses',
						'admin_label' => true,
					),
				),
			) );
		}

		/**
		 * @param $atts
		 *
		 * @return string
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'list_courses'     => 'latest',
				'cat_courses'      => '',
				'featured_courses' => '',
			), $atts );

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
			wp_enqueue_script( 'thim-courses-block-1' );

			thim_get_template( $path . 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}


	}

	new Thim_SC_Courses_Block_1();
}