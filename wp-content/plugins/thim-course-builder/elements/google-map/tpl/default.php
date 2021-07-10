<?php

// Get settings
$id     = 'ob-map-canvas-' . md5( $params['map_center'] ) . '';
$height = $params['height'] . 'px';
$data   = 'data-address="' . $params['map_center'] . '" ';
$data   .= 'data-zoom="' . $params['zoom'] . '" ';
$data   .= 'data-scroll-zoom="' . $params['scroll_zoom'] . '" ';
$data   .= 'data-draggable="' . $params['draggable'] . '" ';
$data   .= 'data-marker-at-center="' . $params['marker_at_center'] . '" ';
$data   .= 'data-style="' . $params['map_style'] . '" ';
$data   .= 'data-api_key="' . $params['api_key'] . '" ';

$id_marker_icon  = isset( $params['marker_icon']['id'] ) ? intval( $params['marker_icon']['id'] ) : intval( $params['marker_icon'] );
$icon_attachment = $id_marker_icon ? wp_get_attachment_image_src( $id_marker_icon, 'full' ) : '';
$icon            = $icon_attachment ? $icon_attachment[0] : '';

$data               .= 'data-marker-icon="' . $icon . '" ';
$id_map_cover_image = isset( $params['map_cover_image']['id'] ) ? intval( $params['map_cover_image']['id'] ) : intval( $params['map_cover_image'] );

$cover_attachment = $id_map_cover_image ? wp_get_attachment_image_src( $id_map_cover_image, 'full' ) : '';
$cover            = $cover_attachment ? $cover_attachment[0] : '';
if($params['map_options'] == 'api'){
	$class = 'ob-google-map-canvas';

	$html = '<div class="thim-sc-googlemap" style="height: ' . $height . ';" data-cover="' . $params['map_cover'] . '">';
	if ( $params['map_cover'] ) {
		$html .= '<div class="map-cover" style="height: ' . $height . '; background-image: url(' . $cover . ');"></div>';
	}
	$html .= '<div class="' . $class . ' ' . esc_attr( $params['el_class'] ) . '" style="height: ' . $height . ';" id="' . $id . '" ' . $data . ' ></div>';
	$html .= '</div>';

	echo ent2ncr( $html );
}else{
	
	printf(
		'<div class="thim-map-iframe" style="height: ' . $height . ';" ><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near" title="%3$s" aria-label="%3$s"></iframe></div>',
		rawurlencode( $params['map_center'] ),
		absint( $params['zoom'] ),
		esc_attr( $params['map_center'] )
	);
}
