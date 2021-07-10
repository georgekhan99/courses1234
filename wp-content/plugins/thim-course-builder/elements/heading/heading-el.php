<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Heading_Element extends Widget_Base {

	public function get_name() {
		return 'thim-heading';
	}

	public function get_title() {
		return esc_html__( 'Thim: Heading', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-heading';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'heading';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'heading_settings',
			[
				'label' => esc_html__( 'Heading Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'heading_style',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'default'    => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-1.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-2'   => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-2.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-kit' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-2.jpg' . '">',
						'icon'  => 'bp_el_class'
					]
				],
				'default' => 'default',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'primary_heading',
			[
				'label'       => esc_html__( 'Heading title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Heading title', 'course-builder' ),
				'default'     => 'Primary text'
			]
		);

		$this->add_control(
			'primary_heading_2',
			[
				'label'       => esc_html__( 'Heading title line 2', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Heading title 2', 'course-builder' ),
				'default'     => 'Primary text 2',
				'condition'   => [
					'heading_style' => [ 'layout-kit' ]
				]
			]
		);

		$this->add_control(
			'secondary_heading',
			[
				'label'       => esc_html__( 'Heading subtitle', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Heading subtitle', 'course-builder' ),
				'default'     => 'Secondary text'
			]
		);

		$this->add_control(
			'heading_icon',
			[
				'label'     => esc_html__( 'Upload Heading Icon', 'course-builder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'heading_style' => [ 'default' ]
				]
			]
		);

		$this->add_control(
			'heading_position',
			[
				'label'   => esc_html__( 'Select Heading Align', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'center' => esc_html__( 'Center', 'course-builder' ),
					'right'  => esc_html__( 'Right', 'course-builder' ),
					'left'   => esc_html__( 'Left', 'course-builder' ),
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'separator',
			[
				'label'     => esc_html__( 'Show heading separator?', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'heading_style' => [ 'default', 'layout-2' ]
				]
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

		$this->start_controls_section(
			'heading_config',
			[
				'label' => esc_html__( 'Heading Config', 'course-builder' )
			]
		);

		$this->add_control(
			'tag',
			[
				'label'   => esc_html__( 'Heading Tag', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h2' => esc_html__( 'H2', 'course-builder' ),
					'h3' => esc_html__( 'H3', 'course-builder' ),
					'h4' => esc_html__( 'H4', 'course-builder' ),
					'h5' => esc_html__( 'H5', 'course-builder' ),
					'h6' => esc_html__( 'H6', 'course-builder' ),
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'heading_custom',
			[
				'label'   => esc_html__( 'Advanced', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'font_size',
			[
				'label'     => esc_html__( 'Font size', 'course-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => '0',
				'default'   => '',
				'condition' => [
					'heading_custom' => [ 'yes' ]
				]
			]
		);

		$this->add_control(
			'font_weight',
			[
				'label'     => esc_html__( 'Font Weight', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'normal' => esc_html__( 'Normal', 'course-builder' ),
					'bold'   => esc_html__( 'Bold', 'course-builder' ),
					'100'    => esc_html__( '100', 'course-builder' ),
					'200'    => esc_html__( '200', 'course-builder' ),
					'300'    => esc_html__( '300', 'course-builder' ),
					'400'    => esc_html__( '400', 'course-builder' ),
					'500'    => esc_html__( '500', 'course-builder' ),
					'600'    => esc_html__( '600', 'course-builder' ),
					'700'    => esc_html__( '700', 'course-builder' ),
					'800'    => esc_html__( '800', 'course-builder' ),
					'900'    => esc_html__( '900', 'course-builder' ),
				],
				'default'   => 'normal',
				'condition' => [
					'heading_custom' => [ 'yes' ]
				]
			]
		);

		$this->add_control(
			'font_style',
			[
				'label'     => esc_html__( 'Font Weight', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'normal'  => esc_html__( 'Normal', 'course-builder' ),
					'italic'  => esc_html__( 'Italic', 'course-builder' ),
					'oblique' => esc_html__( 'Oblique', 'course-builder' ),
					'initial' => esc_html__( 'Initial', 'course-builder' ),
					'inherit' => esc_html__( 'Inherit', 'course-builder' ),
				],
				'default'   => 'normal',
				'condition' => [
					'heading_custom' => [ 'yes' ]
				]
			]
		);

		$this->add_control(
			'font_color',
			[
				'label'     => esc_html__( 'Font Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'heading_custom' => [ 'yes' ]
				]
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Heading_Element() );