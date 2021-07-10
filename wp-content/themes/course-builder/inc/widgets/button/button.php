<?php

/**
 * Adds Thim_Button_Widget widget.
 */
class Thim_Button_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'thim-button',
			esc_html__( 'Thim: Button', 'course-builder' ),
			array( 'description' => esc_html__( 'Display button', 'course-builder' ), )
		);
	}

	public function widget( $args, $instance ) {

		echo( $args['before_widget'] );
		?>
		<div class="thim-button-gradient">
			<a class="button-gradient" href="<?php echo $instance['link']; ?>"><?php echo $instance['text']; ?></a>
		</div>
		<?php
		echo( $args['after_widget'] );
	}

	public function form( $instance ) {
		$text = isset( $instance['text'] ) ? $instance['text'] : esc_attr__( 'Create a course', 'course-builder' );
		$link = isset( $instance['link'] ) ? $instance['link'] : '';
		?>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_attr_e( 'Text Button:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $text ); ?>">
		</p>

		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_attr_e( 'Link Button:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['text'] = ( !empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		$instance['link'] = ( !empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

}

function register_thim_button_widget() {
	register_widget( 'Thim_Button_Widget' );
}

add_action( 'widgets_init', 'register_thim_button_widget' );