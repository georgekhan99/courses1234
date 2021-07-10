<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_New_Instructors' ) ) {

	class Thim_SC_New_Instructors {

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
			$this->name        = esc_attr__( 'Thim: New Instructors', 'course-builder' );
			$this->description = esc_attr__( 'Display list of instructors', 'course-builder' );
			$this->base        = 'new-instructor';
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
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'description' => $this->description,
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-instructors.png',
				'params'      => array(

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Columns', 'course-builder' ),
						'param_name'  => 'columns',
						'admin_label' => true,
						'value'       => array(
							esc_html__( '3', 'course-builder' ) => '3',
							esc_html__( '4', 'course-builder' ) => '4',
							esc_html__( '2', 'course-builder' ) => '2',
						),

						'edit_field_class' => 'vc_col-xs-4',
					),

					array(
						'type'             => 'number',
						'heading'          => esc_html__( 'Limit', 'course-builder' ),
						'param_name'       => 'limit',
						'value'            => '20',
						'admin_label'      => true,
						'edit_field_class' => 'vc_col-xs-4',
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__( 'Extra class', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'course-builder' ),
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
				'columns'  => '',
				'limit'    => '20',
				'el_class' => '',
			), $atts );

			$params['rank']         = 0;
			$params['current_page'] = $params['page'] = $page = 1;
			$params['sc-name']      = $this->base;

			ob_start();
			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}
	}

	new Thim_SC_New_Instructors();
}