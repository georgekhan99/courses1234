<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Posts' ) ) {

	class Thim_SC_Posts {

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
			$this->name        = esc_attr__( 'Thim: Posts Gallery', 'course-builder' );
			$this->description = esc_attr__( 'Display a post list.', 'course-builder' );
			$this->base        = 'posts';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-posts', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/post-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map(
				array(
					'name'        => $this->name,
					'base'        => 'thim-' . $this->base,
					'category'    => esc_attr__( 'Thim Shortcodes', 'course-builder' ),
					'description' => $this->description,
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-events.png',
					'params'      => array(
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Select post category', 'course-builder' ),
							'param_name'       => 'cat_post',
							'admin_label'      => true,
							'value'            => thim_get_cat_courses('category'),
							'edit_field_class' => 'vc_col-sm-6',
						),

						array(
							'type'             => 'number',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of posts', 'course-builder' ),
							'param_name'       => 'number_post',
							'edit_field_class' => 'vc_col-sm-12',
							'description'      => esc_html__( 'Choose number of posts to show', 'course-builder' ),
							'value'            => '3',
						),

						array(
							"type"       => "radio_image",
							"heading"    => esc_attr__( "Layout", 'course-builder' ),
							"param_name" => "layer_events",
							"options"    => array(
								'default' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/layouts/layout.png',
							),
							"std"        => "default",
						),

						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Posts shortcode to use in CSS customizations.', 'course-builder' ),
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
				'cat_post'    => 0,
				'number_post' => '3',
				'el_class'    => '',

			), $atts );

			$params['base'] = $this->base;

			
			ob_start();
			wp_enqueue_script( 'thim-posts' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();

			return $html;
		}
	}

	new Thim_SC_Posts();
}