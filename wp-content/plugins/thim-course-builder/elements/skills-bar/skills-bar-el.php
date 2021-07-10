<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Skill_Bar_Element extends Widget_Base {

	public function get_name() {
		return 'thim-skills-bar';
	}

	public function get_title() {
		return esc_html__( 'Thim: Skills Bar', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-skills-bar';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'skills-bar';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-sc-skills-bar', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/skills-bar-custom.js', array(
			'jquery',
			'circle-progress'
		),THIM_CB_VERSION, true );

		wp_enqueue_script( 'thim-sc-skills-bar' );

		$this->start_controls_section(
			'skills_bar_settings',
			[
				'label' => esc_html__( 'Skills Bar Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'number',
			[
				'label'   => esc_html__( 'Enter a Number', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '50',
			]
		);

		$repeater->add_control(
			'sub_title',
			[
				'label'       => esc_html__( 'Subtitle', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Subtitle', 'course-builder' ),
				'default'     => 'courses'
			]
		);

		$repeater->add_control(
			'numbertitle',
			[
				'label'     => esc_html__( 'Number and Subtitle color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#999999',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Title', 'course-builder' ),
				'default'     => 'WEB DEVELOPMENT'
			]
		);

		$repeater->add_control(
			'color',
			[
				'label'     => esc_html__( 'Title Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#255255',
			]
		);

		$repeater->add_control(
			'emptyfill',
			[
				'label'     => esc_html__( 'EmptyFill Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#999999',
			]
		);

		$this->add_control(
			'skills_bar',
			[
				'label'       => esc_html__( 'Skill List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
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

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $settings ) );

	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Skill_Bar_Element() );