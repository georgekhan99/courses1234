<?php
/**
 * Template for displaying curriculum tab of single course.
 *
 * @author  ThimPress
 * @package CourseBuilder/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();
$user   = LP_Global::user();
if ( ! $course || ! $user ) {
	return;
}

$curriculum_heading = apply_filters( 'learn_press_curriculum_heading', esc_html__( 'Course Content', 'course-builder' ) );
?>
<?php if ( ! learn_press_is_learning_course() ): ?>
	<div id="tab-curriculum" style="height: 68px;"></div>
<?php endif; ?>

<?php do_action( 'thim_begin_curriculum_button' ); ?>

<div class="course-curriculum" id="learn-press-course-curriculum">
	<div class="curriculum-heading">
		<?php if ( $curriculum_heading ) { ?>
			<div class="title">
				<h2 class="course-curriculum-title"><?php echo( $curriculum_heading ); ?></h2>
			</div>
		<?php } ?>

		<div class="search">
			<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
				<input type="text" class="search-field"
				       placeholder="<?php echo esc_attr__( 'Search...', 'course-builder' ) ?>"
				       value="<?php echo get_search_query() ?>" name="s" />
				<input type="hidden" name="post_type" value="lp_lession">
				<button type="submit" class="search-submit"><span class="ion-android-search"></span></button>
			</form>
		</div>

		<!-- Display total learning in landing course page -->
		<?php
		$total_lessson = $course->count_items( 'lp_lesson' );
		$total_quiz    = $course->count_items( 'lp_quiz' );

		if ( $total_lessson || $total_quiz ) {
			echo '<span class="total-lessons">' . esc_html__( 'Total learning: ', 'course-builder' );
			if ( $total_lessson ) {
				echo '<span class="text">' . sprintf( _n( '%d lesson', '%d lessons', $total_lessson, 'course-builder' ), $total_lessson ) . '</span>';
			}

			if ( $total_quiz ) {
				echo '<span class="text">' . sprintf( _n( ' / %d quiz', ' / %d quizzes', $total_quiz, 'course-builder' ), $total_quiz ) . '</span>';
			}
			echo '</span>';
		}
		?>
		<!-- End -->

		<!-- Display total course time in landing course page -->
		<?php
		$course_duration_text = thim_duration_time_calculator( $course->get_id(), 'lp_course' );
		$course_duration_meta = get_post_meta( $course->get_id(), '_lp_duration', true );
		$course_duration      = explode( ' ', $course_duration_meta );

		if ( ! empty( $course_duration[0] ) && $course_duration[0] != '0' ) {
			?>
			<span class="total-time"><?php esc_html_e( 'Time: ', 'course-builder' ); ?>
				<span class="text"><?php echo( $course_duration_text ); ?></span></span>
			<?php
		}
		?>
		<!-- End -->
	</div>

	<!-- Display Breadcrumb in sidebar course item popup -->
	<?php
	$args = wp_parse_args( $args, apply_filters( 'learn_press_breadcrumb_defaults', array(
		'delimiter'   => ' <span class="delimiter">/</span> ',
		'wrap_before' => '<nav class="thim-font-heading learn-press-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
	) ) );

	learn_press_breadcrumb( $args );
	?>
	<!-- End -->

	<!-- Display course progress in course item popup -->
	<?php learn_press_course_progress(); ?>
	<!-- End -->

	<?php
	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/before-single-course-curriculum' ); ?>

	<?php if ( $curriculum = $course->get_curriculum() ) { ?>
		<ul class="curriculum-sections">
			<?php
			$position = 0;
            foreach ( $curriculum as $section ) {
	            $section->position = ++ $position;
				learn_press_get_template( 'single-course/loop-section.php', array( 'section' => $section ) );
			} ?>
		</ul>
	<?php } else { ?>
        <p class="curriculum-empty"><?php echo apply_filters( 'learn_press_course_curriculum_empty', esc_attr__( 'Curriculum is empty', 'course-builder' ) ); ?></p>
	<?php } ?>

	<?php
	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/after-single-course-curriculum' ); ?>

	<?php if ( learn_press_is_learning_course() ) {
		do_action( 'thim_learning_end_tab_curriculum' );
	} ?>
</div>

