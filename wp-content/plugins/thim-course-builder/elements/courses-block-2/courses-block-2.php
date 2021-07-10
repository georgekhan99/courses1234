<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Courses_Block_2' ) ) {

	class Thim_SC_Courses_Block_2 {

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
			$this->name        = esc_attr__( 'Thim: Courses - Block 2', 'course-builder' );
			$this->description = esc_attr__( 'Display a courses block', 'course-builder' );
			$this->base        = 'courses-block-2';
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
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-courses-block-2.png',
				'description' => $this->description,
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Course Block Title:', 'course-builder' ),
						'param_name'  => 'title',
						'value'       => 'Our Top Courses',
						'admin_label' => true,
					),

					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Course Block Description:', 'course-builder' ),
						'param_name'  => 'description',
						'value'       => 'Customize your online school with an intuitive user interface. Design your homepage and lectures.',
						'admin_label' => true,
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Button text:', 'course-builder' ),
						'description' => esc_html__( 'Enter button text linked to course archive page', 'course-builder' ),
						'param_name'  => 'button_text',
						'value'       => 'View all courses',
						'admin_label' => true,
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Button link:', 'course-builder' ),
						'description' => esc_html__( 'Enter button link to course archive page', 'course-builder' ),
						'param_name'  => 'button_link',
						'admin_label' => true,
					),

					array(
						'type'        => 'number',
						'heading'     => esc_html__( 'Number of visible courses:', 'course-builder' ),
						'description' => esc_html__( 'Number of courses to display in this block', 'course-builder' ),
						'param_name'  => 'number_courses',
						'value'       => 7,
						'admin_label' => true,
					),


					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Course Category', 'course-builder' ),
						'param_name'  => 'cat_courses',
						'admin_label' => true,
						'value'       => thim_get_cat_courses('course_category'),
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
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'title'            => 'Our Top Courses',
				'description'      => 'Customize your online school with an intuitive user interface. Design your homepage and lectures.',
				'button_text'      => 'View all courses',
				'button_link'      => '',
				'number_courses'   => 7,
				'list_courses'     => 'latest',
				'cat_courses'      => '',
				'featured_courses' => '',
			), $atts );

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
			thim_get_template( $path . 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}

	}

	new Thim_SC_Courses_Block_2();
}