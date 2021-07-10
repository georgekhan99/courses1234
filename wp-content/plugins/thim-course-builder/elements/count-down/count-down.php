<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Count_Down' ) ) {

	class Thim_SC_Count_Down {

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
			$this->name        = esc_attr__( 'Thim: Countdown', 'course-builder' );
			$this->description = esc_attr__( 'Display a countdown timer.', 'course-builder' );
			$this->base        = 'count-down';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-jquery-countdown', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/libs/jquery.countdown.min.js', array( 'jquery' ), THIM_CB_VERSION, true );
			wp_register_script( 'thim-countdown', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/count-down.js', array(
				'jquery',
				'thim-jquery-countdown'
			), THIM_CB_VERSION, true );
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-count-down.png',
					'params'      => array(
						// Choose Day
						array(
							'type'             => 'datepicker',
							'admin_label'      => true,
							'heading'          => esc_attr__( 'Countdown Date', 'course-builder' ),
							'param_name'       => 'time',
							'edit_field_class' => "vc_col-sm-6",
							'std'              => '2017/09/28 14:00',
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Countdown Title', 'course-builder' ),
							'param_name'  => 'title',
							'value'       => '',
						),

						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Style', 'course-builder' ),
							'param_name'       => 'style',
							'edit_field_class' => 'vc_col-sm-6',
							'value'            => array(
								esc_html__( 'Default', 'course-builder' )      => '',
								esc_html__( 'Contact Form', 'course-builder' ) => 'style2',
							),
							'admin_label'      => true,
						),

						// Extra class
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Extra class', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'Add extra class name for Thim Countdown shortcode to use in CSS customizations.', 'course-builder' ),
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
				'time'     => '2017/09/28 14:00',
				'title'    => '',
				'style'    => '',
				'el_class' => '',
			), $atts );

			ob_start();
			if ( ! is_singular( 'tp_event' ) ) {
				wp_enqueue_script( 'thim-countdown' );
			}

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Count_Down();
}