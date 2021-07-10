<?php
/**
 * Template for displaying page title layout 3.
 *
 * @author  ThimPress
 * @package CourseBuilder/Templates
 * @version 1.1
 */

// page title settings
$page_title = thim_page_title();

/**
 * Extract $page_title to parameters
 *
 * @var $show_title
 * @var $show_sub_title
 * @var $show_text
 * @var $title
 * @var $description
 * @var $main_css
 * @var $overlay_css
 * @var $show_breadcrumb
 */
extract( $page_title );

// Display page title for single forum and single topic
if ( class_exists( 'bbPress' ) ) {
	if ( function_exists( 'bbp_is_single_forum' ) && bbp_is_single_forum() ) {
		$title = '<h1>' . esc_html_x( 'Forum', 'Page title', 'course-builder' ) . '</h1>';
	}

	if ( function_exists( 'bbp_is_single_topic' ) && bbp_is_single_topic() ) {
		$title = '<h1>' . esc_html_x( 'Topic', 'Page title', 'course-builder' ) . '</h1>';
	}
} ?>

<?php if ( $show_breadcrumb ) { ?>
	<?php if ( ! is_front_page() || ! is_home() ) { ?>
		<div class="breadcrumb-content">
			<div class="breadcrumbs-wrapper container">
				<?php
				if ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
					thim_learnpress_breadcrumb();
				} elseif ( get_post_type() == 'product' ) {
					woocommerce_breadcrumb();
				} elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
					thim_bbpress_breadcrumb();
				} else {
					thim_breadcrumbs();
				} ?>
			</div><!-- .breadcrumbs-wrapper -->
		</div><!-- .breadcrumb-content -->
	<?php } ?>
<?php } ?>

<?php
    if ( get_theme_mod( 'page_title_parallax', true ) ) {
        $parallax = 'parallax';
    } else {
        $parallax = 'no-parallax';
    }
?>

<?php if ( $show_text ) { ?>
	<div class="main-top" <?php echo ent2ncr( $main_css ); ?>>
		<span class="overlay-top-header" <?php echo ent2ncr( $overlay_css ); ?>></span>
		<div class="content container">
			<?php if ( $show_title ) { ?>
				<div class="text-title">
					<?php echo ent2ncr( $title ); ?>
				</div>
			<?php } ?>
			<?php if ( $show_sub_title ) { ?>
				<div class="text-description">
					<?php echo ent2ncr( $description ); ?>
				</div>
			<?php } ?>
			<?php
			if ( is_singular( 'lp_course' ) ) {
				$layout = isset( $_GET['layout'] ) ? $_GET['layout'] : get_theme_mod( 'learnpress_single_course_style', 1 );
				if ( $layout == 1 && get_post_meta( get_the_ID(), '_lp_coming_soon', true ) != 'yes' ) {
					learn_press_get_template( 'single-course/buttons.php' );
				}
			} ?>
		</div>
	</div><!-- .main-top -->
<?php } ?>
