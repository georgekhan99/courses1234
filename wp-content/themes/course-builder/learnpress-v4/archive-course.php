<?php
/**
 * Template for displaying archive course content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-archive-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post, $wp_query, $lp_tax_query, $wp_query;

$total = $wp_query->found_posts;

if ( $total == 0 ) {
    $message = '<p class="message message-error">' . esc_html__( 'No courses found!', 'course-builder' ) . '</p>';
    $index   = esc_html__( 'There are no available courses!', 'course-builder' );
} elseif ( $total == 1 ) {
    $index = esc_html__( 'Showing only one result', 'course-builder' );
} else {
    $courses_per_page = absint( LP()->settings->get( 'archive_course_limit' ) );
    $paged            = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

    $from = 1 + ( $paged - 1 ) * $courses_per_page;
    $to   = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;

    if ( $from == $to ) {
        $index = sprintf(
            esc_html__( 'Showing last course of %s results', 'course-builder' ),
            $total
        );
    } else {
        $index = sprintf(
            esc_html__( 'Showing %s-%s of %s results', 'course-builder' ),
            $from,
            $to,
            $total
        );
    }
}

//$courses_layout = get_theme_mod( 'learnpress_cate_style' ) ? get_theme_mod( 'learnpress_cate_style' ) : 'grid';
$cookie_name = 'course_switch';
//grid-layout

$courses_layout = get_theme_mod( 'learnpress_cate_style', true );
if($courses_layout == 'list'){
    $set_layout = 'course-list';
}else{
    $set_layout = 'course-grid';
}
$layout  = ( ! empty( $_COOKIE[ $cookie_name ] ) ) ? $_COOKIE[ $cookie_name ] : '';

//$has_param      = '';
//if ( isset( $_GET['layout'] ) && $_GET['layout'] != '' ) {
//	$courses_layout = $_GET['layout'];
//	$has_param      = 'has-layout';
//}
//
//$courses_layout      = ( ! empty( $_COOKIE[ $cookie_name ] ) ) ? $_COOKIE[ $cookie_name ] : $courses_layout;

/**
 * @since 4.0.0
 */
do_action( 'learn-press/before-main-content' );

do_action( 'lp/template/archive-course/description' );

$default_order = apply_filters( 'thim_default_order_course_option', array(
    'newly-published' => esc_html__( 'Newly published', 'course-builder' ),
    'alphabetical'    => esc_html__( 'Alphabetical', 'course-builder' ),
    'most-members'    => esc_html__( 'Most members', 'course-builder' )
) );

?>

    <div class="thim-course-top">
        <div class="thim-course-switch-layout switch-layout lpr_course-switch">
            <a href="#" class="list switchToGrid<?php echo ( $layout == 'grid-layout' ) ? ' switcher-active' : ''; ?>"><i class="fa fa-th-large"></i></a>
            <a href="#" class="grid switchToList<?php echo ( $layout == 'list-layout' ) ? ' switcher-active' : ''; ?>"><i class="fa fa-list-ul"></i></a>
        </div>

        <div class="course-index">
            <span><?php echo( $index ); ?></span>
        </div>

        <?php if ( get_theme_mod( 'learnpress_display_course_sort', true ) ): ?>
            <div class="thim-course-order">
                <select name="orderby">
                    <?php
                    foreach ( $default_order as $k => $v ) {
                        echo '<option value="' . esc_attr( $k ) . '">' . ( $v ) . '</option>';
                    }
                    ?>
                </select>
            </div>

        <?php endif; ?>

        <div class="courses-searching">
            <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
                <input type="text" value="" name="s" placeholder="<?php esc_attr_e( 'Search our courses', 'course-builder' ) ?>" class="form-control course-search-filter" autocomplete="off" />
                <input type="hidden" value="course" name="ref" />
                <input type="hidden" name="post_type" value="lp_course">
                <button type="submit"><i class="ion-android-search"></i></button>
                <span class="widget-search-close"></span>
            </form>
            <ul class="courses-list-search list-unstyled"></ul>
        </div>
    </div>

<div class="archive-courses <?php if(!empty($layout)){
    echo ($layout == 'list-layout')?'course-list':'course-grid';
}else{echo $set_layout; } ?>" data-cookie="grid-layout"  data-attr = "<?= $set_layout;?>">

    <?php if ( have_posts() ) :
        ?>

            <?php LP()->template( 'course' )->begin_courses_loop();

            while ( have_posts() ) : the_post();

                learn_press_get_template_part( 'content', 'course' );

            endwhile;

            LP()->template( 'course' )->end_courses_loop();
            ?>

        <?php
        

        /**
         * @deprecated
         */
        do_action( 'learn-press/after-courses-loop' );

        wp_reset_postdata(); ?>

    <?php else: ?>
        <p class="message message-error"><?php esc_html_e( 'No courses found!', 'course-builder' ); ?></p>
    <?php endif; ?>

    <?php thim_loading_icon(); ?>

</div>

<?php /**
 * @since 4.0.0
 */
//do_action( 'learn-press/after-main-content' );
