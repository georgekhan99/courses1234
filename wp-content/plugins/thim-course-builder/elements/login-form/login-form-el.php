<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Login_Form_Element extends Widget_Base {

	public function get_name() {
		return 'thim-login-form';
	}

	public function get_title() {
		return esc_html__( 'Thim: Login Form', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-login-form';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'login-form';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'login_form_settings',
			[
				'label' => esc_html__( 'Login Form Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'display',
			[
				'label'   => esc_html__( 'Display', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'form'      => esc_html__( 'Login Form (Account page)', 'course-builder' ),
					'link-form' => esc_html__( 'Link to form popup', 'course-builder' ),
					'link'      => esc_html__( 'Link to account page (OFF POPUP)', 'course-builder' ),
				],
				'default' => 'link-form',
			]
		);

		$this->add_control(
			'text_register',
			[
				'label'       => esc_html__( 'Register Text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Register', 'course-builder' ),
				'label_block' => false,
				'condition'   => array(
					'display' => [ 'link-form', 'link' ]
				)
			]
		);

		$this->add_control(
			'text_login',
			[
				'label'       => esc_html__( 'Login Text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Login', 'course-builder' ),
				'label_block' => false,
				'condition'   => array(
					'display' => [ 'link-form', 'link' ]
				)
			]
		);

		$this->add_control(
			'text_logout',
			[
				'label'       => esc_html__( 'Logout Text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Logout', 'course-builder' ),
				'label_block' => false,
				'condition'   => array(
					'display' => [ 'link-form', 'link' ]
				)
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Social Login Shortcode', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => false,
				'condition'   => array(
					'display' => [ 'link-form' ]
				)
			]
		);

		$this->add_control(
			'popup',
			[
				'label'     => esc_html__( 'Login Popup', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => false,
				'condition' => array(
					'display' => [ 'link-form' ]
				)
			]
		);

		$this->add_control(
			'captcha',
			[
				'label'     => esc_html__( 'Show Captcha', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => false,
				'condition' => array(
					'display' => [ 'link-form', 'form' ]
				)
			]
		);

		$this->add_control(
			'term',
			[
				'label'       => esc_html__( 'Term link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => false,
				'condition'   => array(
					'display' => [ 'link-form' ]
				)
			]
		);

		$this->add_control(
			'phone',
			[
				'label'   => esc_html__( 'Display field phone', 'course-builder' ),
				'description' => esc_html__('only with register form','course-builder'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => false,
				'condition' => array(
					'display' => [ 'link-form', 'form' ]
				)
			]
		);

		$this->add_control(
			'el_class',
			[
				'label'       => esc_html__( 'Extra Class', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Extra Class', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( ! isset( $settings['display'] ) ) {
			$settings['display'] = 'form';
		}
		thim_get_template( $settings['display'], array( 'params' => $settings ), $this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ), $settings['display'] );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Login_Form_Element() );