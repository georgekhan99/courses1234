<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Video_Box_Element extends Widget_Base {

	public function get_name() {
		return 'thim-video-box';
	}

	public function get_title() {
		return esc_html__( 'Thim: Video Box', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-video-box';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'video-box';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-sc-video-box', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/video-box-custom.js', array( 'jquery', 'magnific-popup' ),THIM_CB_VERSION, true );
  		wp_enqueue_script( 'thim-sc-video-box' );

		$this->start_controls_section(
			'video_box_settings',
			[
				'label' => esc_html__( 'Video Box Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'layout-1' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout1.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-2' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout2.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-3' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout3.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
				],
				'default' => 'layout-1',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'upload_image',
			[
				'label'   => esc_html__( 'Choose video thumbnail image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->add_control(
			'bg_image',
			[
				'label'     => esc_html__( 'Choose background image', 'course-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Macbook', 'course-builder' ),
					'imac' => esc_html__( 'iMac', 'course-builder' ),
				],
				'default'   => '',
				'condition' => [
					'layout' => [ 'layout-2' ]
				]
			]
		);

		$this->add_control(
			'link_video',
			[
				'label'       => esc_html__( 'Video Link', 'course-builder' ),
				'description' => 'Support Youtube and Vimeo format. Add ?rel=0&showinfo=0 to the video URL to turn off related videos',
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Video Link', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Video content', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Video content', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'layout' => [ 'layout-1' ]
				]
			]
		);

		$this->add_control(
			'share_link',
			[
				'label'   => esc_html__( 'Show button to share video?', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition'   => [
					'layout' => [ 'layout-1' ]
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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Video_Box_Element() );