<?php
/**
 * Collections widget class.
 *
 * @author   ThimPress
 * @package  LearnPress/Collections/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Collections_Widget' ) ) {
	/**
	 * Adds LP_Collections_Widget widget.
	 */
	class LP_Collections_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'collection_widget',
				__( 'Courses Collections', 'learnpress-collections' ),
				array( 'description' => __( 'Display course collections', 'learnpress-collections' ) )
			);
		}

		/**
		 * Front-end display
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}
			// Query collections
			$query_args = array(
				'post_type'      => 'lp_collection',
				'post_status'    => 'publish',
				'posts_per_page' => ( ! empty ( $instance['number'] ) ? $instance['number'] : - 1 )
			);
			// The Query
			$the_query = new WP_Query( $query_args );

			// The Loop
			if ( $the_query->have_posts() ) {
				echo '<ul class="learn-press-collection-widget">';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
				}
				echo '</ul>';
			}
			/* Restore original Post Data */
			wp_reset_postdata();
			echo $args['after_widget'];
		}

		/**
         * Form.
         *
		 * @param array $instance
		 *
		 * @return string|void
		 */
		public function form( $instance ) {
			$title  = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Collections', 'learnpress-collections' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '5';
			?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'learnpress-collections' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of collections to show:', 'learnpress-collections' ); ?></label>
                <input type="text" size="3" value="<?php echo esc_attr( $number ); ?>"
                       id="<?php echo $this->get_field_id( 'number' ); ?>"
                       name="<?php echo $this->get_field_name( 'number' ); ?>">
            </p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance
		 * @param array $old_instance
		 *
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance           = array();
			$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';

			return $instance;
		}

	}
}