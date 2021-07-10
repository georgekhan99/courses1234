<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_User_Info' ) ) {

	class Thim_SC_User_Info {

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
			$this->name        = esc_attr__( 'Thim: User Info', 'course-builder' );
			$this->description = esc_attr__( 'Display information of an user', 'course-builder' );
			$this->base        = 'user-info';
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-user-info.png',
					'params'      => array(
						array(
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_attr__( 'User ID', 'course-builder' ),
							'param_name'  => 'id_user',
							'value'       => '1',
                            'description' => esc_html__( 'User ID ca be found in profile setting', 'course-builder' ),
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim User Info shortcode to use in CSS customizations.', 'course-builder' ),
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
		public function shortcode( $atts ) {

			$params = shortcode_atts( array(
				'id_user'  => '1',
				'el_class' => '',
			), $atts );

			ob_start();
			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}
	}

	new Thim_SC_User_Info();
}
