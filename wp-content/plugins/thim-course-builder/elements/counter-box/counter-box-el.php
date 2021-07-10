<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Counter_Box_Element extends Widget_Base {

	public function get_name() {
		return 'thim-counter-box';
	}

	public function get_title() {
		return esc_html__( 'Thim: Counter Box', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-sc-counter-box';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'counter-box';
	}
 	protected function _register_controls() {
		wp_enqueue_script( 'thim-counter-box',  THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/counter-box.js', array(
			'jquery',
			'waypoints'
		),THIM_CB_VERSION, true );
		$this->start_controls_section(
			'counter_box_settings',
			[
				'label' => esc_html__( 'Counter Box Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'counter_style',
			[
				'label'   => esc_html__( '* Counter Box Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'style-1' => esc_html__( 'Style 1', 'course-builder' ),
					'style-2' => esc_html__( 'Style 2', 'course-builder' ),
					'circle'  => esc_html__( 'Circle', 'course-builder' ),
				],
				'default' => 'style-1',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Counter Box Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Counter Box Title', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'style-1', 'style-2' ]
				]
			]
		);

		$this->add_control(
			'line_counter',
			[
				'label'     => esc_html__( 'Show symbol separator', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => [
					'counter_style' => [ 'style-1', 'style-2' ]
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'number_counter',
			[
				'label'   => esc_html__( '* Quantity', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '1000',
			]
		);

		$repeater->add_control(
			'currency_counter',
			[
				'label'       => esc_html__( 'Currency', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Currency', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'unit',
			[
				'label'       => esc_html__( 'Unit', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Unit', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'title_counter',
			[
				'label'       => esc_html__( 'Box title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Box title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Select type of icon', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'no'            => esc_html__( '-- No Icon --', 'course-builder' ),
					'font_awesome'  => esc_html__( 'Font Awesome', 'course-builder' ),
					'font_ionicons' => esc_html__( 'Ionicons', 'course-builder' ),
					'upload_icon'   => esc_html__( 'Upload', 'course-builder' ),
				],
				'default' => 'no',
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

		$repeater->add_control(
			'color_title',
			[
				'label'   => esc_html__( 'Title color', 'course-builder' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$repeater->add_control(
			'color_icon',
			[
				'label'   => esc_html__( 'Icon color', 'course-builder' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$repeater->add_control(
			'color_number',
			[
				'label'   => esc_html__( 'Quantity color', 'course-builder' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$repeater->add_control(
			'color_separator',
			[
				'label'   => esc_html__( 'Symbol separator color', 'course-builder' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'counter_box',
			[
				'label'       => esc_html__( 'Box Settings', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ currency_counter }}}',
				'separator'   => 'before',
				'condition'   => [
					'counter_style' => [ 'style-1', 'style-2' ]
				]
			]
		);

		$this->add_control(
			'icon_upload_center',
			[
				'label'     => esc_html__( 'Upload Icon Center', 'course-builder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'counter_style' => [ 'circle' ]
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


		//1
		$this->start_controls_section(
			'counter_box_settings_1',
			[
				'label' => esc_html__( 'Counter Box Settings Circle 1', 'course-builder' ),
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'number_counter_1',
			[
				'label'     => esc_html__( '* Quantity 1', 'course-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '1000',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'unit_1',
			[
				'label'       => esc_html__( 'Unit 1', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Unit 1', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'title_counter_1',
			[
				'label'       => esc_html__( 'Box title 1', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Box title 1', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_title_1',
			[
				'label'     => esc_html__( 'Title color 1', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_number_1',
			[
				'label'     => esc_html__( 'Quantity color 1', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->end_controls_section();

		//2
		$this->start_controls_section(
			'counter_box_settings_2',
			[
				'label' => esc_html__( 'Counter Box Settings Circle 2', 'course-builder' ),
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'number_counter_2',
			[
				'label'     => esc_html__( '* Quantity 2', 'course-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '1000',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'unit_2',
			[
				'label'       => esc_html__( 'Unit 2', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Unit 2', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'title_counter_2',
			[
				'label'       => esc_html__( 'Box title 2', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Box title 2', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_title_2',
			[
				'label'     => esc_html__( 'Title color 2', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_number_2',
			[
				'label'     => esc_html__( 'Quantity color 2', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->end_controls_section();

		//3
		$this->start_controls_section(
			'counter_box_settings_3',
			[
				'label' => esc_html__( 'Counter Box Settings Circle 3', 'course-builder' ),
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'number_counter_3',
			[
				'label'     => esc_html__( '* Quantity 3', 'course-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '1000',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'unit_3',
			[
				'label'       => esc_html__( 'Unit 3', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Unit 3', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'title_counter_3',
			[
				'label'       => esc_html__( 'Box title 3', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Box title 3', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_title_3',
			[
				'label'     => esc_html__( 'Title color 3', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_number_3',
			[
				'label'     => esc_html__( 'Quantity color 3', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->end_controls_section();

		//4
		$this->start_controls_section(
			'counter_box_settings_4',
			[
				'label' => esc_html__( 'Counter Box Settings Circle 4', 'course-builder' ),
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'number_counter_4',
			[
				'label'     => esc_html__( '* Quantity 4', 'course-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '1000',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'unit_4',
			[
				'label'       => esc_html__( 'Unit 4', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Unit 4', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'title_counter_4',
			[
				'label'       => esc_html__( 'Box title 4', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Box title 4', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_title_4',
			[
				'label'     => esc_html__( 'Title color 4', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->add_control(
			'color_number_4',
			[
				'label'     => esc_html__( 'Quantity color 4', 'course-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'counter_style' => [ 'circle' ]
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		thim_get_template(   'default', array( 'params' => $settings ), $this->get_base() . '/tpl/' );
//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Counter_Box_Element() );