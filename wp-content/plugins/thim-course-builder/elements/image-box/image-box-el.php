<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Image_Box_Element extends Widget_Base {

	public function get_name() {
		return 'thim-image-box';
	}

	public function get_title() {
		return esc_html__( 'Thim: Image Box', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-image-box';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'image-box';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'image_box_settings',
			[
				'label' => esc_html__( 'Image Box Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'upload_image',
			[
				'label'   => esc_html__( 'Upload Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->add_control(
			'number',
			[
				'label'   => esc_html__( 'Image number', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '2',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Number Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.6)',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Image title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image title', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'sub-title',
			[
				'label'       => esc_html__( 'Image subtitle', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image subtitle', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Image content', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Image content', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'bg_content',
			[
				'label'   => esc_html__( 'Content Background Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Image float', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'  => esc_html__( 'Left', 'course-builder' ),
					'right' => esc_html__( 'Right', 'course-builder' ),
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

 		$settings['upload_image'] = isset($settings['upload_image'] ) ? $settings['upload_image']['id'] : '';
 		$settings['bg_content'] = isset($settings['bg_content'] ) ? $settings['bg_content']['id'] : '';

		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Image_Box_Element() );