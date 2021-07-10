<?php
/**
 * Template for displaying layout 2 content of landing course.
 *
 * @author  ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<div class="landing-2">

	<div class="main-course">

		<?php learn_press_get_template( 'single-course/thumbnail.php' ); ?>

		<?php learn_press_get_template( 'single-course/course-info.php' ); ?>

		<div class="course-landing-summary">

			<div class="content-landing-2">
				<?php do_action( 'learn-press/content-landing-summary' ); ?>
			</div>

		</div>

	</div>

	<div class="wrapper-info-bar sticky-sidebar">
		<?php learn_press_get_template( 'single-course/infobar.php' ); ?>
	</div>

</div>
