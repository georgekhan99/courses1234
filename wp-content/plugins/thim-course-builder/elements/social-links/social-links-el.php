<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Social_Link_Element extends Widget_Base {

	public function get_name() {
		return 'thim-social-links';
	}

	public function get_title() {
		return esc_html__( 'Thim: Social Links', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-social-links';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'social-links';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'social_links_settings',
			[
				'label' => esc_html__( 'Social Links Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'List Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'List Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label'       => esc_html__( 'Social network name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social network name', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Social network link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social network link', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'social_links',
			[
				'label'       => esc_html__( 'Socials List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Social_Link_Element() );