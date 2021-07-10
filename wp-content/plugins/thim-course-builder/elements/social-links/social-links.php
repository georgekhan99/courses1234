<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Social_Links' ) ) {

	class Thim_SC_Social_Links {

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
			$this->name        = esc_attr__( 'Thim: Social Links', 'course-builder' );
			$this->description = esc_attr__( 'Display a list of your social accounts.', 'course-builder' );
			$this->base        = 'social-links';
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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-social-links.png',
				'params'      => array(
					array(
						"type"        => "textfield",
						"heading"     => esc_attr__( "List Title", 'course-builder' ),
						"param_name"  => "title",
						"admin_label" => true,
					),

					array(
						'type'       => 'param_group',
						'value'      => '',
						'param_name' => 'social_links',
						'params'     => array(


							array(
								"type"       => "textfield",
								"heading"    => esc_html__( "Social network name", 'course-builder' ),
								"param_name" => "name",
							),

							array(
								"type"       => "textfield",
								"heading"    => esc_html__( "Social network ink", 'course-builder' ),
								"param_name" => "link",
								"value"      => '#',
							),

						)
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_attr__( 'Add extra class name for Thim Social Links shortcode to use in CSS customizations.', 'course-builder' ),
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
				'title'        => '',
				'social_links' => '',
				'el_class'     => '',
			), $atts );


			$params['social_links'] = vc_param_group_parse_atts( $params['social_links'] );

			ob_start();
			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}


	}

	new Thim_SC_Social_Links();
}