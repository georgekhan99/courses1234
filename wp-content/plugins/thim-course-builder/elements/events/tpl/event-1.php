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
<div class="thim-sc-events events-layer-1 <?php echo esc_attr( $params['el_class'] ); ?> " data-cols="1">
    <div class="sc-title">
        <?php echo esc_html__( 'events', 'course-builder' ) ?>
    </div>
    <div class="event-wrapper owl-carousel owl-theme">
        <?php if ( $params['query']->have_posts() ) : ?>
            <?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
                <div class="events">
                    <div class="events-before">
                        <div class="title-date">
                            <div class="date">
                                <span class="date-start"><?php echo( wpems_event_end( 'd' ) ); ?></span>
                                <span class="month-year-start"><?php echo( wpems_event_end( 'M / Y' ) ); ?></span>
                            </div>
                        </div>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="thumbnail">
                                <a href="<?php the_permalink() ?>"><?php thim_thumbnail( get_the_ID(), '465x389', 'post', false ); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="events-after">
                        <div class="content">
                            <div class="content-inner">
                                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="time-location">
                                <span class="time">
                                    <i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( 'g:i a' ) ); ?> - <?php echo( wpems_event_end( 'g:i a' ) ); ?>
                                </span>
                                    <?php if ( wpems_event_location() ) { ?>
                                        <span class="location">
                                        <i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
                                    </span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
        <?php endif; ?>
    </div>
</div>