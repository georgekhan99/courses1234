<?php

$navigation = empty( $params['nav'] ) ? 'no' : 'yes';
?>
<div class="thim-gallery-carousel  <?php echo esc_attr( $params["el_class"] ); ?>" data-nav="<?php echo esc_attr( $navigation ); ?>">
	<div class="gallery-carousel owl-carousel owl-theme">
		<?php
		if ( $params['items'] ) {
			foreach ( $params['items'] as $key => $gallery ) {
				echo '<div class="item-gallery">';
				if ( isset( $gallery['gallery_img'] ) ) {
					$thumbnail_id = isset($gallery['gallery_img']['id']) ? (int) $gallery['gallery_img']['id'] : (int) $gallery['gallery_img'];
  					thim_thumbnail( $thumbnail_id, '1516x652', 'attachment', false, 'no-lazy' );
					if ( isset( $gallery['gallery_title'] ) || isset( $gallery['gallery_subtitle'] ) ) {
						echo '<div class="info">';
						echo '<h3>' . ent2ncr($gallery['gallery_title']) . '</h3>';
						echo '<h4>' . ent2ncr($gallery['gallery_subtitle']) . '</h4>';
						echo '</div>';
					}
				}
				echo '</div>';
			}
		}
		?>
	</div>
</div>
