<?php
/**
 * Template for displaying content of Popular Courses widget
 *
 * @author  ThimPress
 * @package LearnPress/Templates/Widgets
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;
$instance       = $this->instance;
$lp_thumbnail   = get_option( 'learn_press_course_thumbnail_image_size' );
$thumbnail_size = $lp_thumbnail['width'] . 'x' . $lp_thumbnail['height'];
?>
<div class="<?php echo 'archive-course-widget-outer ' . esc_attr( $instance["css_class"] ); ?>">
	<div class="widget-body row">
		<?php foreach ( $this->courses as $course ): ?>
			<div class="course-entry col-md-4">
				<div class="course-inner">
					<?php if ( ! empty( $instance['show_thumbnail'] ) ): ?>
						<div class="course-cover">
							<a href="<?php echo get_the_permalink( $course->get_id() ); ?>">
								<?php thim_thumbnail( $course->get_id(), $thumbnail_size ); ?>
							</a>
							<?php if ( ! empty( $instance['show_price'] ) ): ?>
								<?php $free = $course->is_free() ? 'free' : ''; ?>
								<span class="price <?php echo esc_attr( $free ); ?>">
							<?php echo( $course->get_price_html() ); ?>
							</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="course-detail">
						<div class="course-detail-inner">
							<a href="<?php echo get_the_permalink( $course->get_id() ) ?>">
								<h4 class="course-title">
									<?php echo( $course->get_course_data()->post_title ); ?>
								</h4>
							</a>
							<?php if ( ! empty( $instance['show_teacher'] ) ): ?>
								<span class="author">
									<?php echo( $course->get_instructor_html() ); ?>
							</span>
							<?php endif; ?>
							<?php if ( ! empty( $instance['desc_length'] ) && intval( $instance['desc_length'] ) > 0 ): ?>
								<div class="course-description"><?php
									$content_length = intval( $instance['desc_length'] );
									$the_content    = $course->get_content();
									$the_content    = wp_trim_words( $the_content, $content_length, esc_attr__( '...', 'course-builder' ) );
									echo( $the_content );
									?></div>
							<?php endif; ?>
						</div>
						<div class="course-meta-data">

							<?php if ( ! empty( $instance['show_enrolled_students'] ) ): ?>
								<div class="course-student-number course-meta-field">
									<i class="icon-people icons"></i>
									<?php
									$students = $course->get_users_enrolled();
									echo intval( $students ) > 1 ? sprintf( __( '%d', 'course-builder' ), $students ) : sprintf( __( '%d', 'course-builder' ), $students );
									?>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $instance['show_lesson'] ) ): ?>
								<div class="course-lesson-number course-meta-field">
									<i class="icon-layers icons"></i>
									<?php
									$lessons = sizeof( $course->get_lessons() );
									printf( _n( '%d <span class="text">lesson</span>', '%d <span class="text">lessons</span>', $lessons, 'course-builder'), $lessons );
									?>
								</div>
							<?php endif; ?>
							<div class="social-share">
								<i class="icon-share icons"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="widget-footer">
		<?php if ( ! empty( $instance['bottom_link_text'] ) ):
			$page_id = get_option( 'learn_press_courses_page_id' );
			$link = get_the_permalink( $page_id );
			$title = get_the_title( $page_id );
			?>
			<a class="btn btn-default btn-secondary archive-link" href="<?php echo esc_attr( $link ) ?>">
				<?php echo wp_kses_post( $instance['bottom_link_text'] ); ?>
			</a>
		<?php endif; ?>
	</div>
</div>
<div class="clearfix"></div>