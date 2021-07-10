<?php
$layout = 'layout-1';
switch ( $params['layout'] ) {
	case 'layout-2':
		$layout = 'layout-1';
		break;
	case 'layout-4':
		$layout = 'layout-4';
		break;
	default:
		$layout = $params['layout'];
		break;
}
?>
<div class="thim-sc-steps <?php echo esc_attr( $params['layout'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php thim_get_template( $layout, array( 'params' => $params ), $params['base'] . '/tpl/' ); ?>
</div>
