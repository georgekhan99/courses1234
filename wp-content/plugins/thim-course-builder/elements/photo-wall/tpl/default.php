<?php
$crop_images = $params['crop_images'] ? $params['crop_images'] : 'image-crop';
$crop_sizes  = array();
if ( $crop_images ) {
	$crop_sizes[] = '150x182';
	$crop_sizes[] = '150x126';
	$crop_sizes[] = '630x430';
	$crop_sizes[] = '470x420';
	$crop_sizes[] = '310x232';
	$crop_sizes[] = '150x280';
	$crop_sizes[] = '310x225';
	$crop_sizes[] = '470x350';
	$crop_sizes[] = '150x177';
	$crop_sizes[] = '470x420';
	$crop_sizes[] = '310x210';
	$crop_sizes[] = '150x137';
	$crop_sizes[] = '310x270';
	$crop_sizes[] = '200x157';
	$crop_sizes[] = '252x263';
}

$mobile_limit = isset( $params["mobile_limit"] ) ? $params["mobile_limit"] : '8';
$mobile_title = ( $params["mobile_title"] ) ? $params["mobile_title"] : esc_html__( 'View All', 'course-builder' );
$mobile_link  = ( $params["mobile_link"] ) ? $params["mobile_link"] : '#';
$class_mobile = 'show_mobile';
$i            = 0;
?>
<div class="thim-sc-photo-wall <?php echo esc_attr( $params['el_class'] ); ?> ">
	<ul class="grid <?php echo esc_attr( $crop_images ); ?>">
		<?php
		if ( $params['images'] ) :
			foreach ( $params['images'] as $key => $image ) :
				$i ++;
				if ( $i <= $mobile_limit ) {
					$class_mobile = 'show_mobile';
				} else {
					$class_mobile = 'hide_mobile';
				}
				if ( isset( $image['image'] ) ) : ?>
					<li class="grid-item <?php echo esc_attr( $class_mobile ); ?>">
						<div class="inner-item">
							<div class="thumbnail">
								<?php
								$thumbnail_size = 'full';
								if ( isset( $crop_sizes[ $key ] ) ) {
									$thumbnail_size = $crop_sizes[ $key ];
								}
								if ( $crop_images != 'image-crop' ) {
									$thumbnail_size = 'full';
								}
								$thumbnail_id = isset($image['image']['id']) ? $image['image']['id'] : $image['image'];
 								thim_thumbnail( $thumbnail_id, $thumbnail_size, 'attachment', false, 'no-lazy' );
								?>
							</div>
							<div class="item-info">
								<?php if ( isset( $image['title'] ) ) : ?>
									<?php $link = isset( $image['link'] ) ? $image['link'] : ''; ?>
									<a href="<?php echo esc_attr( $link ) ?>" class="title"><?php echo esc_attr( $image['title'] ) ?></a>
								<?php endif; ?>
								<?php if ( isset( $image['description'] ) ) : ?>
									<div class="description"><?php echo esc_attr( $image['description'] ) ?></div>
								<?php endif; ?>
							</div>
						</div>
					</li>
					<?php
				endif;
			endforeach;
		endif;
		?>
	</ul>
	<div class="loadmore hidden-sm-up">
		<a href="<?php echo esc_url( $mobile_link ); ?>"><?php echo esc_html( $mobile_title ); ?></a>
	</div>
</div>