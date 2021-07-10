<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Text_Box_Element extends Widget_Base {

	public function get_name() {
		return 'thim-text-box';
	}

	public function get_title() {
		return esc_html__( 'Thim: Text Box', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-text-box';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'text-box';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'text_box_settings',
			[
				'label' => esc_html__( 'Text Box Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => __( 'Style', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/styles/style-1.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'center'  => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/styles/style-2.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'style-3' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/styles/style-3.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'style-4' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/styles/style-4.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
				],
				'default' => 'left',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'size_style',
			[
				'label'     => esc_html__( 'Size of Style', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'size-default' => esc_html__( 'Default', 'course-builder' ),
					'size-small'   => esc_html__( 'Small', 'course-builder' ),
				],
				'default'   => 'size-default',
				'condition' => [
					'style' => [ 'style-4' ]
				]
			]
		);

		$this->add_control(
			'title_1',
			[
				'label'       => esc_html__( 'Text Box Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Text Box Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Text Box Content', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Text Box Content', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text Button', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Text Button', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'button',
			[
				'label'         => __( 'Button', 'course-builder' ),
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Text_Box_Element() );