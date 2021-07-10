<?php
/**
 * Template for displaying categories of course in primary-meta section.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */


defined( 'ABSPATH' ) || exit();
?>

<?php $term_list = get_the_term_list( get_the_ID(), 'course_category', '', ', ', '' ); ?>

<?php if ( $term_list ) {
	printf( '<span class="cat-links">%s</span>', $term_list );
}
