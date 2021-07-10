<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Photo_Wall' ) ) {

	class Thim_SC_Photo_Wall {

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
			$this->name        = esc_attr__( 'Thim: Photo Wall', 'course-builder' );
			$this->description = esc_attr__( 'Display a photos wall collection.', 'course-builder' );
			$this->base        = 'photo-wall';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-photo-wall', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/photo-wall.js', array( 'jquery','imagesloaded','masonry','waypoints' ),THIM_CB_VERSION, true );

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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-photo-wall.png',
				'params'      => array(


					array(
						'type'             => 'param_group',
						'heading'          => esc_html__( 'Images', 'course-builder' ),
						'param_name'       => 'images',
						'value'            => '',
						'edit_field_class' => 'photo-wall-list',
						'params'           => array(
							array(
								'type'       => 'attach_image',
								'heading'    => esc_html__( 'Select Image', 'course-builder' ),
								'param_name' => 'image',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Image Title', 'course-builder' ),
								'param_name' => 'title',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Image Description', 'course-builder' ),
								'param_name' => 'description',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Image Link', 'course-builder' ),
								'param_name' => 'link',
							),
						)
					),

					array(
						"type"        => "dropdown",
						"heading"     => esc_attr__( "Crop Images", 'course-builder' ),
						"param_name"  => "crop_images",
						"admin_label" => true,
						"value"       => array(
							esc_attr__( "Yes", 'course-builder' ) => 'image-crop',
							esc_attr__( "No", 'course-builder' )  => 'full-size',
						),
						"description" => esc_attr__( 'Select no to show images in full size', 'course-builder' )
					),

					array(
						'type'             => 'number',
						'heading'          => esc_html__( 'Mobile Limit', 'course-builder' ),
						'param_name'       => 'mobile_limit',
                        "description" => esc_attr__( 'Number of images show on mobile', 'course-builder' ),
						'admin_label'      => true,
						'edit_field_class' => 'vc_col-xs-4',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Mobile Text Load more', 'course-builder' ),
                        "description" => esc_attr__( 'Text for Load more on on mobile', 'course-builder' ),
						'param_name' => 'mobile_title',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Mobile Link Load more', 'course-builder' ),
                        "description" => esc_attr__( 'Link for Load more on mobile', 'course-builder' ),
						'param_name' => 'mobile_link',
					),

					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Photo Wall shortcode to use in CSS customizations.', 'course-builder' ),
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
				'images'       => '',
				'crop_images'  => 'image-crop',
				'mobile_limit' => '',
				'mobile_title' => '',
				'mobile_link'  => '',
				'el_class'     => '',
			), $atts );


			$params['images'] = vc_param_group_parse_atts( $params['images'] );

			ob_start();
			wp_enqueue_script( 'thim-sc-photo-wall' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Photo_Wall();
}