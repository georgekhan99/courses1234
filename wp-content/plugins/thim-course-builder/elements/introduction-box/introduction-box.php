<?php
/**
 * Created by PhpStorm
 * Project: wordpress-lms
 * Filename: introduction-box.php
 * User: longvv
 * Time: 1/3/2018 3:18 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! class_exists( 'Thim_SC_Introduction_Box' ) ) {

	class Thim_SC_Introduction_Box {

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
			$this->name        = esc_attr__( 'Thim: Introduction Box', 'course-builder' );
			$this->description = esc_attr__( 'Display a section for introductory purpose', 'course-builder' );
			$this->base        = 'introduction-box';
			//====================== END: CONFIG =====================


			$this->map();
			//			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
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
				'icon'        => THIM_CB_URL . '/assets/images/icon/sc-introduction-box.png',
				'params'      => array(
					array(
						'type'             => 'param_group',
						'heading'          => esc_html__( 'List Items', 'course-builder' ),
						'param_name'       => 'box',
						'value'            => '',
						'edit_field_class' => 'photo-wall-list',
						'params'           => array(
							array(
								'type'       => 'attach_image',
								'heading'    => esc_html__( 'Select Image', 'course-builder' ),
								'param_name' => 'image',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Image Title', 'course-builder' ),
								'param_name' => 'title',
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Image Description', 'course-builder' ),
								'param_name' => 'description',
							),
							array(
								'type'       => 'vc_link',
								'heading'    => esc_html__( 'More Detail Link', 'course-builder' ),
								'param_name' => 'read_more',
							),
						)
					),

					array(
						"type"       => "attach_image",
						"heading"    => esc_html__( "Background Image", 'course-builder' ),
						"param_name" => "bg-image",
					),

					array(
						'type'        => 'el_id',
						'heading'     => esc_attr__( 'Element ID', 'course-builder' ),
						'param_name'  => 'el_id',
						'admin_label' => true,
						'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'course-builder' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
					),

					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__( 'Extra class', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'Add extra class name for Thim: Introduction Box shortcode to use in CSS customizations.', 'course-builder' ),
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
				'box'      => '',
				'bg-image' => '',
				'el_id'    => '',
				'el_class' => '',
			), $atts );


			$params['box'] = vc_param_group_parse_atts( $params['box'] );

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Introduction_Box();
}