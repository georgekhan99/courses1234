<?php

global $post;

$limit   = ! empty( $params['limit'] ) ? $params['limit'] : 8;
$filter  = isset( $params['filter'] ) ? $params['filter'] : true;
$columns = ! empty( $params['columns'] ) ? $params['columns'] : 4;

$query_args = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => $limit
);

if($params['filter'] == 'yes' || $params['filter'] == 'true'){
	$hidden_class = 'd-none';
}else{
	$hidden_class = '';
}
if ( ! empty( $params['cat'] ) ) {
	if(is_array($params['cat'])){
		$list_categoties = implode( ',', $params['cat'] );
	}else{
		$list_categoties = $params['cat'];

	}
	$query_args['cat'] = $list_categoties;
}

switch ( $columns ) {
	case 2:
		$class_col = "col-sm-6";
		break;
	case 3:
		$class_col = "col-sm-4";
		break;
	case 4:
		$class_col = "col-sm-3";
		break;
	case 5:
		$class_col = "thim-col-5";
		break;
	case 6:
		$class_col = "col-sm-2";
		break;
	default:
		$class_col = "col-sm-3";
}

$posts_display = new WP_Query( $query_args );

if ( $posts_display->have_posts() ) :

	$categories = array();
	$html      = '';

	while ( $posts_display->have_posts() ) : $posts_display->the_post();

		$class    = $image_crop_popup = '';
		$cats     = get_the_category();
		$image_id = get_post_thumbnail_id( $post->ID );
		if ( $image_id ) {
			$imgurl = wp_get_attachment_image_src( $image_id, array( 800, 640 ) );
//		$image_crop_popup = thim_aq_resize( $imgurl[0], 800, 640, true );
			$image_crop_popup = $imgurl[0];
		}


		if ( ! empty( $cats ) ) {
			foreach ( $cats as $key => $value ) {
				$class                         .= ' filter-' . $value->term_id;
				$categories[ $value->term_id ] = $value->name;
			}
		}
		$html .= '<div class="' . $class_col . $class . '">';
		$html .= '<a class="thim-gallery-popup" href="' . $image_crop_popup . '" data-id="' . get_the_ID() . '"><span class="fa  fa-expand"></span>' . thim_get_thumbnail( get_the_ID(), '400x400', 'post', false ) . '</a>';
		$html .= '</div>';

	endwhile;

	?>

    <div class="thim-sc-gallery">
        <div class="wrapper-filter-controls <?php echo esc_attr($hidden_class) ?> ">
            <ul class="filter-controls">
                
				<?php
				if ( ! empty( $params['cat'] ) ) {
					if(!is_array($params['cat'])){
						$params['cat'] =  explode( ',', $params['cat'] );
					}
					if(count($params['cat']) > 1 ){
					?>
						<li>
							<a class="filter active" data-filter="*"
							href="javascript:;"><?php esc_html_e( 'All', 'course-builder' ); ?></a>
						</li>
						<?php
							foreach ( $params['cat'] as $key => $value ) {
								$cat_name =get_cat_name($value);
								echo '<li><a class="filter" href="javascript:;" data-filter=".filter-' . $value . '">' . $cat_name . '</a></li>';
							}
						?>
					<?php }else{
						foreach ( $params['cat'] as $key => $value ) {
							$cat_name =get_cat_name($value);
							echo '<li><a class="filter active" href="javascript:;" data-filter=".filter-' . $value . '">' . $cat_name . '</a></li>';
						}
					}
					
				}else{ ?>
					<li>
						<a class="filter active" data-filter="*"
						href="javascript:;"><?php esc_html_e( 'All', 'course-builder' ); ?></a>
					</li>
				<?php } ?>
            </ul>
        </div>

        <div class="wrapper-gallery row" itemscope itemtype="http://schema.org/ItemList">
			<?php
			echo ent2ncr( $html );
			?>
        </div>
        <div class="thim-gallery-show"></div>
    </div>


<?php
endif;
wp_reset_postdata();
