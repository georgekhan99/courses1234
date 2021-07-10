<?php
/**
 * @author        ThimPress
 * @package       LearnPress/Templates
 * @version       3.0.0
 */

defined( 'ABSPATH' ) || exit();
if ( ! $messages ) {
	return;
}
?>
<?php foreach ( $messages as $type => $message ) { ?>
	<?php if ( $message ): foreach ( $message as $content ) { ?>
		<?php
		if ( is_array( $content ) ) {
			$content   = $content['content'];
			$autoclose = ! empty( $content['autoclose'] ) ? $content['autoclose'] : false;
			if ( $autoclose === true ) {
				$autoclose = 3000;
			}
		} else {
			$autoclose = false;
		}

		$noti_success = '';

		if ( learn_press_become_teacher_sent() ) {
			$noti_success = 'noti-success';
		}
		?>
		<div class="learn-press-message <?php echo esc_attr( $type ) . ' ' . $noti_success; ?>" <?php echo( $autoclose ? 'data-autoclose="' . esc_attr( $autoclose ) . '"' : '' ); ?>>
			<?php
			if ( ! preg_match( '!<p>!', $content ) && ! preg_match( '!<div>!', $content ) ) {
				$content = sprintf( '<p>%s</p>', $content );
			}
			?>
			<?php echo ent2ncr( $content ); ?>
		</div>
	<?php } ?>
	<?php endif; ?>
<?php } ?>