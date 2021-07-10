<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Courses_Collection' ) ) {

	class Thim_SC_Courses_Collection {

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
			$this->name        = esc_attr__( 'Thim: Courses Collection', 'course-builder' );
			$this->description = esc_attr__( 'Display a courses collection', 'course-builder' );
			$this->base        = 'courses-collection';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );

		}


		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-courses-collection', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/courses-collection-custom.js', array(
				'jquery',
				'sly',
				'owlcarousel'
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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-courses-collection.png',
				'description' => $this->description,
				'params'      => array(
					array(
						'type'        => 'radio_image',
						'heading'     => esc_html__( 'Layout:', 'course-builder' ),
						'param_name'  => 'layout',
						'admin_label' => true,
						'options'     => array(
							'default'          => THIM_CB_URL . $this->base . '/assets/images/layouts/sc-courses-collection-default.png',
							'rounded-corner'   => THIM_CB_URL . $this->base . '/assets/images/layouts/sc-courses-collection-rounded.png',
							'squared-corner'   => THIM_CB_URL . $this->base . '/assets/images/layouts/sc-courses-collection-squared.png',
							'squared-corner-2' => THIM_CB_URL . $this->base . '/assets/images/layouts/sc-courses-collection-squared-2.jpg',
							'rounded-kit'      => THIM_CB_URL . $this->base . '/assets/images/layouts/sc-courses-collection-rounded.png'
						),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Disable Carousel Feature:', 'course-builder' ),
						'param_name' => 'none_carousel',
						'value'      => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'dependency' => array(
							'element' => 'layout',
							'value'   => array(
								'default'
							),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Collection Title:', 'course-builder' ),
						'param_name'  => 'title',
						'value'       => esc_attr__( 'Science courses collection', 'course-builder' ),
						'admin_label' => true,
					),

					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Collection Description:', 'course-builder' ),
						'param_name'  => 'description',
						'value'       => esc_attr__( 'We have the largest collection of courses', 'course-builder' ),
						'admin_label' => true,
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Button Text:', 'course-builder' ),
						'param_name'  => 'button_text',
						'description' => esc_html__( 'Enter button text linked to course archive page', 'course-builder' ),
						'value'       => esc_attr__( 'View all courses', 'course-builder' ),
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'layout',
							'value'   => array(
								'default',
								'rounded-corner',
								'squared-corner-2'
							),
						),
					),

					array(
						'type'             => 'number',
						'heading'          => esc_html__( 'Number of visible courses:', 'course-builder' ),
						'description'      => esc_html__( 'Number of courses to display in this block', 'course-builder' ),
						'param_name'       => 'limit',
						'edit_field_class' => 'vc_col-sm-6',
						'value'            => 8,
						'admin_label'      => true,
						'dependency'       => array(
							'element' => 'layout',
							'value'   => array(
								'default',
								'rounded-corner',
								'squared-corner',
								'rounded-kit',
							),
						),
					),

					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Number of columns:', 'course-builder' ),
						'param_name'       => 'visible',
						'edit_field_class' => 'vc_col-sm-6',
						'value'            => array(
							esc_html__( '5', 'course-builder' ) => 5,
							esc_html__( '4', 'course-builder' ) => 4,
							esc_html__( '3', 'course-builder' ) => 3,
							esc_html__( '2', 'course-builder' ) => 2,
							esc_html__( '1', 'course-builder' ) => 1,
						),
						'admin_label'      => true,
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show arrow navigation?', 'course-builder' ),
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'std'         => 'yes',
						'param_name'  => 'nav',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'layout',
							'value'   => array(
								'squared-corner',
								'rounded-kit',
							),
						),
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Scrollbar?', 'course-builder' ),
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'std'         => 'yes',
						'param_name'  => 'scrollbar',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'layout',
							'value'   => array(
								'default',
								'rounded-corner',
							),
						),
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
				'layout'        => 'default',
				'none_carousel' => '',
				'title'         => 'Science courses collection',
				'description'   => 'We have the largest collection of courses',
				'button_text'   => 'View all courses',
				'limit'         => 8,
				'visible'       => 5,
				'nav'           => 'yes',
				'scrollbar'     => 'yes',
			), $atts );

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
 			wp_enqueue_script( 'thim-courses-collection' );

			thim_get_template( $path . $params['layout'], array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}



	}


	new Thim_SC_Courses_Collection();
}