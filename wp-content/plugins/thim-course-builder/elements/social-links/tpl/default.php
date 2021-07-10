<div class="thim-sc-social-links <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php
	if ( $params['title'] ) {
		echo '<h3 class="box-title">' . $params['title'] . '</h3>';
	}
	echo '<ul class="socials">';
	foreach ( $params['social_links'] as $social ) {
		echo '<li>';
		echo '<a target="_blank" href="' . esc_url( $social['link'] ) . '">' . esc_html( $social['name'] ) . '</a>';
		echo '</li>';
	}
	echo '</ul>';
	?>
</div>