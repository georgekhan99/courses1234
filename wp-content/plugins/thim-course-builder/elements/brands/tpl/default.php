<?php
$items_visible = empty( $params["items_visible"] ) ? '6' : $params["items_visible"];
$items_tablet  = empty( $params["items_tablet"] ) ? '4' : $params["items_tablet"];
$items_mobile  = empty( $params["items_mobile"] ) ? '1' : $params["items_mobile"];

$navigation = empty( $params['nav'] ) ? 'no' : 'yes';

?>
<div class="thim-brands  <?php echo esc_attr( $params["el_class"] ); ?>"
     data-items-visible="<?php echo esc_attr( $items_visible ); ?>"
     data-nav="<?php echo esc_attr( $navigation ); ?>" data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
     data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>">
    <div class="container">
        <div class="owl-carousel owl-theme">
			<?php
			if ( $params['items'] ) {
				foreach ( $params['items'] as $key => $brands ) {
					echo '<div class="item-brands">';
					if ( isset( $brands['brand_img'] ) ) {
                        $img = '';
						$id_image = isset( $brands['brand_img']['id'] ) ? $brands['brand_img']['id'] : $brands['brand_img'];
						$brand    = wp_get_attachment_image_src( $id_image, 'full' );
						if($brand){
                            $img      = '<img src="' . $brand[0] . '" width="' . $brand[1] . '" height="' . $brand[2] . '" alt="' . esc_attr__( 'Logo', 'course-builder' ) . '">';
                        }
						if ( isset( $brands['brand_link'] ) ) {
							?>
                            <a href="<?php echo esc_attr( $brands['brand_link'] ) ?>" target="_blank">
								<?php echo ent2ncr( $img ); ?>
                            </a>
							<?php
						} else {
							echo ent2ncr( $img );
						}
					}
					echo '</div>';
				}
			}
			?>
        </div>
    </div>
</div>
