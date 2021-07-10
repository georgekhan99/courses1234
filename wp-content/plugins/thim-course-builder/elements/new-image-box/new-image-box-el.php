<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_New_Image_Box_Element extends Widget_Base {

	public function get_name() {
		return 'thim-new-image-box';
	}

	public function get_title() {
		return esc_html__( 'Thim: Image Box Simple', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-button';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'new-image-box';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'image_box_settings',
			[
				'label' => esc_html__( 'Image Box Simple Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'upload_image_background',
			[
				'label'   => esc_html__( 'Upload Image Background', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

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
			'link_title',
			[
				'label'       => esc_html__( 'Link in title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Link in title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'icon_image',
			[
				'label'   => esc_html__( 'Icon image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Content align', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'  => esc_html__( 'Left', 'course-builder' ),
					'right' => esc_html__( 'Right', 'course-builder' )
				],
				'default' => 'left',
			]
		);

		$this->add_control(
			'image_box',
			[
				'label'       => esc_html__( 'Images Box', 'course-builder' ),
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

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_New_Image_Box_Element() );