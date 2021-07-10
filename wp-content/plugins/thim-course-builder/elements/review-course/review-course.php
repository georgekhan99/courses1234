<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Review_Course' ) ) {

	class Thim_SC_Review_Course {

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
			$this->name        = esc_attr__( 'Thim: Course Reviews', 'course-builder' );
			$this->description = esc_attr__( 'Display reviews for course', 'course-builder' );
			$this->base        = 'review-course';
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-course-review.png',
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
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Number of reviews', 'course-builder' ),
							'param_name'  => 'number_review',
							'value'       => '3',
							'description' => 'Enter number of reviews you want to show.'
						),
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Show button Read More', 'course-builder' ),
							'value'       => array(
								esc_html__( 'yes', 'course-builder' ) => esc_attr( 'yes' ),
							),
							'param_name'  => 'read_more',
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Course Reviews shortcode to use in CSS customizations.', 'course-builder' ),
						),
					),
				)
			);
		}

		/**
		 * @param $atts
		 *
		 * @return string
		 */
		public function shortcode( $atts ) {

			$params = shortcode_atts( array(
				'id_course'     => '3946',
				'number_review' => '3',
				'read_more'     => '',
				'el_class'      => '',
			), $atts );

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
			thim_get_template( $path. 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}
	}

	new Thim_SC_Review_Course();
}
