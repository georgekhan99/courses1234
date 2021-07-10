<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Introduction_Box_Element extends Widget_Base {

	public function get_name() {
		return 'thim-introduction-box';
	}

	public function get_title() {
		return esc_html__( 'Thim: Introduction Box', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-introduction-box';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'introduction-box';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'introduction_box_settings',
			[
				'label' => esc_html__( 'Introduction Box Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Select Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Image Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Image Description', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image Description', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'read_more_title',
			[
				'label'       => esc_html__( 'Title Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Title Link', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'read_more',
			[
				'label'         => __( 'More Detail Link', 'course-builder' ),
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
			'box',
			[
				'label'       => esc_html__( 'List Items', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'separator'   => 'before'
			]
		);

		$this->add_control(
			'bg-image',
			[
				'label'   => esc_html__( 'Background Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->add_control(
			'el_id',
			[
				'label'       => esc_html__( 'Element ID', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Element ID', 'course-builder' ),
				'default'     => ''
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Introduction_Box_Element() );