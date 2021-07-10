<?php
/**
 * Created by PhpStorm.
 * User: XuanLe
 * Date: 13/06/2017
 * Time: 2:11 CH
 */

$icon     = '';
$layout   = isset( $params['layout'] ) ? $params['layout'] : '';
if(is_array($params['upload_image'])){
	$params['upload_image'] = $params['upload_image']['id'];
}
$bg_image = wp_get_attachment_url( $params['upload_image'] );
$link     = $params['link_video'];
//if ( strstr( $params['link_video'], "&" ) ) {
//	$link = substr( $params['link_video'], 0, strpos( $params['link_video'], "&" ) );
//}
?>
<div class="thim-sc-video-box <?php echo esc_attr( $params['bg_image'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?> <?php echo esc_attr( $layout ); ?>">
	<div class="video">
		<?php if ( $params['link_video'] ) : ?>
			<div class="video-box" style="background-image: url(<?php echo esc_url( $bg_image ); ?>)">
				<div class="play-button">
					<a href="<?php echo esc_url( $link ); ?>" class="video-thumbnail"><i class="icon-play"></i></a>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $params['content'] && ( $layout == 'layout-1' ) ): ?>
		<div class="row content-box">
			<div class="col-lg-2 share">
				<?php
				if ( $params['share_link'] ) {
					do_action( 'thim_social_share_video' );
				}
				?>
			</div>
			<div class="col-lg-10 main-content">
				<?php echo( $params['content'] ); ?>
			</div>
		</div>
		<hr>
	<?php endif; ?>
</div>
