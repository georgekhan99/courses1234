<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Event_Element extends Widget_Base {

	public function get_name() {
		return 'thim-event';
	}

	public function get_title() {
		return esc_html__( 'Thim: Events', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-events';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'events';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-events', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/events-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );

 		wp_enqueue_script( 'thim-events' );

		$this->start_controls_section(
			'event_settings',
			[
				'label' => esc_html__( 'Event Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'cat_events',
			[
				'label'    => esc_html__( 'Select Category', 'course-builder' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => false,
				'options'  => thim_get_cat_courses( 'tp_event_category', esc_html__( 'All', 'course-builder' ), true ),
				'default'  => '0',
			]
		);

		$this->add_control(
			'status_events',
			[
				'label'   => esc_html__( 'Show event by', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'all'         => esc_html__( 'All', 'course-builder' ),
					'not-expired' => esc_html__( 'All (NOT expired)', 'course-builder' ),
					'upcoming'    => esc_html__( 'Upcoming', 'course-builder' ),
					'happening'   => esc_html__( 'Happening', 'course-builder' ),
					'expired'     => esc_html__( 'Expired', 'course-builder' ),
				],
				'default' => 'all',
			]
		);

		$this->add_control(
			'number_events',
			[
				'label'   => esc_html__( 'Number of events', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '1',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'popular' => esc_html__( 'Popular', 'course-builder' ),
					'recent'  => esc_html__( 'Recent', 'course-builder' ),
					'title'   => esc_html__( 'Title', 'course-builder' ),
					'random'  => esc_html__( 'Random', 'course-builder' ),
					'time'    => esc_html__( 'Time', 'course-builder' ),
				],
				'default' => 'popular',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'ASC', 'course-builder' ),
					'desc' => esc_html__( 'DESC', 'course-builder' ),
				],
				'default' => 'desc',
			]
		);

		$this->add_control(
			'layer_events',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'event-1' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/event-1.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'event-2' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/event-2.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'event-3' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/event-3.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'event-4' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/event-4.png' . '">',
						'icon'  => 'bp_el_class'
					],
				],
				'default' => 'event-1',
				'toggle'  => false,
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
		if ( ! isset( $settings['layer_events'] ) ) {
			$settings['layer_events'] = 'event-1';
		}


		thim_get_template( $settings['layer_events'], array( 'params' => $settings ), $this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ), $settings['layer_events'] );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Event_Element() );