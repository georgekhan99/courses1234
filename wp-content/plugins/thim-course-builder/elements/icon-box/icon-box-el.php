<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Icon_Box_Element extends Widget_Base {

	public function get_name() {
		return 'thim-icon-box';
	}

	public function get_title() {
		return esc_html__( 'Thim: Icon Box', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-icon-box';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'icon-box';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'icon_box_settings',
			[
				'label' => esc_html__( 'Icon Box Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Select type of icon', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome icon', 'course-builder' ),
					'font_ionicons' => esc_html__( 'Ionicons', 'course-builder' ),
					'upload_icon'   => esc_html__( 'Upload icon', 'course-builder' ),
				],
				'default' => 'font_awesome',
			]
		);

		$this->add_control(
			'font_awesome',
			[
				'label'       => esc_html__( 'Select Icon:', 'course-builder' ),
				'type'        => Controls_Manager::ICON,
				'placeholder' => esc_html__( 'Choose...', 'course-builder' ),
				'condition'   => [
					'icon' => [ 'font_awesome' ]
				]
			]
		);

		$this->add_control(
			'font_ionicons',
			[
				'label'       => esc_html__( 'Select Icon:', 'course-builder' ),
				'type'        => Controls_Manager::ICON,
				'placeholder' => esc_html__( 'Choose...', 'course-builder' ),
				'options'     => \Thim_CB_Elementor_Extend_Icons::get_font_ionicons(),
				'exclude'     => array_keys( Control_Icon::get_icons() ),
				'condition'   => [
					'icon' => [ 'font_ionicons' ]
				]
			]
		);

		$this->add_control(
			'icon_upload',
			[
				'label'     => esc_html__( 'Upload Icon', 'course-builder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon' => [ 'upload_icon' ]
				]
			]
		);

		$this->add_control(
			'box_style',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'layout-1' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-1.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-2' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-2.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-3' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-3.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-4' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-4.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-5' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-5.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-6' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-6.jpg' . '">',
						'icon'  => 'bp_el_class'
					]
				],
				'default' => 'layout-1',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'style_layout',
			[
				'label'     => esc_html__( 'Select type of style', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'default'   => esc_html__( 'Default', 'course-builder' ),
					'style_kit' => esc_html__( 'Style Kit Builder', 'course-builder' ),
				],
				'default'   => 'default',
				'condition' => [
					'box_style' => [ 'layout-3' ]
				]
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Icon Background', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'style_layout' => [ 'style_kit' ]
				]
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'     => esc_html__( 'Icon Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'box_style' => [ 'layout-2' ]
				]
			]
		);

		$this->add_control(
			'icon_title',
			[
				'label'       => esc_html__( 'Icon title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Icon title', 'course-builder' ),
				'default'     => 'Write a Title of icon'
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Icon description', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Write a Description of icon.', 'course-builder' ),
				'default'     => 'Write a Description of icon'
			]
		);

		$this->add_control(
			'icon_link',
			[
				'label'         => __( 'Icon link', 'course-builder' ),
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Icon_Box_Element() );