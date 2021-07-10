<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Image_Box' ) ) {

	class Thim_SC_Image_Box {

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
			$this->name        = esc_attr__( 'Thim: Image Box', 'course-builder' );
			$this->description = esc_attr__( 'Display a image box.', 'course-builder' );
			$this->base        = 'image-box';
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
						"type"        => "attach_image",
						"heading"     => esc_attr__( "Upload Image", 'course-builder' ),
						"param_name"  => "upload_image",
						"admin_label" => true,
						"description" => esc_attr__( "Select an image to upload", 'course-builder' )
					),

					array(
						"type"        => "number",
						"heading"     => esc_attr__( "Image number", 'course-builder' ),
						"param_name"  => "number",
						"admin_label" => true,
						"description" => esc_attr__( "Enter a number to show on the image", 'course-builder' ),
						"value"       => '2',
					),
					array(
						"type"             => "colorpicker",
						"heading"          => esc_html__( "Number Color", 'course-builder' ),
						"param_name"       => "number_color",
						'edit_field_class' => "vc_col-sm-6",
						'std'              => 'rgba(255, 255, 255, 0.6)',
					),

					array(
						"type"        => "textfield",
						"heading"     => esc_attr__( "Image title", 'course-builder' ),
						"param_name"  => "title",
						"admin_label" => true,
					),

					array(
						"type"        => "textfield",
						"heading"     => esc_attr__( "Image subtitle", 'course-builder' ),
						"param_name"  => "sub-title",
						"admin_label" => true,

					),

					array(
						"type"        => "textarea",
						"heading"     => esc_attr__( "Image content", 'course-builder' ),
                        'param_name'  => 'content',
						"admin_label" => true,
					),

					array(
						"type"        => "attach_image",
						"heading"     => esc_attr__( "Content Background Image", 'course-builder' ),
						"param_name"  => "bg_content",
						"admin_label" => false,
						"description" => esc_attr__( "Select a background image for the content", 'course-builder' )
					),

					array(
						"type"        => "dropdown",
						"heading"     => esc_attr__( "Image float", 'course-builder' ),
						"param_name"  => "layout",
						"admin_label" => true,
						"value"       => array(
							esc_attr__( "Left", 'course-builder' )  => 'left',
							esc_attr__( "Right", 'course-builder' ) => "right",
						),
						"description" => esc_attr__( "Select image to float left or right to the content", 'course-builder' )
					),


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
				'upload_image' => '',
				'number'       => '2',
				'number_color' => 'rgba(255, 255, 255, 0.6)',
				'title'        => '',
				'sub-title'    => '',
				'el_class'     => '',
				'main_content'      => '',
				'bg_content'   => '',
				'layout'       => 'left',
			), $atts );

            $params['content'] = wpb_js_remove_wpautop( $content, true ); // fix unclosed/unwanted paragraph tags in $content

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();

			return $html;
		}

	}

	new Thim_SC_Image_Box();
}