<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_New_Post_Element extends Widget_Base {

	public function get_name() {
		return 'thim-new-post';
	}

	public function get_title() {
		return esc_html__( 'Thim: Post Simple', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-button';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'new-post';
	}


	protected function _register_controls() {

		$this->start_controls_section(
			'post_simple_settings',
			[
				'label' => esc_html__( 'Post Simple Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'layout-1'   => esc_html__( 'Layout 1', 'course-builder' ),
					'layout-2'   => esc_html__( 'Layout 2', 'course-builder' ),
					'layout-kit' => esc_html__( 'Layout Kit Builder', 'course-builder' )
				],
				'default' => 'layout-1',
			]
		);

		$this->add_control(
			'cat_post',
			[
				'label'     => esc_html__( 'Select Category', 'course-builder' ),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => false,
				'options'   => thim_get_cat_courses( 'category', '', true ),
				'default'   => '0',
				'condition' => [
					'layout' => [ 'layout-2', 'layout-kit' ]
				]
			]
		);

		$this->add_control(
			'number_post',
			[
				'label'     => esc_html__( 'Number Post', 'course-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '1',
				'condition' => [
					'layout' => [ 'layout-2', 'layout-kit' ]
				]
			]
		);

		$this->add_control(
			'id_post',
			[
				'label'       => esc_html__( 'ID post', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'add ID post want show', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'layout' => [ 'layout-1' ]
				]
			]
		);

		$this->add_control(
			'featured_align',
			[
				'label'     => esc_html__( 'Image Align', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'layout-left'  => esc_html__( 'Image Left', 'course-builder' ),
					'layout-right' => esc_html__( 'Image Right', 'course-builder' )
				],
				'default'   => 'layout-left',
				'condition' => [
					'layout' => [ 'layout-1' ]
				]
			]
		);

		$this->add_control(
			'column',
			[
				'label'     => esc_html__( 'Columns', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'2' => esc_html__( '2', 'course-builder' ),
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
					'6' => esc_html__( '6', 'course-builder' )
				],
				'default'   => '3',
				'condition' => [
					'layout' => [ 'layout-2', 'layout-kit' ]
				]
			]
		);

		$this->add_control(
			'icon_upload',
			[
				'label'     => esc_html__( 'Upload Icon In Featured Image', 'course-builder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'layout' => [ 'layout-1' ]
				]
			]
		);

		$this->add_control(
			'text_button',
			[
				'label'       => esc_html__( 'Text View More', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Text view more button', 'course-builder' ),
				'default'     => 'View more'
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
		$settings         = $this->get_settings_for_display();
		$settings['base'] = $this->get_base();


		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_New_Post_Element() );