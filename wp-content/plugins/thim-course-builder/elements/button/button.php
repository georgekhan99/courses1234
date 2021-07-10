<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Button' ) ) {

	class Thim_SC_Button {

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
			$this->name        = esc_attr__( 'Thim: Button', 'course-builder' );
			$this->description = esc_attr__( 'Display a button.', 'course-builder' );
			$this->base        = 'button';
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-button.png',
					'params'      => array(
						// Button Title
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Button Title', 'course-builder' ),
							'param_name'  => 'title',
						),
						// Button Link
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Button Link', 'course-builder' ),
							'param_name'  => 'link',
							'description' => 'Button only shows if you enter button link',
						),
						// Style
						array(
							"type"             => "dropdown",
							"heading"          => esc_attr__( "Select Button Size", 'course-builder' ),
							"param_name"       => "size",
							"admin_label"      => true,
							"value"            => array(
								esc_attr__( "Large", 'course-builder' )  => "btn-lg",
								esc_attr__( "Medium", 'course-builder' ) => "btn-md",
								esc_attr__( "Small", 'course-builder' )  => "btn-sm",
								esc_attr__( "XSmall", 'course-builder' ) => "btn-xs",
							),
							'edit_field_class' => "vc_col-sm-6",
						),

						array(
							"type"             => "dropdown",
							"heading"          => esc_attr__( "Select Button Style", 'course-builder' ),
							"param_name"       => "style",
							"admin_label"      => true,
							"value"            => array(
								esc_attr__( "Primary", 'course-builder' )      => "primary",
								esc_attr__( "Secondary", 'course-builder' )    => "secondary",
								esc_attr__( "Basic", 'course-builder' )        => "basic",
								esc_attr__( "Kit gradient", 'course-builder' ) => "style_kit",
							),
							'edit_field_class' => "vc_col-sm-6",
						),

						// separator
						array(
							"type"             => "dropdown",
							"heading"          => esc_attr__( "Button Separator", 'course-builder' ),
							"param_name"       => "separator",
							"admin_label"      => true,
							"value"            => array(
								esc_attr__( "Hide", 'course-builder' ) => "hide-separator",
								esc_attr__( "Show", 'course-builder' ) => "show-separator",
							),
							'edit_field_class' => "vc_col-sm-6",
						),

						array(
							'type'             => 'checkbox',
							'heading'          => esc_html__( 'Open button link in new tab?', 'course-builder' ),
							'param_name'       => 'target',
							'admin_label'      => true,
							'default'          => false,
							'edit_field_class' => "vc_col-sm-6",
						),

						array(
							"type"             => "dropdown",
							"heading"          => esc_attr__( "Select Button Style", 'course-builder' ),
							"param_name"       => "align",
							"admin_label"      => true,
							"value"            => array(
								esc_attr__( "Left", 'course-builder' )   => "left",
								esc_attr__( "Right", 'course-builder' )  => "right",
								esc_attr__( "Center", 'course-builder' ) => "center",
							),
							'edit_field_class' => "vc_col-sm-6",
						),

						// Extra class
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Extra class', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'Add extra class name for Thim Button shortcode to use in CSS customizations.', 'course-builder' ),
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
				'title'     => '',
				'link'      => '',
				'separator' => 'hide-separator',
				'size'      => 'btn-lg',
				'style'     => 'primary',
				'target'    => false,
				'align'     => '',
				'el_class'  => '',
			), $atts );

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Button();
}