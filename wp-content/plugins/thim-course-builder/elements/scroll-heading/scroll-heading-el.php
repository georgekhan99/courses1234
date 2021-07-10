<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Scroll_Heading_Element extends Widget_Base {

	public function get_name() {
		return 'thim-scroll-heading';
	}

	public function get_title() {
		return esc_html__( 'Thim: Scroll Heading', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-scroll-heading';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'scroll-heading';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-sc-scroll-heading', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/scroll-heading.js', array( 'jquery' ),THIM_CB_VERSION, true );
  		wp_enqueue_script( 'thim-sc-scroll-heading' );

		$this->start_controls_section(
			'scroll_heading_settings',
			[
				'label' => esc_html__( 'Scroll Heading Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'class',
			[
				'label'       => esc_html__( 'Class', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Not use space', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'titles',
			[
				'label'       => esc_html__( 'Titles List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'separator'   => 'before'
			]
		);

		$this->add_control(
			'scroll_speed',
			[
				'label'   => esc_html__( 'Scroll speed', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => '0',
				'default' => '700',
			]
		);

		$this->add_control(
			'scroll_offset',
			[
				'label'   => esc_html__( 'Scroll offset', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => '10',
				'default' => '10',
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

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Scroll_Heading_Element() );