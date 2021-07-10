<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Portfolio_Element extends Widget_Base {

	public function get_name() {
		return 'thim-portfolio';
	}

	public function get_title() {
		return esc_html__( 'Thim: Portfolio', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-portfolio';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'portfolio';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-portfolio-appear', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/jquery.appear.js', array( 'jquery' ),THIM_CB_VERSION, true );
		wp_enqueue_script( 'thim-portfolio-widget', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/portfolio.js', array(
			'jquery',
			'thim-portfolio-appear',
			'magnific-popup',
			'imagesloaded',
			'isotope',
			'masonry'
		),THIM_CB_VERSION, true );



		$this->start_controls_section(
			'portfolio_settings',
			[
				'label' => esc_html__( 'Portfolio Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'column',
			[
				'label'   => esc_html__( 'Columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'4' => esc_html__( '4', 'course-builder' ),
					'3' => esc_html__( '3', 'course-builder' ),
					'2' => esc_html__( '2', 'course-builder' ),
				],
				'default' => '4',
			]
		);

		$this->add_control(
			'gutter',
			[
				'label'   => esc_html__( 'Gutter', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_size',
			[
				'label'   => esc_html__( 'Select a item size', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'multigrid' => esc_html__( 'Multigrid', 'course-builder' ),
					'masonry'   => esc_html__( 'Masonry', 'course-builder' ),
					'same'      => esc_html__( 'Same size', 'course-builder' ),
				],
				'default' => 'same',
			]
		);

		$this->add_control(
			'paging',
			[
				'label'   => esc_html__( 'Select a paging', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'all'             => esc_html__( 'Show All', 'course-builder' ),
					'limit'           => esc_html__( 'Limit Items', 'course-builder' ),
					'paging'          => esc_html__( 'Paging', 'course-builder' ),
					'infinite_scroll' => esc_html__( 'Infinite Scroll', 'course-builder' ),
				],
				'default' => 'all',
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Portfolio_Element() );