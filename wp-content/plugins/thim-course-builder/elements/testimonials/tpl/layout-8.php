<div class="slider-container">
	<div class="thumbnail-slider owl-carousel">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<div class="content">
					<?php
					$thumbnail_id = isset($testimonial['image']['id']) ? (int) $testimonial['image']['id'] : (int) $testimonial['image'];
					thim_thumbnail( $thumbnail_id, '85x85', 'attachment', false );
					?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="slider owl-carousel">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<div class="content">
					<?php echo $testimonial['content'] ?>
				</div>
				<div class="user-info">
					<?php if ( isset( $testimonial['website'] ) ) : ?>
						<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title"
						   target="_blank"><?php echo esc_html( $testimonial['name'] ); ?></a>
					<?php else: ?>
						<?php echo esc_html( $testimonial['name'] ); ?>
					<?php endif; ?>
					<span class="regency"> - <?php echo esc_html( $testimonial['regency'] ) ?></span>
					<div class="star">
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

</div>