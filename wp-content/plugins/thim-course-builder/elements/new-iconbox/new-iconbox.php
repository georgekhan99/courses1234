<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_NewIcon_Box' ) ) {

	class Thim_SC_NewIcon_Box {

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
			$this->name        = esc_attr__( 'Thim: New Icon Box', 'course-builder' );
			$this->description = esc_attr__( 'Display a icon box.', 'course-builder' );
			$this->base        = 'new-iconbox';
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
						array(
							"type"        => "dropdown",
							"heading"     => esc_attr__( "Select type of icon", 'course-builder' ),
							"param_name"  => "icon",
							"admin_label" => true,
							"value"       => array(
								esc_attr__( "Font Awesome icon", 'course-builder' ) => "font_awesome",
								esc_attr__( "Ionicons", 'course-builder' )          => "font_ionicons",
								esc_attr__( "Upload icon", 'course-builder' )       => "upload_icon",
							),
						),
						// Fontawesome Picker
						array(
							"type"       => "iconpicker",
							"heading"    => esc_attr__( "Font Awesome", 'course-builder' ),
							"param_name" => "font_awesome",
							"settings"   => array(
								'emptyIcon' => true,
								'type'      => 'fontawesome',
							),
							'dependency' => array(
								'element' => 'icon',
								'value'   => array( 'font_awesome' ),
							),
						),

						// Ionicons Picker
						array(
							"type"       => "iconpicker",
							"heading"    => esc_attr__( "Ionicons", 'course-builder' ),
							"param_name" => "font_ionicons",
							"settings"   => array(
								'emptyIcon' => true,
								'type'      => 'ionicons',
							),
							'dependency' => array(
								'element' => 'icon',
								'value'   => array( 'font_ionicons' ),
							),
						),
						// Upload icon image
						array(
							"type"        => "attach_image",
							"heading"     => esc_attr__( "Upload Icon", 'course-builder' ),
							"param_name"  => "icon_upload",
							"admin_label" => true,
							"description" => esc_attr__( "Select an image to upload", 'course-builder' ),
							"dependency"  => array(
								"element" => "icon",
								"value"   => array( "upload_icon" )
							),
						),
						array(
							"type"             => "colorpicker",
							"heading"          => esc_html__( "Icon Color", 'course-builder' ),
							"description"      => esc_attr__( "Select primary color for the icon box", 'course-builder' ),
							"param_name"       => "primary_color",
							'edit_field_class' => "vc_col-sm-6",
							"dependency"       => array(
								"element" => "icon",
								"value"   => array( "font_ionicons", "font_awesome" )
							),
						),
						array(
							"type"       => "dropdown",
							"heading"    => esc_attr__( "Layout", 'course-builder' ),
							"param_name" => "layout",
							"value"      => array(
								esc_attr__( "Layout 1", 'course-builder' ) => "layout-1",
								esc_attr__( "Layout 2", 'course-builder' ) => "layout-2"
							),
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Title', 'course-builder' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => esc_attr__( 'Add title.', 'course-builder' ),
						),
						array(
							"type"             => "colorpicker",
							"heading"          => esc_html__( "Title Color", 'course-builder' ),
							"description"      => esc_attr__( "Select title color for the icon box", 'course-builder' ),
							"param_name"       => "title_color",
							'std'              => '#333'
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Title line 2', 'course-builder' ),
							'param_name'  => 'title_line_2',
							'value'       => '',
							'description' => esc_attr__( 'Add title.', 'course-builder' ),
							"dependency"  => array(
								"element" => "layout",
								"value"   => array( "layout-2" )
							),
						),
						array(
							"type"             => "colorpicker",
							"heading"          => esc_html__( "Title Line 2 Color", 'course-builder' ),
							"description"      => esc_attr__( "Select title line 2 color for the icon box", 'course-builder' ),
							"param_name"       => "title_line_color",
							'std'              => '#333',
							"dependency"  => array(
								"element" => "layout",
								"value"   => array( "layout-2" )
							),
						),
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Border Left', 'course-builder' ),
							'std'         => true,
							'param_name'  => 'border_left',
							'admin_label' => true,
							"dependency"  => array(
								"element" => "layout",
								"value"   => array( "layout-2" ),
							),
						),
						array(
							"type"             => "colorpicker",
							"heading"          => esc_html__( "Border Left Color", 'course-builder' ),
							"description"      => esc_attr__( "Select title line 2 color for the icon box", 'course-builder' ),
							"param_name"       => "border_left_color",
							'std'              => '#333',
							"dependency"  => array(
								"element" => "layout",
								"value"   => array( "layout-2" )
							),
						),
						// Insert link for icon box
						array(
							"type"        => "vc_link",
							"heading"     => esc_attr__( "Icon link", 'course-builder' ),
							"param_name"  => "icon_link",
							"admin_label" => true,
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name.', 'course-builder' ),
						),
					),
				)
			);
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts, $content = null ) {

			$params         = shortcode_atts( array(
				'layout'        => 'layout-1',
				'icon'          => 'font_awesome',
				'font_awesome'  => '',
				'font_ionicons' => '',
				'icon_upload'   => '',
				'title'         => esc_attr__( 'Write the title of icon', 'course-builder' ),
				'title_color'   =>'#333',
				'title_line_2'  => '',
				'title_line_color' => '#333',
				'border_left'   => false,
				'border_left_color' => '#333',
				'icon_link'     => '',
				'primary_color' => '',
				'el_class'      => '',
			), $atts );
			$params['base'] = $this->base;

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}


	new Thim_SC_NewIcon_Box();
}