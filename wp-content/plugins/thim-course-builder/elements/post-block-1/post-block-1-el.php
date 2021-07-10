<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Post_Block_1_Element extends Widget_Base {

	public function get_name() {
		return 'thim-post-block-1';
	}

	public function get_title() {
		return esc_html__( 'Thim: Post Block 1', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-post-block-1';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'post-block-1';
	}



	protected function _register_controls() {

		$this->start_controls_section(
			'post_block_settings',
			[
				'label' => esc_html__( 'Post Block 1 Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'list_post',
			[
				'label'   => esc_html__( 'Show posts by', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'post_date'     => esc_html__( 'Latest', 'course-builder' ),
					'comment_count' => esc_html__( 'Popular', 'course-builder' ),
				],
				'default' => 'post_date',
			]
		);

		$this->add_control(
			'cat_post',
			[
				'label'    => esc_html__( 'Select Category', 'course-builder' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => false,
				'options'   => thim_get_cat_courses( 'category', esc_html__('All','course-builder'), true ),
				'default'  => 'all',
			]
		);

		$this->add_control(
			'post_columns',
			[
				'label'   => esc_html__( 'Number of columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'4' => esc_html__( '4', 'course-builder' ),
					'3' => esc_html__( '3', 'course-builder' ),
					'2' => esc_html__( '2', 'course-builder' ),
					'1' => esc_html__( '1', 'course-builder' ),
				],
				'default' => '2',
			]
		);

		$this->add_control(
			'post_number',
			[
				'label'   => esc_html__( 'Number of posts', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '2',
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

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Post_Block_1_Element() );