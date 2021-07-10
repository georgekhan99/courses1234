<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Scroll_Heading' ) ) {

	class Thim_SC_Scroll_Heading {

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
			$this->name        = esc_attr__( 'Thim: Scroll Heading', 'course-builder' );
			$this->description = esc_attr__( 'Display a link/button scroll.', 'course-builder' );
			$this->base        = 'scroll-heading';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}


		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-scroll-heading', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/scroll-heading.js', array( 'jquery' ),THIM_CB_VERSION, true );

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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-scroll-heading.png',
				'params'      => array(

					array(
						'heading'    => esc_attr__( 'Titles', 'course-builder' ),
						'type'       => 'param_group',
						'value'      => '',
						'param_name' => 'titles',
						'params'     => array(
							array(
								'type'       => 'textfield',
								'value'      => '',
								'heading'    => 'Title',
								'param_name' => 'title',
							),
							array(
								'type'       => 'textfield',
								'value'      => '',
								'heading'    => 'Class',
								'param_name' => 'class',
							),
						),
					),

					array(
						'type'             => 'number',
						'admin_label'      => true,
						'heading'          => esc_html__( 'Scroll speed ', 'course-builder' ),
						'param_name'       => 'scroll_speed',
						'min'              => 0,
						'value'            => '700',
						'edit_field_class' => 'vc_col-sm-6',
					),
					array(
						'type'             => 'number',
						'admin_label'      => true,
						'heading'          => esc_html__( 'Scroll offset ', 'course-builder' ),
						'param_name'       => 'scroll_offset',
						'min'              => 10,
						'value'            => '0',
						'edit_field_class' => 'vc_col-sm-6',
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Scroll Heading shortcode to use in CSS customizations.', 'course-builder' ),
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
				'title'         => '',
				'class'         => '',
				'titles'        => '',
				'el_class'      => '',
				'scroll_speed'  => '700',
				'scroll_offset' => '0',

			), $atts );

			$params['base']   = $this->base;
			$params['titles'] = vc_param_group_parse_atts( $params['titles'] );

			ob_start();
			wp_enqueue_script( 'thim-sc-scroll-heading' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Scroll_Heading();
}

