<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Enroll_Course' ) ) {

	class Thim_SC_Enroll_Course {

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
			$this->name        = esc_attr__( 'Thim: Enroll Course', 'course-builder' );
			$this->description = esc_attr__( 'Display button Enroll Course by ID.', 'course-builder' );
			$this->base        = 'enroll-course';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
					'name'        => $this->name,
					'base'        => 'thim-' . $this->base,
					'category'    => esc_attr__( 'Thim Shortcodes', 'course-builder' ),
					'description' => $this->description,
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-enroll-course.png',
					'params'      => array(
						array(
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Course ID', 'course-builder' ),
							'description' => esc_html__( 'Course ID shows in the URL when viewing a course single page', 'course-builder' ),
							'param_name'  => 'id_course',
							'value'       => '3946',
						),
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Hide Course Excerpt', 'course-builder' ),
							'value'       => array(
								esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
							),
							'param_name'  => 'hide_text',
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Enroll Course shortcode to use in CSS customizations.', 'course-builder' ),
						),
					),
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
				'id_course' => '3946',
				'hide_text' => '',
				'el_class'  => '',
			), $atts );

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
			thim_get_template( $path . 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}
	}

	new Thim_SC_Enroll_Course();
}
