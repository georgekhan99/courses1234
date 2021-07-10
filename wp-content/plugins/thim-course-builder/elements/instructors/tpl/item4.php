<?php

global $wpdb;

$column  = 'col-md-4';
$columns = empty( $params["columns"] ) ? '2' : $params["columns"];
$column  = 'col-md-' . ( 12 / $columns );

$limit          = empty( $params["limit"] ) ? '4' : $params["limit"];
$text_load_more = empty( $params["text_load_more"] ) ? '' : $params["text_load_more"];
$link_load_more = empty( $params["link_load_more"] ) ? '' : $params["link_load_more"];

$offset        = $params['rank'];
$i             = 0;
$class_columns = '';
$row_index     = 1;

$co_instructors = thim_get_all_courses_instructors();

$count_instructors = count( $co_instructors );
$max_page          = intval( $count_instructors / $limit );
if ( ( $count_instructors % $limit ) != 0 ) {
	$max_page = $max_page + 1;
}

echo '<div class="row wrap-teachers columns-' . $params["columns"] . '">';
?>
<?php foreach ( $co_instructors as $user_id => $instructor ) { ?>
	<?php
	$i ++;
	if ( ( $i - 1 ) % $columns == 0 ) {
		$class_columns = 'first';
	} else {
		$class_columns = 'last';
	}
	if ( $i > $limit ) {
		break;
	}

	$facebook    = get_the_author_meta( 'lp_info_facebook', $instructor["user_id"] );
	$twitter     = get_the_author_meta( 'lp_info_twitter', $instructor["user_id"] );
	$email       = get_the_author_meta( 'lp_info_google_plus', $instructor["user_id"] );
	$skype       = get_the_author_meta( 'lp_info_skype', $instructor["user_id"] );
	$pinterest   = get_the_author_meta( 'lp_info_pinterest', $instructor["user_id"] );
	$major       = get_the_author_meta( 'lp_info_major', $instructor["user_id"] );
	$description = get_the_author_meta( 'description', $instructor["user_id"] );

	?>

    <div class="item <?php echo esc_attr( $column ); ?> <?php echo esc_attr( $class_columns ); ?>">
        <div class="avatar-item">
            <div class="avatar-instructors">
				<?php
				echo get_avatar( $instructor["user_id"], 680 );
				?>
                <div class="avartar-info">
                    <h5>
                        <a href="<?php echo learn_press_user_profile_link( $instructor["user_id"] ); ?>"><?php echo get_the_author_meta( 'display_name', $instructor["user_id"] ); ?></a>
                    </h5>
					<?php echo '<div class="author-major">' . ( isset( $major ) ? $major : esc_attr__( 'Teachers', 'course-builder' ) ) . '</div>'; ?>

					<?php if ( ! empty( $description ) ) : ?>
                        <div class="description"><?php echo wp_trim_words( $description, 20 ); ?></div>
					<?php endif; ?>
                    <a href="<?php echo learn_press_user_profile_link( $instructor["user_id"] ); ?>"><span><?php echo esc_html__( 'Read more', 'course-builder' ) ?></span><i
                                class="ion-ios-arrow-right"></i></a>

                </div>
            </div>

        </div>
    </div>
	<?php
}
echo '</div>';
if ( $text_load_more != '' ) {
	echo '<div class="view-more"><a href="' . esc_html( $link_load_more ) . '">' . esc_html( $text_load_more ) . '<i class="ion-ios-arrow-right"></i></a></div>';
}
?>