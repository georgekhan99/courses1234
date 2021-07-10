<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Features_List' ) ) {

	class Thim_SC_Features_List {

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
			$this->name        = esc_attr__( 'Thim: Features List', 'course-builder' );
			$this->description = esc_attr__( 'Display a list of features.', 'course-builder' );
			$this->base        = 'features-list';
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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-features-list.png',
				'params'      => array(
					array(
						"type"        => "textfield",
						"heading"     => esc_attr__( "Features list title", 'course-builder' ),
						"param_name"  => "title",
						"admin_label" => true,
					),

					array(
						"type"             => "dropdown",
						"heading"          => esc_attr__( "Styles", 'course-builder' ),
						"param_name"       => "style",
						'edit_field_class' => 'vc_col-sm-6',
						"value"            => array(
							esc_attr__( "Default", 'course-builder' ) => '',
							esc_attr__( "Style 1", 'course-builder' ) => 'style-1',
						),
					),

					array(
						'type'       => 'param_group',
						'value'      => '',
						'param_name' => 'features_list',
						'params'     => array(


							array(
								"type"       => "textfield",
								"heading"    => esc_html__( "Feature title", 'course-builder' ),
								"param_name" => "sub_title",
							),

							array(
								"type"       => "textarea",
								"heading"    => esc_html__( "Feature description", 'course-builder' ),
								"param_name" => "description",
							),

							array(
								'type'       => 'vc_link',
								'heading'    => esc_html__( 'Feature Link', 'course-builder' ),
								'param_name' => 'link',
							),

						)
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Features List shortcode to use in CSS customizations.', 'course-builder' ),
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
				'title'         => '',
				'style'         => '',
				'features_list' => '',
				'el_class'      => '',
			), $atts );


			$params['features_list'] = vc_param_group_parse_atts( $params['features_list'] );

			ob_start();
			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}


	}

	new Thim_SC_Features_List();
}