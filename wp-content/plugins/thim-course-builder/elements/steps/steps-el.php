<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Steps_Element extends Widget_Base {

	public function get_name() {
		return 'thim-steps';
	}

	public function get_title() {
		return esc_html__( 'Thim: Steps', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-steps';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'steps';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'steps_settings',
			[
				'label' => esc_html__( 'Steps Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Thim Steps title', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Thim Steps title', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'layout',
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
				],
				'default' => 'layout-1',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'video_url',
			[
				'label'       => esc_html__( 'Video URL', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Video URL', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'layout' => [ 'layout-4' ]
				]
			]
		);

		$this->add_control(
			'circle-text',
			[
				'label'       => esc_html__( 'Step circle text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Step circle text', 'course-builder' ),
				'default'     => 'step',
			]
		);

		$this->add_control(
			'style_layout',
			[
				'label'     => esc_html__( 'Style', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'default'  => esc_html__( 'Default', 'course-builder' ),
					'style-02' => esc_html__( 'With description', 'course-builder' ),
				],
				'default'   => 'default',
				'condition' => [
					'layout' => [ 'layout-1' ]
				]
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Description', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'style_layout' => [ 'style-02' ]
				]
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => esc_html__( 'Image', 'course-builder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'layout' => [ 'layout-1', 'layout-2', 'layout-3' ]
				]
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'     => esc_html__( 'Background Image', 'course-builder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'layout' => [ 'layout-3', 'layout-4' ]
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title_step',
			[
				'label'       => esc_html__( 'Step Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Step Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'description_step',
			[
				'label'       => esc_html__( 'Step Description', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Step Description', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'readmore',
			[
				'label'       => esc_html__( 'Read more URL', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Read more URL', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Select type of icon', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'course-builder' ),
					'font_ionicons' => esc_html__( 'Ionicons', 'course-builder' ),
					'upload_icon'   => esc_html__( 'Upload', 'course-builder' ),
				],
				'default' => 'font_awesome',
			]
		);

		$repeater->add_control(
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

		$repeater->add_control(
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

		$repeater->add_control(
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
			'steps',
			[
				'label'       => esc_html__( 'Steps List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title_step }}}',
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

		$params = array(
			'title'            => $settings['title'],
			'description'      => $settings['description'],
			'circle-text'      => $settings['circle-text'],
			'style_layout'     => $settings['style_layout'],
			'layout'           => $settings['layout'],
			'video_url'        => $settings['video_url'],
			'image'            => $settings['image'],
			'background_image' => $settings['background_image'],
			'steps'            => $settings['steps'],
			'el_class'         => $settings['el_class'],
		);

		$params['base']  = $this->get_base();
		thim_get_template( 'default', array( 'params' => $params ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $params ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Steps_Element() );