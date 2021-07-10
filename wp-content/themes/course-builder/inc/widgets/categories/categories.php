<?php

/**
 * Adds Thim_Categories_Widget widget.
 */
class Thim_Categories_Widget extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since  2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'thim_widget_categories',
			'description'                 => esc_html__( 'Display categories.', 'course-builder' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'thim_categories', esc_html__( 'Thim: Categories', 'course-builder' ), $widget_ops );
		$this->alt_option_name = 'thim_widget_categories';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since  2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Categories', 'course-builder' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo( $args['before_widget'] );

		echo( $args['before_title'] . $title . $args['after_title'] );
		/**
		 * Filters the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see   WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */

		?>
			<ul>
				<?php
				$args_cat = array('pad_counts' => true, 'hide_empty' => true, );
				$cats = get_terms('category', $args_cat);
				$i = 0;
				?>
				<?php foreach( $cats as $category ) : $i++; ?>
                <li>
	                <?php echo $i.'.';?> <a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo $category->name; ?></a>
                </li>
				<?php endforeach; ?>
			</ul>
		<?php
		echo( $args['after_widget'] );
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since  2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since  2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'course-builder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php
	}
}


function register_thim_categories_widget() {
	register_widget( 'Thim_Categories_Widget' );

}

add_action( 'widgets_init', 'register_thim_categories_widget' );