<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Skills_Bar' ) ) {

	class Thim_SC_Skills_Bar {

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
			$this->name        = esc_attr__( 'Thim: Skills Bar', 'course-builder' );
			$this->description = esc_attr__( 'Display a skill bar.', 'course-builder' );
			$this->base        = 'skills-bar';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}


		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-skills-bar', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/skills-bar-custom.js', array(
				'jquery',
				'circle-progress'
			),THIM_CB_VERSION, true );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_attr__( 'Thim Shortcodes', 'course-builder' ),
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-skills-bar.png',
				'description' => $this->description,
				'params'      => array(

					array(
						'type'       => 'param_group',
						'value'      => '',
						'param_name' => 'skills_bar',
						'params'     => array(

							array(
								"type"       => "number",
								"heading"    => esc_html__( "Enter a Number", 'course-builder' ),
								"param_name" => "number",
								"value"      => '50',
							),

							array(
								"type"             => "textfield",
								"heading"          => esc_html__( "Subtitle", 'course-builder' ),
								"param_name"       => "sub_title",
								"value"            => 'courses',
								'edit_field_class' => 'vc_col-sm-6',
							),


							array(
								"type"             => "colorpicker",
								"heading"          => esc_html__( "Number and Subtitle color", 'course-builder' ),
								"param_name"       => "numbertitle",
								"value"            => '#999',
								'edit_field_class' => 'vc_col-sm-6',
							),

							array(
								"type"             => "textfield",
								"heading"          => esc_html__( "Title", 'course-builder' ),
								"param_name"       => "title",
								"value"            => 'WEB DEVELOPMENT',
								'edit_field_class' => 'vc_col-sm-6',
							),

							array(
								"type"             => "colorpicker",
								"heading"          => esc_html__( "Title Color", 'course-builder' ),
								"param_name"       => "color",
								"value"            => '#255',
								'edit_field_class' => 'vc_col-sm-6',
								'description'      => esc_html__( "Choose Color Title", 'course-builder' ),
							),
							array(
								"type"             => "colorpicker",
								"heading"          => esc_html__( "EmptyFill Color", 'course-builder' ),
								"param_name"       => "emptyfill",
								"value"            => '#999',
								'edit_field_class' => 'vc_col-sm-6',
							),

						)
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Skills Bar shortcode to use in CSS customizations.', 'course-builder' ),
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
				'skills_bar' => '',
				'el_class'   => '',
			), $atts );

			$params['skills_bar'] = vc_param_group_parse_atts( $params['skills_bar'] );

			ob_start();
			wp_enqueue_script( 'thim-sc-skills-bar' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Skills_Bar();
}