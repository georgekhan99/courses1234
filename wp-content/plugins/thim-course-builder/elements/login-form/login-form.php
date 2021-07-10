<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Login_Forms' ) ) {

	class Thim_SC_Login_Form {

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
			$this->name        = esc_attr__( 'Thim: Login', 'course-builder' );
			$this->description = esc_attr__( 'Add login form.', 'course-builder' );
			$this->base        = 'login-form';
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
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-login-form.png',
					'description' => $this->description,
					'params'      => array(
						array(
							"type"       => "dropdown",
							"heading"    => esc_attr__( "Display", 'course-builder' ),
							"param_name" => "display",
							"value"      => array(
								esc_attr__( "Login Form (Account page)", 'course-builder' )        => 'form',
								esc_attr__( "Link to form popup", 'course-builder' )               => 'link-form',
								esc_attr__( "Link to account page (OFF POPUP)", 'course-builder' ) => 'link',
							),
						),
						array(
							"type"       => "textfield",
							"heading"    => esc_html__( "Register Text", 'course-builder' ),
							"param_name" => "text_register",
							"value"      => 'Register',
							"dependency" => array(
								"element" => "display",
								"value"   => array( "link-form" ),
							),
						),
						array(
							"type"       => "textfield",
							"heading"    => esc_html__( "Login Text", 'course-builder' ),
							"param_name" => "text_login",
							"value"      => 'Login',
							"dependency" => array(
								"element" => "display",
								"value"   => array( "link-form" ),
							),
						),
						array(
							"type"       => "textfield",
							"heading"    => esc_html__( "Logout Text", 'course-builder' ),
							"param_name" => "text_logout",
							"value"      => 'Logout',
							"dependency" => array(
								"element" => "display",
								"value"   => array( "link-form" ),
							),
						),
						array(
							"type"       => "exploded_textarea",
							"heading"    => esc_html__( "Social Login Shortcode", 'course-builder' ),
							"param_name" => "content",
							"dependency" => array(
								"element" => "display",
								"value"   => array( "link-form" ),
							),
						),

						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Enable Login Popup', 'course-builder' ),
							'std'         => true,
							'param_name'  => 'popup',
							'admin_label' => true,
							"dependency"  => array(
								"element" => "display",
								"value"   => array( "link-form" ),
							),
						),

						array(
							'type'             => 'checkbox',
							'heading'          => esc_html__( 'Display Captcha', 'course-builder' ),
							'param_name'       => 'captcha',
							'std'              => false,
							'edit_field_class' => 'vc_col-sm-6',
							'dependency'       => array(
								'element' => 'display',
								'value'   => array(
									'form',
									'link-form',
								)
							)
						),


						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Terms of Service link', 'course-builder' ),
							'param_name'  => 'term',
							'value'       => '',
							'description' => esc_html__( 'Leave empty to disable this field.', 'course-builder' ),
							'dependency'  => array(
								'element' => 'display',
								'value'   => array(
									'form',
									'link-form'
								)
							)
						),

						array(
							'type'             => 'checkbox',
							'heading'          => esc_html__( 'Display field phone', 'course-builder' ),
							'param_name'       => 'phone',
							'std'              => false,
							'dependency'  => array(
								'element' => 'display',
								'value'   => array(
									'form',
									'link-form'
								)
							)
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
		public function shortcode( $atts, $content = null ) {

			$params = shortcode_atts( array(
				'display'       => 'form',
				'text_login'    => __( 'Login', 'course-builder' ),
				'text_logout'   => __( 'Logout', 'course-builder' ),
				'text_register' => __( 'Register', 'course-builder' ),
				'content'       => '',
				'term'          => '',
				'captcha'       => false,
				'phone'         => false,
				'first_name'    => false,
				'last_name'     => false,
				'el_class'      => '',
				'popup'         => true,
			), $atts );

			$params['content'] = wpb_js_remove_wpautop( $content, true ); // fix unclosed/unwanted paragraph tags in $content

			ob_start();

			thim_get_template( $params['display'], array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

	}

	new Thim_SC_Login_Form();
}