<?php
$target_link = ( $params['target'] ) ? '_blank' : '_self';
?>
<div
        class="thim-sc-button <?php echo esc_attr( $params['el_class'] ); ?> <?php echo esc_attr( $params['separator'] ); ?> <?php echo esc_attr( $params['align'] ); ?>">
	<?php if ( $params['link'] ): ?>
        <a href="<?php echo esc_attr( $params['link'] ); ?>" target="<?php echo esc_attr( $target_link ); ?>"
           class="btn btn-<?php echo esc_attr( $params['style'] ); ?> <?php echo esc_attr( $params['size'] ); ?>">
            <span class="text"><?php echo esc_html( $params['title'] ); ?></span>
        </a>
	<?php endif; ?>
</div>
