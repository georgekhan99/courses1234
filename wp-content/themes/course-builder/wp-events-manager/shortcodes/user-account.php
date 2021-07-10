<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$query = new WP_Query( $args );

wpems_print_notices();

if ( !is_user_logged_in() ) {
	printf( __( 'You are not <a href="%s">login</a>', 'course-builder' ), wpems_login_url() );
	return;
}

if ( $query->have_posts() ) :
	?>

    <table>
        <thead>
        <th><?php esc_html_e( 'Booking ID', 'course-builder' ); ?></th>
        <th><?php esc_html_e( 'Events', 'course-builder' ); ?></th>
        <th><?php esc_html_e( 'Type', 'course-builder' ); ?></th>
        <th><?php esc_html_e( 'Cost', 'course-builder' ); ?></th>
        <th><?php esc_html_e( 'Quantity', 'course-builder' ); ?></th>
        <th><?php esc_html_e( 'Method', 'course-builder' ); ?></th>
        <th><?php esc_html_e( 'Status', 'course-builder' ); ?></th>
        </thead>
        <tbody>
		<?php foreach ( $query->posts as $post ): ?>

			<?php $booking = WPEMS_Booking::instance( $post->ID ) ?>
            <tr>
                <td><?php printf( '%s', wpems_format_ID( $post->ID ) ) ?></td>
                <td><?php printf( '<a href="%s">%s</a>', get_the_permalink( $booking->event_id ), get_the_title( $booking->event_id ) ) ?></td>
                <td><?php printf( '%s', floatval( $booking->price ) == 0 ? esc_html__( 'Free', 'course-builder' ) : esc_html__( 'Cost', 'course-builder' ) ) ?></td>
                <td><?php printf( '%s', wpems_format_price( floatval( $booking->price ), $booking->currency ) ) ?></td>
                <td><?php printf( '%s', $booking->qty ) ?></td>
                <td><?php printf( '%s', $booking->payment_id ? wpems_get_payment_title( $booking->payment_id ) : esc_html__( 'No payment', 'course-builder' ) ) ?></td>
                <th><?php printf( '%s', wpems_booking_status( $booking->ID ) ); ?></th>
            </tr>

		<?php endforeach; ?>
        </tbody>
    </table>

	<?php
	$args = array(
		'base'               => '%_%',
		'format'             => '?paged=%#%',
		'total'              => 1,
		'current'            => 0,
		'show_all'           => false,
		'end_size'           => 1,
		'mid_size'           => 2,
		'prev_next'          => true,
		'prev_text'          => esc_html__( '« Previous', 'course-builder' ),
		'next_text'          => esc_html__( 'Next »', 'course-builder' ),
		'type'               => 'plain',
		'add_args'           => false,
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => ''
	);

	echo paginate_links( array(
		'base'      => str_replace( 9999999, '%#%', esc_url( get_pagenum_link( 9999999 ) ) ),
		'format'    => '?paged=%#%',
		'prev_text' => esc_html__( '« Previous', 'course-builder' ),
		'next_text' => esc_html__( 'Next »', 'course-builder' ),
		'current'   => max( 1, get_query_var( 'paged' ) ),
		'total'     => $query->max_num_pages
	) );
	?>

    <div class="back-to-events">
        <a href="<?php echo esc_url(get_post_type_archive_link('tp_event')) ?>"><?php esc_html_e( 'Back to events', 'course-builder' ); ?></a>
    </div>

<?php endif; ?>

<?php wp_reset_postdata(); ?>
