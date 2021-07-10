<?php
/**
 * Class Course block 4 shortcode.
 *
 * @author  ThimPress
 * @package Course Builder/Shortcodes/Class
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( !class_exists( 'Thim_SC_Courses_Block_4' ) ) {
	/**
	 * Class Thim_SC_Courses_Block_4.
	 */
	class Thim_SC_Courses_Block_4 {

		/**
		 * @var string
		 */
		protected $name = '';

		/**
		 * @var string
		 */
		protected $description = '';

		/**
		 * @var string
		 */
		protected $base = '';

		/**
		 * Thim_SC_Courses_Block_3 constructor.
		 */
		public function __construct() {

			//======================== CONFIG ========================
			$this->name        = esc_attr__( 'Thim: Courses - Type Kit Builder', 'course-builder' );
			$this->description = esc_attr__( 'Display a courses block', 'course-builder' );
			$this->base        = 'courses-block-4';
			//====================== END: CONFIG =====================

			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets.
		 */
		public function assets() {
			wp_register_script( 'thim-courses-block-4', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/course-block-4-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );

		}

		/**
		 * VC map shortcode.
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-courses-block-3.png',
				'description' => $this->description,
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Course Block Title:', 'course-builder' ),
						'param_name'  => 'title',
						'value'       => esc_html__( 'Our Top Courses', 'course-builder' ),
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
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Number of columns:', 'course-builder' ),
						'param_name'  => 'cols',
						'admin_label' => true,
						'value'       => array(
							esc_html__( '3', 'course-builder' ) => '3',
							esc_html__( '4', 'course-builder' ) => '4',
						),
						'std'         => '4',
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Show courses by:', 'course-builder' ),
						'param_name'  => 'course_list',
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
						'param_name'  => 'course_cat',
						'admin_label' => true,
						'value'       => thim_get_cat_courses('course_category'),
						"description" => esc_attr__( "Select which category if you choose to show courses by category.", 'course-builder' ),
						'dependency'  =>array(
							'element'  => 'course_list',
							'value'    => array('category')
						)
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Featured Courses?', 'course-builder' ),
						'description' => esc_html__( 'Check yes to only show the featured courses.', 'course-builder' ),
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'param_name'  => 'course_featured',
						'admin_label' => true,
					),

					array(
						'type'        => 'number',
						'heading'     => esc_html__( 'Number of visible courses:', 'course-builder' ),
						'description' => esc_html__( 'Number of courses to display in this block', 'course-builder' ),
						'param_name'  => 'course_limit',
						'value'       => 8,
						'admin_label' => true,
					),
				),
			) );
		}

		/**
		 * Add shortcode.
		 *
		 * @param $atts
		 *
		 * @return string
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'title'           => 'Our Top Courses',
				'button_text'     => 'View all courses',
				'course_list'     => 'latest',
				'course_featured' => '',
				'course_cat'      => '',
				'course_limit'    => 8,
				'cols'            => '4',
			), $atts );

			ob_start();
			wp_enqueue_script( 'thim-courses-block-4' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}
	}
}

new Thim_SC_Courses_Block_4();
