<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Text_Box' ) ) {

	class Thim_SC_Text_Box {

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
			$this->name        = esc_attr__( 'Thim: Text Box', 'course-builder' );
			$this->description = esc_attr__( 'Display a Text Box.', 'course-builder' );
			$this->base        = 'text-box';
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-text-box.png',
					'params'      => array(

						array(
							"type"       => "radio_image",
							"heading"    => esc_attr__( "Select Style", 'course-builder' ),
							"param_name" => "style",
							"options"    => array(
								'left'    => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/styles/style-1.jpg',
								'center'  => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/styles/style-2.jpg',
								'style-3' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/styles/style-3.jpg',
								'style-4' => THIM_CB_ELEMENTS_URL . $this->base . '/assets/images/styles/style-4.jpg',
							),
						),

						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Size of Style', 'course-builder' ),
							'param_name'       => 'size_style',
							'edit_field_class' => 'vc_col-sm-3',
							'value'            => array(
								esc_html__( 'Default', 'course-builder' ) => 'size-default',
								esc_html__( 'Small', 'course-builder' )   => 'size-small',
							),
							'admin_label'      => true,
							'dependency'       => array(
								'element' => 'style',
								'value'   => array(
									'style-4'
								),
							),
						),

						// Text 1
						array(
							'type'        => 'textarea',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Text Box Title', 'course-builder' ),
							'param_name'  => 'title_1',
						),
						// Text 2
						array(
							'type'        => 'textarea',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Text Box Content', 'course-builder' ),
							'param_name'  => 'content',
						),

						array(
							'type'       => 'vc_link',
							'heading'    => esc_html__( 'Button', 'course-builder' ),
							'param_name' => 'button',
						),

						// Extra class
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Extra class', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'Add extra class name for Thim Text Box shortcode to use in CSS customizations.', 'course-builder' ),
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
		public function shortcode( $atts, $content = null ) {

			$params = shortcode_atts( array(
				'title_1'     => '',
				'title_2'     => '',
				'button'      => '',
				'el_class'    => '',
				'style'       => 'left',
				'size_style'  => 'size-default'
			), $atts );

			$params['content'] = wpb_js_remove_wpautop( $content, true ); // fix unclosed/unwanted paragraph tags in $content

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Text_Box();
}