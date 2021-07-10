<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;
$user_identity = $current_user->exists() ? $current_user->display_name : '';

?>
<?php if ( ( get_post_type() == 'post' && get_theme_mod( 'blog_single_comment', true ) ) ||
    ( is_user_logged_in() && get_theme_mod( 'thim_learnpress_lesson_comment', true ) && ( get_query_var( 'post_type' ) == 'lp_course' ) ) || ( get_post_type() == 'lp_announcements' ) ): ?>
	<div id="comments" class="comments-area">
		<div class="list-comments">

			<?php
			if ( have_comments() ) {
				?>
				<h3 class="comments-title">
					<?php echo esc_html__( 'Comments', 'course-builder' ); ?>
				</h3>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
					<nav id="comment-nav-above" class="comment-navigation" role="navigation">
						<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'course-builder' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'course-builder' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'course-builder' ) ); ?></div>
					</nav><!-- #comment-nav-above -->
				<?php endif; // check for comment navigation  ?>

				<ul class="comment-list">
					<?php wp_list_comments( 'type=all&callback=thim_comment' ); ?>
				</ul>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
					<nav id="comment-nav-below" class="comment-navigation" role="navigation">
						<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'course-builder' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'course-builder' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'course-builder' ) ); ?></div>
					</nav><!-- #comment-nav-below -->
				<?php endif; // check for comment navigation  ?>
				<?php
			}
			?>

			<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'course-builder' ); ?></p>
			<?php endif; ?>

		</div>
		<div class="form-comment">
			<?php
			comment_form( array(
				'comment_field' => '<p class="comment-form-comment"><textarea placeholder="' . esc_attr__( 'Enter your comment', 'course-builder' ) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
				'logged_in_as'  => '<p class="logged-in-as">' . sprintf(
					/* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
						__( 'Logged in as <a href="%1$s" aria-label="%2$s">%3$s</a>. <a href="%4$s">Log out?</a>', 'course-builder' ),
						get_edit_user_link(),
						/* translators: %s: user name */
						esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'course-builder' ), $user_identity ) ),
						$user_identity,
						wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ), get_the_ID() ) )
					) . '</p>',
			) );
			?>
		</div>
	</div><!-- #comments -->
<?php endif; ?>
