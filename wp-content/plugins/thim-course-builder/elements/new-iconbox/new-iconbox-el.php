<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_New_IconBox_Element extends Widget_Base {

	public function get_name() {
		return 'thim-new-iconbox';
	}

	public function get_title() {
		return esc_html__( 'Thim: Simple Icon Box', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-icon-box';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'new-iconbox';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'simple_iconbox_settings',
			[
				'label' => esc_html__( 'Simple IconBox Settings', 'course-builder' )
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
			'primary_color',
			[
				'label'     => esc_html__( 'Icon Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'icon' => [ 'font_ionicons', 'font_awesome' ]
				]
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'layout-1' => esc_html__( 'Layout 1', 'course-builder' ),
					'layout-2' => esc_html__( 'Layout 2', 'course-builder' ),
				],
				'default' => 'layout-1',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Icon title', 'course-builder' ),
				'default'     => 'Write a Title of icon',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
			]
		);

		$this->add_control(
			'title_line_2',
			[
				'label'       => esc_html__( 'Title line 2', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Icon title line 2', 'course-builder' ),
				'default'     => 'Write a Title of icon',
				'condition'   => [
					'layout' => [ 'layout-2' ]
				]
			]
		);
		$this->add_control(
			'title_line_color',
			[
				'label'     => esc_html__( 'Title line 2 Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
				'condition'   => [
					'layout' => [ 'layout-2' ]
				]
			]
		);
		$this->add_control(
			'border_left',
			[
				'label'     => esc_html__( 'Border Left', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => [
					'layout' => [ 'layout-2' ]
				]
			]
		);
		$this->add_control(
			'border_left_color',
			[
				'label'     => esc_html__( 'Border Left Color', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
				'condition'   => [
					'layout' => [ 'layout-2' ]
				]
			]
		);
		$this->add_control(
			'icon_link',
			[
				'label'         => __( 'Icon Link', 'course-builder' ),
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
		$settings           = $this->get_settings_for_display();
		$settings['base'] = $this->get_base();

		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_New_IconBox_Element() );