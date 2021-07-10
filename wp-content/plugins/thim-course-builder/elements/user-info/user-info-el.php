<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_User_Info_Element extends Widget_Base {

	public function get_name() {
		return 'thim-user-info';
	}

	public function get_title() {
		return esc_html__( 'Thim: User Info', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-user-info';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'user-info';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'user_info_settings',
			[
				'label' => esc_html__( 'User Info Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'id_user',
			[
				'label'   => esc_html__( 'User ID', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '1',
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
		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_User_Info_Element() );