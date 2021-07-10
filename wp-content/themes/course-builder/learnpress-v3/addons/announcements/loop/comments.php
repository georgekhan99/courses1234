<?php
/**
 * Template for displaying comment for announcement in announcements tab of single course page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/announcements/loop/comments.php.
 *
 * @author  ThimPress
 * @package LearnPress/Announcements/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
global $post;

$post = get_post( $announcement_id );
setup_postdata( $post );

/*if ( comments_open() || get_comments_number() ) {
	comments_template();
}*/
?>
	<div id="comments" class="comments-area">
		<div class="list-comments">
			<?php if ( get_comments_number() ) { ?>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
					<nav id="comment-nav-above" class="comment-navigation" role="navigation">
						<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'course-builder' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'course-builder' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'course-builder' ) ); ?></div>
					</nav><!-- #comment-nav-above -->
				<?php endif; // check for comment navigation  ?>

				<ul class="comment-list">
					<?php
					$comments = get_comments( 'post_id=' . $post->ID );
					wp_list_comments( 'type=comment&callback=thim_comment_single_course', $comments ); ?>
				</ul>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
					<nav id="comment-nav-below" class="comment-navigation" role="navigation">
						<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'course-builder' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'course-builder' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'course-builder' ) ); ?></div>
					</nav><!-- #comment-nav-below -->
				<?php endif; // check for comment navigation  ?>

			<?php } else {
				echo '<p class="no_comment">';
				echo esc_html__( 'No comments yet! You be the first to comment.', 'course-builder' );
				echo '</p>';
			} // have_comments() ?>
			<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'course-builder' ); ?></p>
			<?php endif; ?>
		</div>
		<div class="form-comment">
			<?php
			$current_user = wp_get_current_user();
			$user_id      = $current_user->ID;
			$avatar       = get_avatar( $user_id, 42 );

			comment_form( array(
				'comment_field' => '<p class="comment-form-comment"><span class="avatar-wrapper">'. ( $avatar ) . '</span><textarea placeholder="' . esc_attr__( 'Enter your comment', 'course-builder' ) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>'
			) );
			?>
			<?php do_action( 'comment_form_course' ) ?>
		</div>
	</div><!-- #comments -->
<?php
wp_reset_postdata();