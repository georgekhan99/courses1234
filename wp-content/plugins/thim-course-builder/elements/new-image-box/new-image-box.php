<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_New_Image_Box' ) ) {

	class Thim_SC_New_Image_Box {

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
			$this->name        = esc_attr__( 'Thim: New Image Box', 'course-builder' );
			$this->description = esc_attr__( 'Display a new image box.', 'course-builder' );
			$this->base        = 'new-image-box';
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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-image-box.png',
				'params'      => array(

					array(
						'type'       => 'param_group',
						'value'      => '',
						"heading"    => esc_html__( "Images Box", 'course-builder' ),
						'param_name' => 'image_box',
						'params'     => array(
							array(
								"type"        => "attach_image",
								"heading"     => esc_attr__( "Upload Image Background", 'course-builder' ),
								"param_name"  => "upload_image_background",
								"admin_label" => true,
								"description" => esc_attr__( "Select an image to upload", 'course-builder' )
							),

							array(
								"type"        => "textfield",
								"heading"     => esc_attr__( "Title title", 'course-builder' ),
								"param_name"  => "title",
								"admin_label" => true,
							),

							array(
								'type'        => 'textfield',
								'admin_label' => true,
								'heading'     => esc_attr__( 'Link in title', 'course-builder' ),
								'param_name'  => 'link_title',
								'value'       => '',
								'description' => esc_attr__( 'Add link for title.', 'course-builder' ),
							),

							array(
								"type"        => "attach_image",
								"heading"     => esc_attr__( "Icon Image", 'course-builder' ),
								"param_name"  => "icon_image",
								"admin_label" => false,
								"description" => esc_attr__( "Select a background image for the content", 'course-builder' )
							),

							array(
								"type"        => "dropdown",
								"heading"     => esc_attr__( "Content float", 'course-builder' ),
								"param_name"  => "layout",
								"admin_label" => true,
								"value"       => array(
									esc_attr__( "Left", 'course-builder' )  => 'left',
									esc_attr__( "Right", 'course-builder' ) => "right",
								),
								"description" => esc_attr__( "Select content right and left background", 'course-builder' )
							),
						) ),

					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Image Box shortcode to use in CSS customizations.', 'course-builder' ),
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
				'image_box'               => '',
				'upload_image_background' => '',
				'title'                   => '',
				'link_title'              => '',
				'icon_image'              => '',
				'layout'                  => 'left',
				'el_class'                => '',
			), $atts );

			$params['image_box'] = vc_param_group_parse_atts( $params['image_box'] );

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();

			return $html;
		}

	}

	new Thim_SC_New_Image_Box();
}