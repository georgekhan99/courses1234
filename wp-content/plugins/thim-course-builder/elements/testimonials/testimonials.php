<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Testimonials' ) ) {

	class Thim_SC_Testimonials {

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
			$this->name        = esc_attr__( 'Thim: Testimonials', 'course-builder' );
			$this->description = esc_attr__( 'Display a testimonials box.', 'course-builder' );
			$this->base        = 'testimonials';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-testimonials', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/testimonials.js', array( 'jquery', 'thim-content-slider', 'owlcarousel' ),THIM_CB_VERSION, true );

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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-testimonials.png',
				'params'      => array(

					array(
						"type"       => "radio_image",
						"heading"    => esc_attr__( "Layout", 'course-builder' ),
						"param_name" => "layout",
						"options"    => array(
							'layout-1' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-1.jpg',
							'layout-2' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-2.jpg',
							'layout-3' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-3.jpg',
							'layout-4' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-4.jpg',
							'layout-5' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-5.jpg',
							'layout-6' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-6.jpg',
							'layout-7' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-6.jpg',
							'layout-8' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout-2.jpg',
						),
					),

					array(
						'type'       => 'param_group',
						'value'      => '',
						"heading"    => esc_html__( "Testimonials", 'course-builder' ),
						'param_name' => 'testimonials',
						'params'     => array(


							array(
								"type"       => "textfield",
								"heading"    => esc_html__( "Person Name", 'course-builder' ),
								"param_name" => "name",
							),

							array(
								"type"       => "attach_image",
								"heading"    => esc_html__( "Person Image", 'course-builder' ),
								"param_name" => "image",
							),

							array(
								"type"       => "textfield",
								"heading"    => esc_html__( "Person Website", 'course-builder' ),
								"param_name" => "website",
							),

							array(
								"type"       => "textfield",
								"heading"    => esc_html__( "Person Regency", 'course-builder' ),
								"param_name" => "regency",
							),

							array(
								"type"       => "textarea",
								"heading"    => esc_html__( "Testimonial content", 'course-builder' ),
								"param_name" => "content",
								"value"      => '',
							),

							array(
								'type'       => 'param_group',
								'value'      => '',
								'param_name' => 'social_links',
								"heading"    => esc_html__( "Person Social Links", 'course-builder' ),
								'params'     => array(


									array(
										"type"       => "textfield",
										"heading"    => esc_html__( "Social Network Name", 'course-builder' ),
										"param_name" => "name",
									),

									array(
										"type"       => "textfield",
										"heading"    => esc_html__( "Social Network Link", 'course-builder' ),
										"param_name" => "link",
										"value"      => '#',
									),

								)
							),

						)
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Testimonials shortcode to use in CSS customizations.', 'course-builder' ),
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
				'layout'       => 'layout-1',
				'testimonials' => '',
				'regency'      => '',
				'el_class'     => '',
			), $atts );


			$params['base']         = $this->base;
			$params['testimonials'] = vc_param_group_parse_atts( $params['testimonials'] );

			ob_start();

			wp_enqueue_script( 'thim-sc-testimonials' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}


	}

	new Thim_SC_Testimonials();
}