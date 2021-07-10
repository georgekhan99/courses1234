<?php
$layout      = isset( $params['layout'] ) ? $params['layout'] : 'layout-1';
$border_left = '';
if ( $params['border_left'] == true ) {
	$border_left = 'has_border';
}

?>
<div
	class="thim-new-iconbox <?php echo esc_attr( $layout ); ?> <?php echo esc_attr( $params['el_class'] ); ?> <?php echo $border_left; ?>">
	<?php thim_get_template( $layout, array( 'params' => $params ), $params['base'] . '/tpl/' ); ?>
</div>
