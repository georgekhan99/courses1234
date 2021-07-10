<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Instructors' ) ) {

	class Thim_SC_Instructors {

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
			$this->name        = esc_attr__( 'Thim: Instructors', 'course-builder' );
			$this->description = esc_attr__( 'Display list of instructors', 'course-builder' );
			$this->base        = 'instructors';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
			add_action( 'wp_ajax_thim_instructors_load', array( $this, 'instructors_load' ) );
			add_action( 'wp_ajax_nopriv_thim_instructors_load', array( $this, 'instructors_load' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-instructors', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/instructors-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'description' => $this->description,
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-instructors.png',
				'params'      => array(

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Columns', 'course-builder' ),
						'param_name'  => 'columns',
						'admin_label' => true,
						'value'       => array(
							esc_html__( '3', 'course-builder' ) => '3',
							esc_html__( '4', 'course-builder' ) => '4',
							esc_html__( '6', 'course-builder' ) => '2',
						),

						'edit_field_class' => 'vc_col-xs-4',
					),

					array(
						'type'             => 'number',
						'heading'          => esc_html__( 'Limit', 'course-builder' ),
						'param_name'       => 'limit',
						'value'            => '20',
						'admin_label'      => true,
						'edit_field_class' => 'vc_col-xs-4',
					),

					array(
						'type'             => 'textfield',
						'admin_label'      => true,
						'heading'          => esc_html__( 'Text Load More', 'course-builder' ),
						'param_name'       => 'text_load_more',
						'value'            => '',
						'edit_field_class' => 'vc_col-xs-4',
						'dependency'       => array(
							'element' => 'instructor_style',
							'value'   => array(
								'courses_instructor',
								'all_instructor',
								'home1_courses_instructor'
							)
						)
					),

					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__( 'Link Load More', 'course-builder' ),
						'param_name'  => 'link_load_more',
						'value'       => '',
						'dependency'  => array(
							'element' => 'instructor_style',
							'value'   => array( 'home1_courses_instructor' )
						)
					),

					array(
						"type"        => "dropdown",
						"heading"     => esc_attr__( "Instructor Style", 'course-builder' ),
						"param_name"  => "instructor_style",
						"admin_label" => true,
						"value"       => array(
							esc_attr__( 'Courses Instructor', 'course-builder' )      => 'courses_instructor',
							esc_attr__( 'All Administrator + Instructor', 'course-builder' )          => 'all_instructor',
							esc_attr__( 'Courses Instructor Corporate', 'course-builder' ) => 'home1_courses_instructor',
							esc_attr__( 'Courses Instructor Test Prep', 'course-builder' ) => 'home_courses_instructor',
						),
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__( 'Extra class', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'course-builder' ),
					),

				)
			) );
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'columns'          => '',
				'limit'            => '20',
				'text_load_more'   => '',
				'link_load_more'   => '',
				'instructor_style' => 'courses_instructor',
				'el_class'         => '',
			), $atts );

			$params['rank']         = 0;
			$params['current_page'] = $params['page'] = $page = 1;
			$params['sc-name']      = $this->base;

			$path                   = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
 			ob_start();
			wp_enqueue_script( 'thim-sc-instructors' );
 			thim_get_template( $path . 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}

		public function instructors_load() {
			$params = htmlspecialchars_decode( $_POST['params'] );
			$params = json_decode( str_replace( '\\', '', $params ), true );

			$params['page']    = $page = $_POST['page'];
			$params['rank']    = $_POST['rank'];
			$params['sc-name'] = $this->base;
			$max_page          = $_POST['max_page'];
			ob_start();
			if ( $params['instructor_style'] == 'all_instructor' ) {
				thim_get_template( 'item2', array( 'params' => $params ), $this->base . '/tpl/' );
			} else {
				thim_get_template( 'item', array( 'params' => $params ), $this->base . '/tpl/' );
			}

			$html = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();

			wp_send_json_success( array( 'html' => $html, 'max_num_pages' => $max_page ) );
			wp_die();
		}
	}

	new Thim_SC_Instructors();
}