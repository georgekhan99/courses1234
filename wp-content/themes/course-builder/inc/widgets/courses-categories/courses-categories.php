<?php

/**
 * Adds Thim_Recent_Courses_Widget widget.
 */
class Thim_Courses_Categories_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'thim-courses-categories',
			esc_html__( 'Thim: Courses Categories', 'course-builder' ),
			array( 'description' => esc_html__( 'Display category courses', 'course-builder' ), )
		);
	}

	public function widget( $args, $instance ) {
		$taxonomy = 'course_category';

		$args_cat = array(
			'taxonomy' => $taxonomy,
		);

		$cat_course = get_categories( $args_cat );


		echo( $args['before_widget'] );
		if ( ! empty( $instance['title'] ) ) {
			echo( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}
		$show_counts = isset( $instance['show_counts'] ) ? $instance['show_counts'] : false;

		if ( $cat_course ) :
			?>
			<ul class="courses-categories">
				<?php foreach ( $cat_course as $key => $value ) {?>

					<li class="cat-item <?php if ($value->category_parent > 0) echo 'sub-child' ?>">
						<a href="<?php echo esc_url( get_term_link( (int) $value->term_id, $taxonomy ) ); ?>"><?php echo esc_html( $value->name ); ?></a>
						<?php
						if ( $show_counts == true ) {
							echo '(' . $value->count . ')';
						}
						?>
					</li>

				<?php } ?>
			</ul>
			<?php
		endif;
		echo( $args['after_widget'] );
	}

	public function form( $instance ) {
		$title       = isset( $instance['title'] ) ? $instance['title'] : esc_attr__( 'Categories', 'course-builder' );
		$show_counts = isset( $instance['show_counts'] ) ? (bool) $instance['show_counts'] : false;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_counts ); ?> id="<?php echo( $this->get_field_id( 'show_counts' ) ); ?>" name="<?php echo( $this->get_field_name( 'show_counts' ) ); ?>" />
			<label for="<?php echo ($this->get_field_id( 'show_counts' )); ?>"><?php esc_html_e( 'Show post counts', 'course-builder' ); ?></label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['show_counts'] = isset( $new_instance['show_counts'] ) ? (bool) $new_instance['show_counts'] : false;

		return $instance;
	}

}

function register_thim_courses_categories_widget() {
	register_widget( 'Thim_Courses_Categories_Widget' );
}

add_action( 'widgets_init', 'register_thim_courses_categories_widget' );