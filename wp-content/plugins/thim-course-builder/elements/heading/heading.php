<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Heading' ) ) {

	class Thim_SC_Heading {

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
			$this->name        = esc_attr__( 'Thim: Heading', 'course-builder' );
			$this->description = esc_attr__( 'Display a heading.', 'course-builder' );
			$this->base        = 'heading';
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-heading.png',
					'params'      => array(
						// Heading Style
						array(
							"type"       => "radio_image",
							"heading"    => esc_attr__( "Style", 'course-builder' ),
							"param_name" => "heading_style",
							"std"        => "default",
							"options"    => array(
								'default'    => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-1.jpg',
								'layout-2'   => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-2.jpg',
								'layout-kit' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-3.png',
							),
						),

						// Primary Heading Title
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Heading title', 'course-builder' ),
							'param_name'  => 'primary_heading',
							'value'       => 'Primary text',
						),

						// Primary Heading Title 2
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Heading title line 2', 'course-builder' ),
							'param_name'  => 'primary_heading_2',
							'value'       => 'Primary text 2',
							'dependency'  => array(
								'element' => 'heading_style',
								'value'   => 'layout-kit',
							),
						),

						// Secondary Heading Title
						array(
							'type'        => 'textarea',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Heading subtitle', 'course-builder' ),
							'param_name'  => 'secondary_heading',
							'value'       => 'Secondary text',
						),

						array(
							'type'        => 'attach_image',
							'param_name'  => 'heading_icon',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Upload Heading icon', 'course-builder' ),
							'description' => esc_html__( 'Replace the default heading icon with your own icon.', 'course-builder' ),
							'dependency'  => array( 'element' => 'heading_style', 'value' => array( 'default' ) )
						),

						//Position Heading
						array(
							"type"             => "dropdown",
							"heading"          => esc_attr__( "Align Heading", 'course-builder' ),
							"param_name"       => "heading_position",
							"admin_label"      => true,
							"value"            => array(
								esc_attr__( 'Center', 'course-builder' ) => 'center',
								esc_attr__( 'Right', 'course-builder' )  => 'right',
								esc_attr__( 'Left', 'course-builder' )   => 'left',
							),
							'edit_field_class' => 'vc_col-sm-4',
						),
						//Hide Separator
						array(
							'type'             => 'checkbox',
							'heading'          => esc_html__( 'Show heading separator', 'course-builder' ),
							'param_name'       => 'separator',
							'edit_field_class' => 'vc_col-sm-4',
							'std'              => 'true',
							'dependency'       => array(
								'element' => 'heading_style',
								'value'   => array( 'default', 'layout-2' ),
							),
						),

						// Extra class
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Extra class', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'Add extra class name for Thim Heading shortcode to use in CSS customizations.', 'course-builder' ),
						),

						array(
							'type'        => 'dropdown',
							'admin_label' => true,
							'heading'     => esc_html__( 'Heading tag', 'course-builder' ),
							'param_name'  => 'tag',
							'value'       => array(
								'h2' => 'h2',
								'h3' => 'h3',
								'h4' => 'h4',
								'h5' => 'h5',
								'h6' => 'h6',
							),
							'std'         => 'h3',
							'description' => esc_html__( 'Choose heading element.', 'course-builder' ),
							'group'       => esc_html__( 'Heading Settings', 'course-builder' ),
						),

						//Use custom or default title?
						array(
							'type'        => 'checkbox',
							'admin_label' => true,
							'heading'     => esc_html__( 'Advanced', 'course-builder' ),
							'param_name'  => 'heading_custom',
							'value'       => array(
								esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
							),
							'group'       => esc_html__( 'Heading Settings', 'course-builder' ),
						),

						array(
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_html__( 'Font size ', 'course-builder' ),
							'param_name'  => 'font_size',
							'min'         => 0,
							'value'       => '',
							'suffix'      => 'px',
							'description' => esc_html__( 'Custom title font size.', 'course-builder' ),
							'std'         => '36',
							'dependency'  => array(
								'element' => 'heading_custom',
								'value'   => 'yes',
							),
							'group'       => esc_html__( 'Heading Settings', 'course-builder' ),
						),

						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Font Weight ', 'course-builder' ),
							'param_name'       => 'font_weight',
							'value'            => array(
								esc_attr__( 'Normal', 'course-builder' ) => 'normal',
								esc_attr__( 'Bold', 'course-builder' )   => 'bold',
								esc_attr__( '100', 'course-builder' )    => '100',
								esc_attr__( '200', 'course-builder' )    => '200',
								esc_attr__( '300', 'course-builder' )    => '300',
								esc_attr__( '400', 'course-builder' )    => '400',
								esc_attr__( '500', 'course-builder' )    => '500',
								esc_attr__( '600', 'course-builder' )    => '600',
								esc_attr__( '700', 'course-builder' )    => '700',
								esc_attr__( '800', 'course-builder' )    => '800',
								esc_attr__( '900', 'course-builder' )    => '900',
							),
							'description'      => esc_html__( 'Custom title font weight.', 'course-builder' ),
							'dependency'       => array(
								'element' => 'heading_custom',
								'value'   => 'yes',
							),
							'edit_field_class' => 'vc_col-sm-6',
							'group'            => esc_html__( 'Heading Settings', 'course-builder' ),
						),

						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Font style ', 'course-builder' ),
							'param_name'       => 'font_style',
							'value'            => array(
								esc_attr__( 'Normal', 'course-builder' )  => 'normal',
								esc_attr__( 'Italic', 'course-builder' )  => 'italic',
								esc_attr__( 'Oblique', 'course-builder' ) => 'oblique',
								esc_attr__( 'Initial', 'course-builder' ) => 'initial',
								esc_attr__( 'Inherit', 'course-builder' ) => 'inherit',
							),
							'description'      => esc_html__( 'Custom title font style.', 'course-builder' ),
							'dependency'       => array(
								'element' => 'heading_custom',
								'value'   => 'yes',
							),
							'edit_field_class' => 'vc_col-sm-6',
							'group'            => esc_html__( 'Heading Settings', 'course-builder' ),
						),

						array(
							"type"             => "colorpicker",
							"heading"          => esc_html__( "Font Color", 'course-builder' ),
							"description"      => esc_attr__( "Select primary color for heading", 'course-builder' ),
							"param_name"       => "font_color",
							'dependency'       => array(
								'element' => 'heading_custom',
								'value'   => 'yes',
							),
							'edit_field_class' => "vc_col-sm-6",
							'group'            => esc_html__( 'Heading Settings', 'course-builder' ),
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
				'separator'         => true,
				'heading_style'     => 'default',
				'heading_icon'      => '',
				'heading_position'  => 'center',
				'primary_heading'   => 'Primary text',
				'primary_heading_2' => 'Primary text line 2',
				'secondary_heading' => 'Secondary text',
				'el_class'          => '',
				'tag'               => 'h3',
				'heading_custom'    => '',
				'font_size'         => '36',
				'font_weight'       => 'normal',
				'font_style'        => 'normal',
				'font_color'        => '',

			), $atts );

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Heading();
}