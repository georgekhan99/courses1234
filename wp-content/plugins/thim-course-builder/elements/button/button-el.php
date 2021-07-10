<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Button_Element extends Widget_Base {

	public function get_name() {
		return 'thim-button';
	}

	public function get_title() {
		return esc_html__( 'Thim: Button', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-button';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'button';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'button_settings',
			[
				'label' => esc_html__( 'Button Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Button Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'link',
			[
				'label'         => __( 'Button Link', 'course-builder' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'course-builder' ),
				'show_external' => false,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => esc_html__( 'Select Button Size', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'btn-lg' => esc_html__( 'Large', 'course-builder' ),
					'btn-md' => esc_html__( 'Medium', 'course-builder' ),
					'btn-sm' => esc_html__( 'Small', 'course-builder' ),
					'btn-xs' => esc_html__( 'XSmall', 'course-builder' )
				],
				'default' => 'btn-lg',
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Select Button Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'primary'   => esc_html__( 'Primary', 'course-builder' ),
					'secondary' => esc_html__( 'Secondary', 'course-builder' ),
					'basic'     => esc_html__( 'Basic', 'course-builder' ),
					'style_kit' => esc_html__( 'Kit gradient', 'course-builder' ),
				],
				'default' => 'primary',
			]
		);

		$this->add_control(
			'separator',
			[
				'label'   => esc_html__( 'Button Separator', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'hide-separator' => esc_html__( 'Hide', 'course-builder' ),
					'show-separator' => esc_html__( 'Show', 'course-builder' )
				],
				'default' => 'hide-separator',
			]
		);

		$this->add_control(
			'target',
			[
				'label'   => esc_html__( 'Open button link in new tab?', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'align',
			[
				'label'   => esc_html__( 'Select Button Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'   => esc_html__( 'Left', 'course-builder' ),
					'right'  => esc_html__( 'Right', 'course-builder' ),
					'center' => esc_html__( 'Center', 'course-builder' ),
				],
				'default' => 'left',
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
		$settings['link'] = isset($settings['link']) ? $settings['link']['url'] : '';
		thim_get_template( 'default', array( 'params' => $settings ), $this->get_base() . '/tpl/' );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Button_Element() );