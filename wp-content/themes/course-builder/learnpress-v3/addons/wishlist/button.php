<?php
/**
 * Template for displaying button to toggle course wishlist on/off.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/wishlist/button.php.
 *
 * @author ThimPress
 * @package LearnPress/Wishlist/Templates
 * @version 3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( is_category() || is_archive() ) {
	$class = learn_press_user_wishlist_has_course($course_id) ? 'course-wishlisted' : 'course-wishlist';
	echo '<div class="course-wishlist-box">';
	printf(
		'<span class="fa fa-heart %s" data-id="%s" data-nonce="%s" title="%s"></span>',
		$class,
		$course_id,
		wp_create_nonce( 'course-toggle-wishlist' ),
		$title
	);
	echo '</div>';
} else {
	printf(
		'<button class="learn-press-course-wishlist learn-press-course-wishlist-button-%2$d wishlist-button %s" data-id="%s" data-nonce="%s" title="%s" data-text="%s">%s</button>',
		join( " ", $classes ),
		$course_id,
		wp_create_nonce( 'course-toggle-wishlist' ),
		$title,
		__( 'Processing...', 'course-builder' ),
		$state == 'on' ? __( 'Remove from Wishlist', 'course-builder' ) : __( 'Add to Wishlist', 'course-builder' )
	);
}