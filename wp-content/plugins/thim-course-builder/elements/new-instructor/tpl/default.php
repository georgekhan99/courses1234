<?php
/**
 * Template for displaying instructors item2 for Instructors shortcode Learnpress v3.
 *
 * @author  ThimPress
 * @package Course Builder/Templates
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $wpdb;

$column  = 'col-md-6';
$columns = empty( $params["columns"] ) ? '2' : $params["columns"];
$column  = 'col-md-' . ( 12 / $columns );

$limit  = empty( $params["limit"] ) ? '4' : $params["limit"];
$offset = $params['rank'];

$blog_id      = '';
$capabilities = $wpdb->prefix . 'capabilities';
if ( is_multisite() ) {
	$blog_id = get_current_blog_id();
	if ( $blog_id != 1 ) {
		$capabilities = 'wp_' . $blog_id . '_capabilities';
	}
}

$ARRAY = array( '%lp_teacher%', '_lp_co_teacher' );

$query = $wpdb->prepare( "
	SELECT *
	FROM {$wpdb->usermeta}
	 WHERE meta_value LIKE %s OR meta_value LIKE %s
	AND meta_key = '{$capabilities}'
	ORDER BY user_id
	DESC LIMIT {$limit} OFFSET {$offset}
", $ARRAY );


$instructor    = $wpdb->get_results( $query );
$i             = 0;
$class_columns = '';
$row_index     = 1;

$query2 = $wpdb->prepare( "
	SELECT *
	FROM {$wpdb->usermeta}
	 WHERE meta_value LIKE %s OR meta_value LIKE %s
	AND meta_key = '{$capabilities}'
	ORDER BY user_id
", $ARRAY );

$instructor2       = $wpdb->get_results( $query2 );
$count_instructors = count( $instructor2 );
$max_page          = intval( $count_instructors / $limit );
if ( ( $count_instructors % $limit ) != 0 ) {
	$max_page = $max_page + 1;
} ?>

<div class="thim-new-instructors <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php echo '<div class="row wrap-teachers">'; ?>
	<?php foreach ( $instructor as $key => $user ) { ?>
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

		if ( $row_index > 1 && ( $row_index - 1 ) % $columns == 0 ) {
			//echo '<div class="row wrap-teachers">';
		}

		$facebook  = get_the_author_meta( 'lp_info_facebook', $user->user_id );
		$twitter   = get_the_author_meta( 'lp_info_twitter', $user->user_id );
		$email     = get_the_author_meta( 'lp_info_google_plus', $user->user_id );
		$skype     = get_the_author_meta( 'lp_info_skype', $user->user_id );
		$pinterest = get_the_author_meta( 'lp_info_pinterest', $user->user_id );
		$instagram = get_the_author_meta( 'lp_info_instagram', $user->user_id );
		$linkein   = get_the_author_meta( 'lp_info_linkedin', $user->user_id );
		$major     = get_the_author_meta( 'lp_info_major', $user->user_id );
		$work      = get_the_author_meta( 'lp_info_work', $user->user_id );
		?>

        <div class="item <?php echo esc_attr( $column ); ?> <?php echo esc_attr( $class_columns ); ?>">
            <div class="avatar-item">
                <div class="avatar-instructors">
                    <a class="avatar-small" href="<?php echo learn_press_user_profile_link( $user->user_id ); ?>">
						<?php echo get_avatar( $user->user_id, 187 ); ?>
                    </a>
                    <div class="author-social">
						<?php
						if ( $facebook ) {
							echo '<a href="' . esc_url( $facebook ) . '"><i class="fa fa-facebook"></i></a>';
						}
						if ( $twitter ) {
							echo '<a href="' . esc_url( $twitter ) . '"><i class="fa fa-twitter"></i></a>';
						}
						if ( $skype ) {
							echo '<a href="skype:' . esc_attr( $skype ) . '?call"><i class="fa fa-skype"></i></a>';
						}
						if ( $pinterest ) {
							echo '<a href="' . esc_url( $pinterest ) . '"><i class="fa fa-pinterest"></i></a>';
						}
						if ( $email ) {
							echo '<a href="mailto:' . esc_attr( $email ) . '"><i class="fa fa-google-plus"></i></a>';
						}
						if ( $instagram ) {
							echo '<a href="' . esc_attr( $instagram ) . '"><i class="fa fa-instagram"></i></a>';
						}
						if ( $linkein ) {
							echo '<a href="' . esc_attr( $linkein ) . '"><i class="fa fa-linkedin"></i></a>';
						}
						?>
                    </div>
                </div>
                <div class="avartar-info">
                    <h5>
                        <a href="<?php echo learn_press_user_profile_link( $user->user_id ); ?>"><?php echo get_the_author_meta( 'display_name', $user->user_id ); ?></a>
                    </h5>
					<?php echo '<div class="author-major">' . ( isset( $major ) ? $major : esc_attr__( 'Teachers', 'course-builder' ) ) . '</div>'; ?>
					<?php if ( $work ) { ?>
                        <div class="work-for">
                            <h6>Works for:</h6>
                            <img src="<?php echo $work; ?>" alt="url work for">
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
		<?php
		if ( $row_index > 1 && ( $row_index % $columns == 0 ) ) {
			//echo '</div>';
		}
		$row_index ++;
	}
	echo '</div>';
	?>
</div>
