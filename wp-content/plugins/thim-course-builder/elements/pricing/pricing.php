<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


if ( !class_exists( 'Thim_SC_Pricing' ) ) {

	class Thim_SC_Pricing {

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
			$this->name        = esc_attr__( 'Thim: Pricing', 'course-builder' );
			$this->description = esc_attr__( 'Display a pricing table', 'course-builder' );
			$this->base        = 'pricing';
			//====================== END: CONFIG =====================

			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );

			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );

		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-pricing', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/pricing-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );

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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-pricing.png',
					'params'      => array(

						array(
							'type'        => 'param_group',
							'value'       => '',
							"heading"     => esc_html__( "Pricing", 'course-builder' ),
							"description" => esc_html__( "Click plus icon to add a new social icon. Then click dropdown icon to choose which social icon and config its settings", 'course-builder' ),
							'param_name'  => 'pricing',
							'params'      => array(

								array(
									"type"        => "textarea",
									"heading"     => esc_html__( "Package", 'course-builder' ),
									"param_name"  => "package",
									"description" => esc_html__( "Example: Basic", 'course-builder' ),
								),

								array(
									"type"             => "textfield",
									"heading"          => esc_html__( "Price", 'course-builder' ),
									"param_name"       => "price",
									'edit_field_class' => 'vc_col-sm-6',
									"description"      => esc_html__( "Example: $100", 'course-builder' ),
								),

								array(
									"type"             => "textfield",
									"heading"          => esc_html__( "Unit", 'course-builder' ),
									"param_name"       => "unit",
									'edit_field_class' => 'vc_col-sm-6',
									"description"      => esc_html__( "Example: Month", 'course-builder' ),
								),

								array(
									"type"             => "textfield",
									"heading"          => esc_html__( "Button text", 'course-builder' ),
									"param_name"       => "button_text",
									'edit_field_class' => 'vc_col-sm-6',
								),

								array(
									"type"             => "textfield",
									"heading"          => esc_html__( "Button Link", 'course-builder' ),
									"param_name"       => "button_link",
									"value"            => '#',
									'edit_field_class' => 'vc_col-sm-6',
								),

								array(
									'type'       => 'textarea',
									'param_name' => 'features',
									"value"      => '',
									"heading"    => esc_html__( 'Features', 'course-builder' ),
								),

							)
						),

						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Select columns', 'course-builder' ),
							'param_name'       => 'columns',
							'value'            => array(
								esc_html__( '3', 'course-builder' ) => '3',
								esc_html__( '4', 'course-builder' ) => '4',
							),
							'edit_field_class' => 'vc_col-sm-4',
						),

						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'course-builder' ),
						),

					)
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
				'pricing'  => '',
				'columns'  => 3,
				'el_class' => '',
			), $atts );

			$params['sc-name'] = $this->base;
			$params['pricing'] = vc_param_group_parse_atts( $params['pricing'] );

			ob_start();
			wp_enqueue_script( 'thim-sc-pricing' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}

	}

	new Thim_SC_Pricing();
}

