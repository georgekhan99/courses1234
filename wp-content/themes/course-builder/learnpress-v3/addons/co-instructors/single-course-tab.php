<?php
/**
 * Template for displaying instructor tab in single course page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/co-instructor/single-course-tab.php.
 *
 * @author  ThimPress
 * @package LearnPress/Co-Instructor/Templates
 * @version 3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( $instructors ) {
	foreach ( $instructors as $instructor_id ) {
		$instructor_profile_link = learn_press_user_profile_link( $instructor_id );

		$instructor = get_userdata( $instructor_id ); // WP_User|false

		if ( ! $instructor ) {
			return;
		}

		$instructor_meta = get_user_meta( $instructor_id );
		$instructor_meta = array_map( 'thim_get_user_meta', $instructor_meta );
		?>

		<div class="thim-course-co-instructor teacher">
			<div class="author-avatar">
				<?php echo get_avatar( $instructor_id, 150 ); ?>

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
						if ( ! empty( $instructor_meta[ $social ] ) ) {
							echo '<li><a href="' . esc_url( $instructor_meta[ $social ] ) . '"></a></li>';
						}
					}
					?>
				</ul>
			</div>

			<div class="author-bio">
				<div class="name">
					<?php echo '<a href="' . esc_url( $instructor_profile_link ) . '">' . esc_html( $instructor->display_name ) . '</a>'; ?>
				</div>

				<?php if ( ! empty( $instructor_meta['lp_info_major'] ) ): ?>
					<div class="major"><?php echo esc_html( $instructor_meta['lp_info_major'] ) ?></div>
				<?php endif; ?>

				<?php if ( ! empty( $instructor_meta['description'] ) ): ?>
					<p class="description"><?php echo( $instructor_meta['description'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<?php
	}
}
