<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Featured_Element extends Widget_Base {

	public function get_name() {
		return 'thim-featured';
	}

	public function get_title() {
		return esc_html__( 'Thim: Features List', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-features-list';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'features-list';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'featured_settings',
			[
				'label' => esc_html__( 'Featured Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Features list title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Features list title', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Styles', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''       => esc_html__( 'Default', 'course-builder' ),
					'style-1' => esc_html__( 'Style 1', 'course-builder' ),
				],
				'default' => '',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'sub_title',
			[
				'label'       => esc_html__( 'Feature title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Feature title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Feature description', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Feature description', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'         => __( 'Feature Link', 'course-builder' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'course-builder' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'features_list',
			[
				'label'       => esc_html__( 'Feature List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ sub_title }}}',
				'separator'   => 'before'
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Featured_Element() );