<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_New_Instructor_Element extends Widget_Base {

	public function get_name() {
		return 'thim-new-instructor';
	}

	public function get_title() {
		return esc_html__( 'Thim: Instructor Simple', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-button';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'new-instructor';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'instructor_settings',
			[
				'label' => esc_html__( 'Instructor Simple Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Colums', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
					'2' => esc_html__( '2', 'course-builder' ),
				],
				'default' => '2',
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '4',
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
		$settings                 = $this->get_settings_for_display();
		$settings['rank']         = 0;
		$settings['current_page'] = $settings['page'] = $page = 1;
		$settings['sc-name']      = $this->get_base();
 		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_New_Instructor_Element() );