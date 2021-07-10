<?php
/**
 * Template for displaying header of single course popup.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/header.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();
?>
<div id="course-item-content-header" class="thim-course-item-header">
<!--	<div class="icon-toggle-curriculum open" onclick="toggle_curiculum_sidebar();"></div>-->

	<div class="course-item-search">
		<form>
			<input type="text" placeholder="<?php esc_attr_e( 'Search item', 'course-builder' ); ?>" />
			<button type="button"></button>
		</form>
	</div>

	<div class="thim-course-item-popup-logo">
		<?php
		$thim_options         = get_theme_mods();
		$thim_lesson_logo_src = THIM_URI . "assets/images/logo-2.png";

		if ( isset( $thim_options['header_lesson_logo'] ) && $thim_options['header_lesson_logo'] <> '' ) {
			$thim_lesson_logo_src = get_theme_mod( 'header_lesson_logo' );
			if ( is_numeric( $thim_lesson_logo_src ) ) {
				$logo_attachment      = wp_get_attachment_image_src( $thim_lesson_logo_src, 'full' );
				$thim_lesson_logo_src = $logo_attachment[0];
			}
		}

		$thim_logo_size = @getimagesize( $thim_lesson_logo_src );
		$logo_size      = $thim_logo_size[3];
		?>

		<a class="lesson-logo" href="<?php echo esc_url(home_url('/'))  ?>" title="<?php echo esc_attr(get_bloginfo('name','display')) . ' - ' . esc_attr(get_bloginfo('description')); ?>" rel="home">
			<img class="logo" src="<?php echo esc_url($thim_lesson_logo_src)  ?>" alt="<?php /*echo esc_attr(get_bloginfo('name','display')) */ ?>" <?php echo ($logo_size);  ?>>
		</a>
	</div>

    <a href="<?php echo $course->get_permalink(); ?>" class="back_course"><i class="fa fa-close"></i></a>

	<a class="toggle-content-item" href=""></a>

</div>
