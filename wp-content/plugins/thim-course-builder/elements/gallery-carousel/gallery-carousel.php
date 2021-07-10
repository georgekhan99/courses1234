<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Gallery_Carousel' ) ) {

	class Thim_SC_Gallery_Carousel {

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
			$this->name        = esc_attr__( 'Thim: Gallery Carousel', 'course-builder' );
			$this->description = esc_attr__( 'Display gallery carousel', 'course-builder' );
			$this->base        = 'gallery-carousel';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-gallery-carousel', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/gallery-carousel-custom.js', array(
				'jquery',
				'owlcarousel'
			),THIM_CB_VERSION, true );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'description' => $this->description,
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-gallery-carousel.png',
				'params'      => array(

					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'Gallery', 'course-builder' ),
						'param_name' => 'items',
						'value'      => '',
						'params'     => array(
							array(
								'type'        => 'attach_image',
								'heading'     => esc_html__( 'Image', 'course-builder' ),
								'description' => esc_html__( 'Select image has size at least 1600x800', 'course-builder' ),
								'param_name'  => 'gallery_img',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Image title', 'course-builder' ),
								'param_name' => 'gallery_title',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Image subtitle', 'course-builder' ),
								'param_name' => 'gallery_subtitle',
							),
						)
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show dots navigation?', 'course-builder' ),
						'param_name'  => 'nav',
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'admin_label' => true,
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__( 'Extra class', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'Add extra class name for Thim Gallery Carousel shortcode to use in CSS customizations.', 'course-builder' ),
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
				'items'    => '',
				'nav'      => '',
				'el_class' => '',
			), $atts );

			$params['items'] = vc_param_group_parse_atts( $params['items'] );

			ob_start();
			wp_enqueue_script( 'thim-gallery-carousel' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}


	}

	new Thim_SC_Gallery_Carousel();
}