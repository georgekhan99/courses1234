<?php
/**
 * Template for displaying instructors item for Instructors shortcode Learnpress v3.
 *
 * @author  ThimPress
 * @package Course Builder/Templates
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $wpdb;

$column  = 'col-md-4';
$columns = empty( $params["columns"] ) ? '3' : $params["columns"];
$column  = 'col-md-' . ( 12 / $columns );

$limit          = empty( $params["limit"] ) ? '9' : $params["limit"];
$text_load_more = empty( $params["text_load_more"] ) ? '' : $params["text_load_more"];
$offset         = $params['rank'];

$i              = 0;
$class_columns  = '';
$row_index      = 1;
$co_instructors = thim_get_all_courses_instructors();

$count_instructors = count( $co_instructors );
$max_page          = intval( $count_instructors / $limit );
if ( ( $count_instructors % $limit ) != 0 ) {
	$max_page = $max_page + 1;
}


echo '<div class="row wrap-teachers">';
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

	if ( $row_index > 1 && ( $row_index - 1 ) % $columns == 0 ) {
		echo '<div class="row wrap-teachers">';
	}


	$facebook    = get_the_author_meta( 'lp_info_facebook', $instructor["user_id"] );
	$twitter     = get_the_author_meta( 'lp_info_twitter', $instructor["user_id"] );
	$email       = get_the_author_meta( 'lp_info_google_plus', $instructor["user_id"] );
	$skype       = get_the_author_meta( 'lp_info_skype', $instructor["user_id"] );
	$pinterest   = get_the_author_meta( 'lp_info_pinterest', $instructor["user_id"] );
	$instagram   = get_the_author_meta( 'lp_info_instagram', $instructor["user_id"] );
	$major       = get_the_author_meta( 'lp_info_major', $instructor["user_id"] );
	$description = get_the_author_meta( 'description', $instructor["user_id"] );

	?>

	<div class="item <?php echo esc_attr( $column ); ?> <?php echo esc_attr( $class_columns ); ?>">
		<div class="avatar-item">
			<div class="avatar-instructors">
 				 <a class="avatar-small"
					   href="<?php echo learn_press_user_profile_link( $instructor["user_id"] ); ?>">
						<?php echo get_avatar( $instructor["user_id"], 500 ); ?>
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
					?>
				</div>
			</div>
			<div class="avartar-info">
				<h5>
					<a href="<?php echo learn_press_user_profile_link( $instructor["user_id"] ); ?>"><?php echo get_the_author_meta( 'display_name', $instructor["user_id"] ); ?></a>
				</h5>
				<?php echo '<div class="author-major">' . ( isset( $major ) ? $major : esc_attr__( 'Teachers', 'course-builder' ) ) . '</div>'; ?>

				<?php if ( !empty( $description ) && $params['instructor_style'] == 'home_courses_instructor' ) : ?>
					<div class="description"><?php echo $description; ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
	if ( $row_index > 1 && ( $row_index - 1 ) % $columns == 0 ) {
		echo '</div>';
	}
	$row_index ++;
}
echo '</div>';
?>

<?php

if ( $text_load_more != '' && $max_page > 1 && intval( ( $offset + 1 ) * $limit ) < $count_instructors ) {
	echo '<div class="button-load text-center">';
	thim_loading_icon();
	echo '<div class="load-more">' . esc_html( $text_load_more ) . '</div>';
}
?>