<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Course_Search' ) ) {

	class Thim_SC_Course_Search {

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
			$this->name        = esc_attr__( 'Thim: Search Courses', 'course-builder' );
			$this->description = esc_attr__( 'Display a search box to search for courses.', 'course-builder' );
			$this->base        = 'course-search';
			//====================== END: CONFIG =====================

			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-course-search', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/course-search.js', array( 'jquery' ), THIM_CB_VERSION, true );
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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-course-search.png',
				'params'      => array(
					array(
						"type"        => "textfield",
						"heading"     => esc_attr__( "Search box placeholder", 'course-builder' ),
						"param_name"  => "placeholder",
						"admin_label" => true,
						'value'       => esc_attr__( 'What do you want to learn today?', 'course-builder' ),
					),

					array(
						"type"             => "dropdown",
						"admin_label"      => true,
						"heading"          => esc_html__( "Style", "course-builder" ),
						"param_name"       => "layout",
						"value"            => array(
							esc_html__( "Default", "course-builder" )           => "",
							esc_html__( "Popup", "course-builder" )             => "popup",
							esc_html__( "Style Kit Builder", "course-builder" ) => "style_kit",
						),
						"std"              => "",
						'edit_field_class' => 'vc_col-sm-4',
					),

					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Search Courses shortcode to use in CSS customizations.', 'course-builder' ),
					),

				)
			) );
		}

		/**
		 * @param $atts
		 *
		 * @return string
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'placeholder' => esc_attr__( 'What do you want to learn today?', 'course-builder' ),
				'layout'      => '',
				'el_class'    => '',
			), $atts );

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
			wp_enqueue_script( 'thim-course-search' );

			thim_get_template( $path . 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Course_Search();
}