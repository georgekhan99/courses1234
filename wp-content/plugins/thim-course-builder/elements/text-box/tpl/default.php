<div class="thim-sc-text-box <?php echo esc_attr( $params['style'] ); ?> <?php echo esc_attr( $params['size_style'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( $params['title_1'] ): ?>
        <div class="title-1"><?php echo ent2ncr( $params['title_1'] ); ?></div>
	<?php endif; ?>

	<?php if ( $params['content'] ): ?>
        <div class="title-2"><?php echo ent2ncr( $params['content'] ); ?></div>
	<?php endif; ?>

	<?php
    $link_detail = '';
	if ( $params['button'] ) {

 		if ( isset( $params['button']['url'] ) && ! empty( $params['button']['url'] ) ) {
			$link_detail           = $params['button'];
			$link_detail['target'] = ( $params['button']['is_external'] == 'on' ) ? ' target="_blank"' : '';
			$link_detail['rel']    = ( $params['button']['nofollow'] == 'on' ) ? ' rel="nofollow"' : '';
			$link_output           = $link_detail['target'] . $link_detail['rel'];
			$link_detail['title']  = $params['button_text'] ? $params['button_text'] : '';
		} elseif (  ! is_array( $params['button'] ) ) {

			$link_detail           = vc_build_link( $params['button'] );
			$link_detail['target'] = $link_detail['target'] ? ' target="' . esc_attr( $link_detail['target'] ) . '"' : '';
			$link_detail['rel']    = $link_detail['rel'] ? ' rel="' . esc_attr( $link_detail['rel'] ) . '"' : '';
			$link_output           = $link_detail['target'] . $link_detail['rel'];
		}
        if ( $link_detail) {
            echo '<a href="' . ( $link_detail['url'] ) . '"' . ( $link_output ) . ' class="btn btn-default"><span class="text">' . esc_html( $link_detail['title'] ) . '</span></a>';
        }
 	}
	?>
</div>
