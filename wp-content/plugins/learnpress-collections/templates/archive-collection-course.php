<?php
/**
 * Template for displaying archive collection course content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/collection/archive-collection-course.php.
 *
 * @author  ThimPress
 * @package LearnPress/Collections/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<div class="learn-press-collections lp-archive-courses" id="learn-press-collection-<?php echo $id; ?>">
	<?php
	if ( $query->have_posts() ) {
		learn_press_begin_courses_loop();
		while ( $query->have_posts() ) :
			$post = $query->the_post();

			LP_Addon_Collections::$in_loop = true;
			learn_press_collections_get_template( 'content-collection-course.php' );

		endwhile;

		learn_press_end_courses_loop();
		LP_Addon_Collections::$in_loop = false;

		learn_press_paging_nav(
			array(
				'num_pages'     => $query->max_num_pages,
				'wrapper_class' => 'learn-press-pagination',
				'paged'         => get_query_var( 'collection_page' ),
			)
		);
	} else {
		learn_press_display_message( __( 'No course found!', 'learnpress-collections' ) );
	}
	?>

</div>
