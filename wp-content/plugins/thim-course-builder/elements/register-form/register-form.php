<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Regisrer_Form' ) ) {

	class Thim_SC_Regisrer_Form {

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
			$this->name        = esc_attr__( 'Thim: Register Form', 'course-builder' );
			$this->description = esc_attr__( 'Display a register form.', 'course-builder' );
			$this->base        = 'register-form';
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-login-form.png',
					'params'      => array(
						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Display Captcha', 'course-builder' ),
							'param_name' => 'captcha',
							'std'        => false,
						),

						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Terms of Service link', 'course-builder' ),
							'param_name'  => 'term',
							'value'       => '',
							'description' => esc_html__( 'Leave empty to disable this field.', 'course-builder' ),
						),

						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Display field phone', 'course-builder' ),
							'param_name' => 'phone',
							'std'        => false,
						),

						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Display First Name', 'course-builder' ),
							'param_name' => 'first_name',
							'std'        => false,
						),

						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Display Last Name', 'course-builder' ),
							'param_name' => 'last_name',
							'std'        => false,
						),

						// Extra class
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Extra class', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'Add extra class name for Thim Login shortcode to use in CSS customizations.', 'course-builder' ),
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
				'captcha'    => false,
				'term'       => '',
				'phone'      => false,
				'first_name' => false,
				'last_name'  => false,
				'el_class'   => '',
			), $atts );

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Regisrer_Form();
}