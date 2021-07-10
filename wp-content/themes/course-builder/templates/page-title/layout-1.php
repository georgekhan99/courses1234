<?php
/**
 * Template for displaying page title layout 1.
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
$courses_layout = '';

$top_widgetarea = isset( $_GET['top_widgetarea'] ) ? $_GET['top_widgetarea'] : get_theme_mod( 'learnpress_top_sidebar_archive_display', true );
if ( ( $top_widgetarea === '1' || $top_widgetarea === 'true' ) && ! is_single() ) {
	if ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
		$courses_layout = 'breadcrumb-plus';
	}
}

// Display page title for single forum and single topic
if ( class_exists( 'bbPress' ) ) {
	if ( function_exists( 'bbp_is_single_forum' ) && bbp_is_single_forum() ) {
		$title = '<h1>' . esc_html_x( 'Forum', 'Page title', 'course-builder' ) . '</h1>';
	}

	if ( function_exists( 'bbp_is_single_topic' ) && bbp_is_single_topic() ) {
		$title = '<h1>' . esc_html_x( 'Topic', 'Page title', 'course-builder' ) . '</h1>';
	}
}

if ( get_theme_mod( 'page_title_parallax', true ) ) {
	$parallax = 'parallax';
} else {
	$parallax = 'no-parallax';
}

?>

<?php if ( $show_text ) { ?>
	<div class="main-top <?php echo ent2ncr( $parallax ); ?>" <?php echo ent2ncr( $main_css ); ?>>
		<span class="overlay-top-header" <?php echo ent2ncr( $overlay_css ); ?>></span>
		<div class="content container">
			<div class="row">

				<?php if ( $show_title ) { ?>
					<div class="text-title col-md-6">
						<?php echo ent2ncr( $title ); ?>
					</div>
				<?php } ?>

				<?php if ( $show_sub_title ) { ?>
					<div class="text-description col-md-6">
						<?php echo ent2ncr( $description ); ?>
					</div>
				<?php } ?>

			</div>
		</div>
	</div><!-- .main-top -->

	<?php if ( $show_breadcrumb ) { ?>
		<?php if ( ! is_front_page() || ! is_home() ) { ?>
			<div class="breadcrumb-content <?php echo esc_attr( $courses_layout ); ?>">
				<div class="breadcrumbs-wrapper container">
					<?php
					if ( is_singular( 'lp_course' ) ) {

						$layout = isset( $_GET['layout'] ) ? $_GET['layout'] : get_theme_mod( 'learnpress_single_course_style', 1 );
						if ( $layout == 1 && get_post_meta( get_the_ID(), '_lp_coming_soon', true ) != 'yes' ) {
							learn_press_get_template( 'single-course/buttons.php' );
						}
					} else {
						if ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || get_post_type() == 'lp_collection' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
							thim_learnpress_breadcrumb();
						} elseif ( get_post_type() == 'product' ) {
							woocommerce_breadcrumb();
						} elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
							thim_bbpress_breadcrumb();
						} else {
							thim_breadcrumbs();
						}
					} ?>
				</div><!-- .breadcrumbs-wrapper -->
			</div><!-- .breadcrumb-content -->
		<?php } ?>
	<?php } ?>
<?php } ?>