<?php
/**
 * Template for displaying loop item in announcements tab of single course page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/announcements/loop/item.php.
 *
 * @author  ThimPress
 * @package LearnPress/Announcements/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php
$announcement_id = $announcement->ID;
$author_id       = $announcement->post_author;

$title   = ! empty( $announcement->post_title ) ? $announcement->post_title : esc_html__( 'No Title', 'course-builder' );
$content = ! empty( $announcement->post_content ) ? $announcement->post_content : esc_html__( 'No Content', 'course-builder' );

$lp_profile_url = learn_press_user_profile_link( $author_id );
?>

<div id="lp-announcement-<?php echo esc_attr( $announcement_id ); ?>" class="lp-announcement-item">
	<div class="author">
		<a href="<?php echo esc_url( $lp_profile_url ); ?>" class="img-avatar">
			<?php echo get_avatar( $author_id, 58 ); ?>
		</a>

		<div class="info">
			<span class="name">
				<a href="<?php echo esc_url( $lp_profile_url ); ?>">
					<?php echo get_the_author(); ?>
				</a>
			</span>

			<span class="time">
			<?php echo esc_html__( 'Posted an announcement - ', 'course-builder' ) . get_the_date( get_option( 'date_format' ), $announcement_id ); ?>
				<span class="ion-flag"></span>
			</span>
		</div>
	</div>

	<h4 id="announcement_item_<?php echo $announcement_id; ?>" class="thim-title">
		<?php echo wp_kses_post( $title ); ?>
	</h4>

	<div class="lp-announcement-content">
		<div class="lp-announcement-wrap-content">
			<?php
			$user = get_current_user_id();
			if ( current_user_can( 'administrator' ) || $user === (int) $announcement->post_author ) {
				echo apply_filters( 'lp_announcements_edit_post', ' <p class="lp-edit-post"><a href="' . get_edit_post_link( $announcement_id ) . '">' . esc_html__( 'Edit', 'course-builder' ) . '</a></p>' );
			}

			echo wp_kses_post( $content );
			?>
		</div>

		<?php
		$comment_open = comments_open( $announcement_id );
		if ( $comment_open ) {
			learn_press_announcements_template( 'loop/comments.php', array( 'announcement_id' => $announcement_id ) );
		} else {
			echo apply_filters( 'lp_announcement_hide_comments', esc_html__( 'Comments is closed', 'course-builder' ) );
		} ?>
	</div>
</div>
