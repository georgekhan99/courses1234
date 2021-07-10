<?php
/**
 * Template for displaying the instructor of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP_Global::course();
$author = $course->get_instructor();

$author_meta = get_user_meta( $author->get_id() );
$author_meta = array_map( 'thim_get_user_meta', $author_meta );
?>
<?php if ( ! learn_press_is_learning_course() ): ?>
	<div id="tab-instructor" style="height: 40px"></div>
<?php endif; ?>

<div class="course-author">

	<h3><?php esc_html_e( 'Instructor', 'course-builder' ); ?></h3>

	<?php do_action( 'learn-press/before-single-course-instructor' ); ?>

	<div class="thim-course-author teacher">
		<div class="author-avatar">
			<?php echo get_avatar( $author->get_id(), 150 ); ?>

			<ul class="social-link">
				<?php
				$social_display = apply_filters( 'thim_user_social_profile_display', array(
					'lp_info_facebook',
					'lp_info_twitter',
					'lp_info_skype',
					'lp_info_pinterest',
					'lp_info_google_plus',
					'lp_info_linkedin',
					'lp_info_instagram'
				) );

				foreach ( $social_display as $social ) {
					if ( ! empty( $author_meta[ $social ] ) ) {
						echo '<li><a class="'. $social .'" href="' .  esc_url($author_meta[ $social ]) . '"></a></li>';
					}
				}
				?>
			</ul>
		</div>

		<div class="author-bio">
			<div class="name">
				<?php echo $course->get_instructor_html(); ?>
			</div>

			<?php if ( ! empty( $author_meta['lp_info_major'] ) ): ?>
				<div class="major"><?php echo esc_html( $author_meta['lp_info_major'] ) ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $author_meta['description'] ) ): ?>
				<p class="description"><?php echo( $author_meta['description'] ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'learn-press/after-single-course-instructor' ); ?>

</div>

