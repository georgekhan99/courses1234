<?php
/**
 * Created by PhpStorm
 * Project: wordpress-lms
 * Filename: default.php
 * User: longvv
 * Time: 1/3/2018 3:35 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$box          = array_filter( (array) $params['box'] );
$number_items = count( $box );

$el_id    = $params['el_id'] ? ' id="' . $params['el_id'] . '"' : '';
$el_class = $params['el_class'] ? ' ' . $params['el_class'] : '';

if ( ! empty( $box ) ) {
	?>
    <div class="thim-sc-intro-box<?php echo esc_attr( $el_class ); ?>"<?php echo esc_attr( $el_id ); ?>>
        <!-- Background Image-->
		<?php
		if ( $params['bg-image'] ) {
			$img_src          = '';
			$attachment_bg_id = isset( $params['bg-image']['id'] ) ? intval( $params['bg-image']['id'] ) : intval( $params['bg-image'] );
			if ( $attachment_bg_id ) {
				$src     = wp_get_attachment_image_src( $attachment_bg_id, array( 1362, 534 ) );
				$img_src = $src ? $src[0] : '';
			} elseif ( isset( $params['bg-image']['url'] ) ) {
				$img_src = $params['bg-image']['url'];
			}
			echo '<div class="intro-box-background" style="background-image: url(' . ( $img_src ) . ')">';
			echo '<img src="' . ( $img_src ) . '">';
			echo '</div>';
		}
		?>

        <div class="intro-box-content-wrapper">
            <form action="">
                <!-- Navigation -->
				<?php if ( $number_items > 1 ): ?>
					<?php
					for ( $i = 1; $i <= $number_items; $i ++ ) {
						echo '<input type="radio" name="intro-box-nav" id="slide' . $i . '"' . checked( $i, 1, false ) . '>';
					}

					echo '<input type="radio" name="intro-box-play" id="auto-play">';

					echo '<div class="label-container">';
					?>
                    <svg class="svg1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 220" width="100%"
                         height="100%" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradient">
                                <stop offset="0" class="stop1"></stop>
                                <stop offset="0.6" class="stop2"></stop>
                            </linearGradient>
                        </defs>
                        <ellipse ry="100" rx="100" cy="110" cx="110"
                                 style="fill:none;stroke:url(#gradient);stroke-width:8;"></ellipse>
                    </svg>
                    <svg class="svg2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 220" width="100%"
                         height="100%" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradient">
                                <stop offset="0" class="stop1"></stop>
                                <stop offset="0.6" class="stop2"></stop>
                            </linearGradient>
                        </defs>
                        <ellipse ry="100" rx="100" cy="110" cx="110"
                                 style="fill:none;stroke:url(#gradient);stroke-width:8;"></ellipse>
                    </svg>
					<?php
					for ( $i = 1; $i <= $number_items; $i ++ ) {

						if ( $i != 1 && $i != $number_items ) { // Not first and last slide
							echo '<label for="slide' . ( $i - 1 ) . '" class="button-nav manage' . ( $i ) . ' prev"></label>';
							echo '<label for="slide' . ( $i + 1 ) . '" class="button-nav manage' . ( $i ) . ' next"></label>';
						} elseif ( $i == 1 ) { // First slide
							echo '<label for="slide' . $number_items . '" class="button-nav manage1 prev"></label>';
							echo '<label for="slide2" class="button-nav manage1 next"></label>';
						} else { // Last slide

							echo '<label for="slide' . ( $number_items - 1 ) . '" class="button-nav manage' . ( $number_items ) . ' prev"></label>';
							echo '<label for="slide1" class="button-nav manage' . ( $number_items ) . ' next"></label>';
						}
					}
					echo '</div>';
					?>
				<?php endif; ?>

                <!-- Main content -->
                <div class="slider-wrapper">
                    <div class="intro-box-slider">
						<?php foreach ( $box as $content ): ?>
                            <div class="box-display">
                                <div class="box-wrapper">
									<?php if ( ! empty( $content['image'] ) ): ?>
                                        <div class="single-image">
											<?php
											$attachment_id = isset( $content['image']['id'] ) ? intval( $content['image']['id'] ) : intval( $content['image'] );
											if ( $attachment_id ) {
												thim_thumbnail( $attachment_id, "434x358", 'attachment', false );
											}
											?>
                                        </div>
									<?php endif; ?>
                                    <div class="content-wrapper">
										<?php if ( ! empty( $content['title'] ) ): ?>
                                            <h3 class="title"><?php echo esc_html( $content['title'] ); ?></h3>
										<?php endif; ?>

										<?php if ( ! empty( $content['description'] ) ): ?>
                                            <p class="description"><?php echo esc_html( $content['description'] ); ?></p>
										<?php endif; ?>
										<?php
										$link_detail = '';
										if ( $content['read_more'] ) {
											if ( isset( $content['read_more']['url'] ) && ! empty( $content['read_more']['url'] ) ) {
												$link_detail           = $content['read_more'];
												$link_detail['target'] = ( $content['read_more']['is_external'] == 'on' ) ? ' target="_blank"' : '';
												$link_detail['rel']    = ( $content['read_more']['nofollow'] == 'on' ) ? ' rel="nofollow"' : '';
												$link_output           = $link_detail['target'] . $link_detail['rel'];
												$link_detail['title']  = isset( $content['read_more_title'] ) ? $content['read_more_title'] : '';
											} elseif ( ! is_array( $content['read_more'] ) ) {
												$link_detail           = vc_build_link( $content['read_more'] );
												$link_detail['target'] = $link_detail['target'] ? ' target="' . esc_attr( $link_detail['target'] ) . '"' : '';
												$link_detail['rel']    = $link_detail['rel'] ? ' rel="' . esc_attr( $link_detail['rel'] ) . '"' : '';
												$link_output           = $link_detail['target'] . $link_detail['rel'];
											}
										}

										if ( $link_detail ) {
											echo '<a href="' . esc_url( $link_detail['url'] ) . '"' . ( $link_output ) . ' class="more-detail">' . esc_html( $link_detail['title'] ) . '</a>';
											$link_after = '</a>';
										}
										?>
                                    </div>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<?php
}
