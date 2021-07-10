<?php
/**
 * Template for displaying header of single course popup.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/header.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();

$user   = learn_press_get_current_user();
$course = LP_Global::course();

if ( ! $course || ! $user ) {
	return;
}

/**
 * Get cookie stored for sidebar state
 */
$show_sidebar = learn_press_cookie_get( 'sidebar-toggle' );
?>

<div id="popup-header">
	<div class="thim-course-item-popup-logo">
		<?php
		$thim_options         = get_theme_mods();
		$thim_lesson_logo_src = THIM_URI . "assets/images/logo-2.png";
		$logo_size = '';
		if ( isset( $thim_options['header_lesson_logo'] ) && $thim_options['header_lesson_logo'] <> '' ) {
			$thim_lesson_logo_src = get_theme_mod( 'header_lesson_logo' );
			if ( is_numeric( $thim_lesson_logo_src ) ) {
				$logo_attachment      = wp_get_attachment_image_src( $thim_lesson_logo_src, 'full' );
				$thim_lesson_logo_src = $logo_attachment[0];
				$logo_size = 'width="' . $logo_attachment[1] . '" height="' . $logo_attachment[2] . '"';
			}
		}
		?>

		<a class="lesson-logo" href="<?php echo esc_url(home_url('/'))  ?>" title="<?php echo esc_attr(get_bloginfo('name','display')) . ' - ' . esc_attr(get_bloginfo('description')); ?>" rel="home">
			<img class="logo" src="<?php echo esc_url($thim_lesson_logo_src)  ?>" alt="<?php /*echo esc_attr(get_bloginfo('name','display')) */ ?>" <?php echo ($logo_size);  ?>>
		</a>
	</div>
	<div class="thim-course-item-popup-right">
	<input type="checkbox" id="sidebar-toggle" class="toggle-content-item" <?php checked( $show_sidebar, true ); ?> />
		<a href="<?php echo $course->get_permalink(); ?>" class="back_course"><i class="fa fa-close"></i></a>
	</div>
    
</div>
