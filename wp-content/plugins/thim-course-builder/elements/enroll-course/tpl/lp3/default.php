<?php
/**
 * Template for displaying Course button shortcode default style for Learnpress v3.
 *
 * @author  ThimPress
 * @package Course Builder/Templates
 */

/**
 * Prevent loading this file directly
 */
//defined( 'ABSPATH' ) || exit();

$course = LP_Course::get_course( intval( $params['id_course'] ) );
if ( ! $course ) {
	return;
}
$id   = $course->get_id();
$user = LP_Global::user();

LP_Global::set_course( $course );

$hide_text = '';
if ( $params['hide_text'] == 'yes' ) {
	$hide_text = 'hide_text';
}


?>

<div class="thim-sc-enroll-course  <?php echo esc_attr( $params['el_class'] . '' . $hide_text ); ?>">
	<?php if ( $params['hide_text'] != 'yes' ): ?>

        <h3 class="title-course">
            <a href="<?php the_permalink( $course->get_id() ); ?>">
				<?php echo esc_html( $course->get_title() ) . ' (' . $course->get_price_html() . ')'; ?>
            </a>
        </h3>

		<?php if ( get_the_excerpt( $course->get_id() ) ): ?>
            <div class="excerpt">
                <p><?php echo esc_html( get_the_excerpt( $course->get_id() ) ); ?></p>

            </div>
		<?php endif;
	endif; ?>


    <!-- LearnPress template single-course/buttons.php -->
    <div class="learn-press-course-buttons lp-course-buttons">
		<?php
		if ( $user ) {
			if ( ! $user->has_enrolled_course( $course->get_id() ) ) {

				if ( $course->is_free() ) {
					echo do_shortcode( '[learn_press_button_enroll id="' . $course->get_id() . '"]' );
				} else {
					echo do_shortcode( '[learn_press_button_purchase id="' . $course->get_id() . '"]' );
				}
			} else { ?>
                <button class="continue-button"><a
                            href="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>"><?php echo esc_html__( 'Continue Shopping', 'course-builder' ) ?></a>
                </button>
			<?php }
		}
		?>
    </div>
</div>