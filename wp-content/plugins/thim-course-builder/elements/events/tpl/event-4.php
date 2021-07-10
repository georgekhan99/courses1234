<?php
$number_events = !empty( $params['number_events'] ) ? $params['number_events'] : 1;

$args = array(
    'post_type'      => 'tp_event',
    'posts_per_page' => $number_events,
    'order'          => $params['order'] == 'asc' ? 'asc' : 'desc',
);
switch ( $params['status_events'] ) {
    case 'upcoming':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'upcoming',
                'compare' => '=',
            ),
        );
        break;
    case 'happening':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'happening',
                'compare' => '=',
            ),
        );
        break;
    case 'expired':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'expired',
                'compare' => '=',
            ),
        );
        break;
    case 'not-expired':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => array( 'upcoming', 'happening' ),
                'compare' => 'IN',
            ),
        );
        break;
    default:
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => array( 'upcoming', 'happening', 'expired' ),
                'compare' => 'IN',
            ),
        );
}


switch ( $params['orderby'] ) {
    case 'time' :
        $args['orderby']  = 'meta_value';
        $args['meta_key'] = 'tp_event_date_end';
        break;
    case 'recent' :
        $args['orderby'] = 'post_date';
        break;
    case 'title' :
        $args['orderby'] = 'post_title';
        break;
    case 'popular' :
        $args['orderby'] = 'comment_count';
        break;
    default : //random
        $args['orderby'] = 'rand';
}


if ( $params['cat_events'] ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'tp_event_category',
            'field'    => 'id',
            'terms'    => array( $params['cat_events'] ),
        ),
    );
}

$events = new WP_Query( $args );

$params['query'] = $events;
?>
<div class="thim-events-block clearfix layout-4 <?php echo esc_attr( $params['el_class'] ); ?> ">
    <div class="event-wrapper">
        <?php
        $first_event = true;
        if ( $params['query']->have_posts() ) : ?>
            <?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
                <?php if ( ! $first_event ) : ?>
                    <div class="event-item">
                        <div class="event-detail">
                            <div class="date">
                                <?php echo wpems_get_time( 'd F' ); ?>
                            </div>
                            <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </div>

                    </div>
                <?php else: $first_event = false; ?>
                    <div class="main-event">
                        <div class="sc-title">
                            <?php echo esc_html__( 'New events', 'course-builder' ) ?>
                        </div>
                        <div class="event-detail">
                            <div class="date-month">
                                <div class="date">
                                    <?php echo wpems_get_time( 'd' ); ?>
                                </div>
                                <div class="month">
                                    <?php echo wpems_get_time( 'F' ); ?>
                                </div>
                            </div>
                            <div class="content clearfix">
                                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="meta">
                                    <div class="time">
                                        <i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( 'g:i a' ) ); ?> - <?php echo( wpems_event_end( 'g:i a' ) ); ?>
                                    </div>
                                    <?php if ( wpems_event_location() ) { ?>
                                        <div class="location">
                                        <i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="description">
                            <?php echo the_excerpt(); ?>
                        </div>
                        <a class="view-detail" href="<?php the_permalink(); ?>"><?php echo esc_html__('view event','course-builder') ?><i class="ion-ios-arrow-right"></i></a>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
        <?php endif; ?>
    </div>
</div>