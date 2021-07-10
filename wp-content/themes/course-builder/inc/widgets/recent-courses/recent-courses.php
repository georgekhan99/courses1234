<?php

/**
 * Adds Thim_Recent_Courses_Widget widget.
 */
class Thim_Recent_Courses_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'thim-recent-courses',
			esc_html__( 'Thim: Recent Courses', 'course-builder' ),
			array( 'description' => esc_html__( 'Display recent courses', 'course-builder' ), )
		);
	}

	public function widget( $args, $instance ) {
		$number_courses = $instance['number_courses'];

		$args_list_courses = array(
			'posts_per_page' => $number_courses,
			'post_type'      => 'lp_course',
			'post_status'    => 'publish',
			'orderby'        => 'date',
		);

		$query_list_courses = new WP_Query( $args_list_courses );


		echo( $args['before_widget'] );
		if ( ! empty( $instance['title'] ) ) {
			echo( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		if ( $query_list_courses->have_posts() ) :
			?>
            <div class="thim-recent-courses-widget">
                <ul class="recent-courses-wrapper">
					<?php while ( $query_list_courses->have_posts() ): $query_list_courses->the_post();

						?>

                        <li class="course-item">
                            <div class="feature-img">
								<?php thim_thumbnail( get_the_ID(), '109x109' ) ?>
                            </div>
                            <div class="content">
                                <h4 class="title">
                                    <a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ) ?>"><?php echo esc_html( get_the_title() ) ?></a>
                                </h4>
                                <div class="price"><?php
									if ( ! is_search() ) {
										learn_press_course_price();
									}
									?></div>
                            </div>
                        </li>

					<?php endwhile;
					wp_reset_postdata();
					?>
                </ul>
            </div>
		<?php
		endif;
		echo( $args['after_widget'] );
	}

	public function form( $instance ) {
		$title          = isset( $instance['title'] ) ? $instance['title'] : esc_attr__( 'Latest Courses', 'course-builder' );
		$number_courses = isset( $instance['number_courses'] ) ? $instance['number_courses'] : 3;
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'course-builder' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number_courses' ) ); ?>"><?php esc_attr_e( 'Number courses visible:', 'course-builder' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_courses' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'number_courses' ) ); ?>" type="number"
                   value="<?php echo esc_attr( $number_courses ); ?>">
        </p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number_courses'] = ( ! empty( $new_instance['number_courses'] ) ) ? $new_instance['number_courses'] : 3;

		return $instance;
	}

}

function register_thim_recent_courses_widget() {
	register_widget( 'Thim_Recent_Courses_Widget' );
}

add_action( 'widgets_init', 'register_thim_recent_courses_widget' );