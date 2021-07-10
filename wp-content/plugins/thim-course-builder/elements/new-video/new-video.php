<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_New_Video' ) ) {

	class Thim_SC_New_Video {

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
			$this->name        = esc_attr__( 'Thim: New Video', 'course-builder' );
			$this->description = esc_attr__( 'Display a video.', 'course-builder' );
			$this->base        = 'new-video';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}


		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-video-box', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/video-box-custom.js', array( 'jquery', 'magnific-popup' ),THIM_CB_VERSION, true );

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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-video-box.png',
					'params'      => array(

						array(
							"type"        => "attach_image",
							"heading"     => esc_attr__( "Choose video thumbnail image", 'course-builder' ),
							"param_name"  => "upload_image",
							"admin_label" => true,
							"description" => esc_attr__( "Select an image to upload", 'course-builder' ),
						),

						array(
							"type"        => "attach_image",
							"heading"     => esc_attr__( "Choose icon background right", 'course-builder' ),
							"param_name"  => "background_image_1",
							"admin_label" => true,
							"description" => esc_attr__( "Select an image to upload", 'course-builder' ),
						),

						array(
							"type"        => "attach_image",
							"heading"     => esc_attr__( "Choose icon background bottom", 'course-builder' ),
							"param_name"  => "background_image_2",
							"admin_label" => true,
							"description" => esc_attr__( "Select an image to upload", 'course-builder' ),
						),

						array(
							"type"        => "textfield",
							"heading"     => esc_attr__( "Video Link", 'course-builder' ),
							"param_name"  => "link_video",
							"description" => esc_attr__( "Support Youtube and Vimeo format. Add '?rel=0&showinfo=0' to the video URL to turn off related videos", 'course-builder' )
						),

						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Video Box shortcode to use in CSS customizations.', 'course-builder' ),
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

			$params = shortcode_atts( array(
				'upload_image'       => '',
				'link_video'         => '',
				'background_image_1' => '',
				'background_image_2' => '',
				'el_class'           => ''
			), $atts );

			ob_start();
			wp_enqueue_script( 'thim-sc-video-box' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();

			ob_end_clean();

			return $html;
		}

	}


	new Thim_SC_New_Video();
}