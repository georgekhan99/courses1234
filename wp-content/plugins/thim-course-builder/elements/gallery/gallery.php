<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Gallery' ) ) {

	class Thim_SC_Gallery {

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
			$this->name        = esc_attr__( 'Thim: Gallery Posts', 'course-builder' );
			$this->description = esc_attr__( 'Display gallery posts', 'course-builder' );
			$this->base        = 'gallery';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-gallery', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/gallery-custom.js', array(
				'jquery',
				'isotope',
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
				'description' => $this->description,
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-gallery-post.png',
				'params'      => array(

					array(
						'type'        => 'dropdown_multiple',
						'heading'     => esc_html__( 'Select Category', 'course-builder' ),
						'param_name'  => 'cat',
						"description"      => esc_attr__( "Select which category if you choose to show posts by category.", 'course-builder' ),
						'value'       => thim_get_cat_courses( 'category'),
						'std'         => '',
						'edit_field_class' => "vc_col-sm-6",
					),
					array(
						'type'             => 'dropdown',
						'admin_label'      => true,
						'heading'          => esc_html__( 'Number of columns', 'course-builder' ),
						'param_name'       => 'columns',
						'value'            => array(
							esc_attr__( "3", 'course-builder' ) => '3',
							esc_attr__( "4", 'course-builder' ) => '4',
							esc_attr__( "5", 'course-builder' ) => '5',
							esc_attr__( "6", 'course-builder' ) => '6',
						),
						'std'              => '4',
						'edit_field_class' => 'vc_col-sm-6',
					),

					array(
						'type'             => 'number',
						'admin_label'      => true,
						'heading'          => esc_html__( 'Number', 'course-builder' ),
						'param_name'       => 'limit',
						'edit_field_class' => 'vc_col-sm-6',
						'description'      => esc_html__( 'Choose how many to show', 'course-builder' ),
						'value'            => 8,
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Filter', 'course-builder' ),
						'param_name'  => 'filter',
						'admin_label' => true,
						'edit_field_class' => 'vc_col-sm-6',
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__( 'Extra class', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'Add extra class name for Thim Gallery Carousel shortcode to use in CSS customizations.', 'course-builder' ),
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
				'cat'           => '',
				'columns'           => '4',
				'limit'           => '8',
				'filter'           => false,
				'el_class'      => '',
			), $atts );

			ob_start();
			wp_enqueue_script( 'thim-gallery' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}

	}

	new Thim_SC_Gallery();
}