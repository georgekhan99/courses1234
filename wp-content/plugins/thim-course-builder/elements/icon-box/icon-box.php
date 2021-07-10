<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Icon_Box' ) ) {

	class Thim_SC_Icon_Box {

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
			$this->name        = esc_attr__( 'Thim: Icon Box', 'course-builder' );
			$this->description = esc_attr__( 'Display an icon box.', 'course-builder' );
			$this->base        = 'icon-box';
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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-icon-box.png',
				'params'      => array(
					// Select type of icon
					array(
						"type"             => "dropdown",
						"heading"          => esc_attr__( "Select type of icon", 'course-builder' ),
						"param_name"       => "icon",
						"admin_label"      => true,
						"value"            => array(
							esc_attr__( "Font Awesome icon", 'course-builder' ) => "font_awesome",
							esc_attr__( "Ionicons", 'course-builder' )          => "font_ionicons",
							esc_attr__( "Upload icon", 'course-builder' )       => "upload_icon",
						),
						'edit_field_class' => "vc_col-sm-6",
					),
					// Fontawesome Picker
					array(
						"type"             => "iconpicker",
						"heading"          => esc_attr__( "Font Awesome", 'course-builder' ),
						"param_name"       => "font_awesome",
						"settings"         => array(
							'emptyIcon' => true,
							'type'      => 'fontawesome',
						),
						'dependency'       => array(
							'element' => 'icon',
							'value'   => array( 'font_awesome' ),
						),
						'edit_field_class' => "vc_col-sm-6",
					),

					// Ionicons Picker
					array(
						"type"             => "iconpicker",
						"heading"          => esc_attr__( "Ionicons", 'course-builder' ),
						"param_name"       => "font_ionicons",
						"settings"         => array(
							'emptyIcon' => true,
							'type'      => 'ionicons',
						),
						'dependency'       => array(
							'element' => 'icon',
							'value'   => array( 'font_ionicons' ),
						),
						'edit_field_class' => "vc_col-sm-6",
					),
					// Upload icon image
					array(
						"type"             => "attach_image",
						"heading"          => esc_attr__( "Upload Icon", 'course-builder' ),
						"param_name"       => "icon_upload",
						"admin_label"      => true,
						"description"      => esc_attr__( "Select an image to upload", 'course-builder' ),
						"dependency"       => array(
							"element" => "icon",
							"value"   => array( "upload_icon" )
						),
						'edit_field_class' => "vc_col-sm-6",
					),

					array(
						"type"       => "radio_image",
						"heading"    => esc_attr__( "Layout", 'course-builder' ),
						"param_name" => "box_style",
						"options"    => array(
							'layout-1' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-1.jpg',
							'layout-2' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-2.jpg',
							'layout-3' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-3.jpg',
							'layout-4' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-4.jpg',
							'layout-5' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-5.jpg',
							'layout-6' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-6.jpg',
						),
					),

					array(
						"type"        => "dropdown",
						"heading"     => esc_attr__( "Select type of style", 'course-builder' ),
						"param_name"  => "style_layout",
						"admin_label" => true,
						"value"       => array(
							esc_attr__( "Default", 'course-builder' )           => "default",
							esc_attr__( "Style Kit Builder", 'course-builder' ) => "style_kit",
						),
						'dependency'  => array(
							'element' => 'box_style',
							'value'   => array( 'layout-3' ),
						),
					),

					array(
						"type"             => "colorpicker",
						"heading"          => esc_html__( "Icon Background", 'course-builder' ),
						"description"      => esc_attr__( "Select primary color for the icon box", 'course-builder' ),
						"param_name"       => "background_color",
						'dependency'       => array(
							'element' => 'style_layout',
							'value'   => array( 'style_kit' ),
						),
						'edit_field_class' => "vc_col-sm-6",
					),

					array(
						"type"             => "colorpicker",
						"heading"          => esc_html__( "Icon Color", 'course-builder' ),
						"description"      => esc_attr__( "Select primary color for the icon box", 'course-builder' ),
						"param_name"       => "primary_color",
						'dependency'       => array(
							'element' => 'box_style',
							'value'   => array( 'layout-2' ),
						),
						'edit_field_class' => "vc_col-sm-6",
					),

					// Icon title
					array(
						"type"        => "textfield",
						"heading"     => esc_attr__( "Icon title", 'course-builder' ),
						"param_name"  => "icon_title",
						'value'       => "Write a Title of icon",
						"admin_label" => true,
					),
					// Description of icon box
					array(
						"type"        => "textarea_html",
						"heading"     => esc_attr__( "Icon description", 'course-builder' ),
						"param_name"  => "content",
						"admin_label" => true,
						'value'       => esc_attr__( "Write a Description of icon", 'course-builder' ),
					),
					// Insert link for icon box
					array(
						"type"        => "vc_link",
						"heading"     => esc_attr__( "Icon link", 'course-builder' ),
						"param_name"  => "icon_link",
						"admin_label" => true,
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Icon Box shortcode to use in CSS customizations.', 'course-builder' ),
					),
				)
			) );
		}


		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts, $content = null ) {

			$params = shortcode_atts( array(
				'icon'             => 'font_awesome',
				'font_awesome'     => '',
				'font_ionicons'    => '',
				'icon_upload'      => '',
				'box_style'        => 'layout-1',
				'icon_title'       => esc_attr__( 'Write the title of icon', 'course-builder' ),
				'icon_link'        => '',
				'primary_color'    => '',
				'style_layout'     => 'style_kit',
				'background_color' => '',
				'el_class'         => '',
			), $atts );

			$params['description'] = wpb_js_remove_wpautop( $content, true );
			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Icon_Box();
}

