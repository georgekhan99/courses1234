<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this    WPBakeryShortCode_VC_Row
 */
$overlay_advance = $overlay_advance_bg = $overlay_advance_image = $overlay_color = $overlay_advance_position = $el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = '';
$disable_element = '';
$output          = $overlay_html = $overlay_advance_html = $after_output = $overlay_advance_size = '';
$atts            = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$css_classes = array(
	'vc_row',
	'wpb_row',
	//deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

/**
 * @thim custom
 * background overlay
 */
if ( $overlay_color ) {
	$css_classes[] = 'thim-background-overlay';
	$overlay_html .= '<div class="overlay" style="background-color: ' . esc_attr( $overlay_color ) . '"></div>';
}


if ( $overlay_advance == 'Yes' ) {
	$svg_over = '';
	if ( $overlay_advance_position == 't' ) {
		$svg_over = 'over';
	}
	$css_classes[] = 'thim-bg-advance-overlay' . ' ' . $svg_over;

	$css_classes[] = 'overlay-position-' . $overlay_advance_position;

	$overlay_image_src = '';
	$svg_height        = 633;

	$polygon_point = array(
		'br' => '1903 1903, 0 1903, 0 379, 1903 0',
		'bl' => '0 0, 1903 379, 1903 1903, 0 1903',
		'tr' => '0 0, 1903 0, 1903 633, 0 253',
		'tl' => '0 0, 1903 0, 1903 253, 0 633',
		't'  => '435 74.8, 445 55,455 39.8,465 27.5,475 18.2,485 11.5,492 7.78, 501 4.32,510 1.92,520 0.48,522 0.35, 1383 0.35,1385 0.48,1395 1.92,1404 4.32,1413 7.78,1420 11.5,1430 18.2,1440 27.5,1450 39.8,1460 55,1470 74.8',
	);


	if ( $overlay_advance_size == 'size-small' ) {
		$svg_height    = 405;
		$polygon_point = array(
			'br' => '1903 1903, 0 1903, 0 379, 1903 0',
			'bl' => '0 0, 1903 379, 1903 1903, 0 1903',
			'tr' => '0 0, 1903 0, 1903 405, 0 0',
			'tl' => '0 0, 1903 0, 1903 0, 0 405',
		);
	}
	if ( $overlay_advance_image ) {
		$overlay_advance_image_src = wp_get_attachment_image_src( $overlay_advance_image, 'full' );
		if ( ! empty( $overlay_advance_image_src[0] ) ) {

			$overlay_image_src    = $overlay_advance_image_src[0];
			$overlay_image_width  = $overlay_advance_image_src[1];
			$overlay_image_height = $overlay_advance_image_src[2];

			switch ( $overlay_advance_position ) {
				case 'br':
					$x = 1903 - $overlay_image_width;
					$y = 0;
					break;
				case 'bl':
					$x = 0;
					$y = 0;
					break;
				case 'tr':
					$x = 1903 - $overlay_image_width;
					$y = $svg_height - $overlay_image_height;
					break;
				case 'tl':
					$x = 0;
					$y = $svg_height - $overlay_image_height;
					break;
				default:
					$x = 0;
					$y = 0;
					break;
			}

		}
	}

	$svg_id = uniqid( 'thim_svg_' );
	$overlay_advance_html .= '<div class="advance-overlay ' . $svg_id . ' ' . $overlay_advance_position . ' ' . $svg_over . ' ">';
	$overlay_advance_html .= '<svg class="svg-overlay" viewBox="0 0 1903 ' . $svg_height . '" preserveAspectRatio="xMinYMin">';
	$overlay_advance_html .= '<rect clip-path="url(#' . $svg_id . ')" class="svg-background" width="1903" height="' . $svg_height . '" fill="' . $overlay_advance_bg . '" />';
	if ( $overlay_image_src ) {
		$overlay_advance_html .= '<image clip-path="url(#' . $svg_id . ')" class="svg-image" x="' . $x . '" y="' . $y . '" width="' . $overlay_image_width . '" height="' . $overlay_image_height . '" xlink:href="' . $overlay_image_src . '" />';
	}
	$overlay_advance_html .= '</svg>';
	$overlay_advance_html .= '<svg class="svg-clip-path">';
	$overlay_advance_html .= '<defs>';
	$overlay_advance_html .= '<clipPath id="' . $svg_id . '">';
	$overlay_advance_html .= '<polygon points="' . $polygon_point[ $overlay_advance_position ] . '" />';
	$overlay_advance_html .= '</clipPath>';
	$overlay_advance_html .= '</defs>';
	$overlay_advance_html .= '</svg>';
	$overlay_advance_html .= '</div>';


}

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if ( vc_shortcode_custom_css_has_property( $css, array(
		'border',
		'background',
	) ) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_row-has-fill';
}

if ( ! empty( $atts['gap'] ) ) {
	$css_classes[] = 'vc_column-gap-' . $atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[]        = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row      = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row      = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row      = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax       = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[]  = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[]        = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[]        = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id  = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class            = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= $overlay_html;
$output .= $overlay_advance_html;
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= $after_output;

echo( $output );