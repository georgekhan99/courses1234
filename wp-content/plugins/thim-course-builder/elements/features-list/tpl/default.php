<div class="thim-sc-features-list <?php echo esc_attr( $params['style'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( $params['title'] ): ?>
        <h3 class="title">
			<?php echo esc_attr( $params['title'] ) ?>
        </h3>
	<?php endif; ?>
    <ul class="meta-content">
		<?php
		$rank = 0;
		foreach ( $params['features_list'] as $features ):
			$rank ++;
			?>
            <li>
			<?php if ( $features['sub_title'] ) : ?>
            <h4 class="sub-title">
					<span class="rank">
						<span class="number"><?php echo esc_attr( $rank ); ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 220" width="100%" height="100%"
                             preserveAspectRatio="none">
							<defs>
						    <linearGradient id="gradient">
						      <stop offset="0" class="stop1"></stop>
						      <stop offset="0.6" class="stop2"></stop>
						    </linearGradient>
						  </defs>
						  <ellipse ry="100" rx="100" cy="110" cx="110"
                                   style="fill:none;stroke:url(#gradient);stroke-width:4;"></ellipse>
						</svg>
					</span>
				<?php
				$link_before = $link_detail = $link_after = '';
  				if ( $features['link'] ) {
					if ( isset( $features['link']['url'] ) && ! empty( $features['link']['url'] ) ) {
						$link_detail           = $features['link'];
						$link_detail['target'] = ( $features['link']['is_external'] == 'on' ) ? ' target="_blank"' : '';
						$link_detail['rel']    = ( $features['link']['nofollow'] == 'on' ) ? ' rel="nofollow"' : '';
						$link_output           = $link_detail['target'] . $link_detail['rel'];
					} elseif ( ! is_array( $features['link'] ) ) {
						$link_detail           = vc_build_link( $features['link'] );
						$link_detail['target'] = $link_detail['target'] ? ' target="' . esc_attr( $link_detail['target'] ) . '"' : '';
						$link_detail['rel']    = $link_detail['rel'] ? ' rel="' . esc_attr( $link_detail['rel'] ) . '"' : '';
						$link_output           = $link_detail['target'] . $link_detail['rel'];
					}
				}

				if ( $link_detail ) {
					$link_before = '<a href="' . esc_attr( $link_detail['url'] ) . '"' . $link_output . '>';
					$link_after  = '</a>';
				}
				?>
				<?php echo $link_before . esc_attr( $features['sub_title'] ) . $link_after; ?>

            </h4>
		<?php endif;
			if ( $features['sub_title'] ) : ?>
                <p class="description">
					<?php echo esc_attr( $features['description'] ) ?>
                </p>
                </li>
			<?php endif;
		endforeach; ?>
    </ul>
</div>