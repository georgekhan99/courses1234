<?php
$number_posts = !empty( $params['number_post'] ) ? $params['number_post'] : 1;

if ( $params['layout'] == 'layout-1' ) {
    $args = array(
        'post_type'      => 'post',
        'p'              => $params['id_post'],
        'posts_per_page' => 1,
    );
} else {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $number_posts,
    );

    if ( $params['cat_post'] ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => array( $params['cat_post'] ),
            ),
        );
    }
}

$posts = new WP_Query( $args );

if ( $params['layout'] == 'layout-1' ) {
    $params['column'] = 3;
}

$params['query'] = $posts;


$col = 12 / $params['column']; ?>
<div class="thim-sc-new-post <?php echo esc_attr( $params['el_class'] ); ?> <?php echo esc_attr( $params['layout'] ); ?> <?php echo esc_attr( $params['featured_align'] ); ?>">
    <?php if ( $params['layout'] == 'layout-1' ) { ?>
        <?php if ( $params['query']->have_posts() ) : ?>
            <?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
                <?php if ( $params['featured_align'] == 'layout-left' ) { ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="thumbnail">
                            <?php thim_thumbnail( get_the_ID(), '426x426', 'post', true ); ?>
                            <?php
                            $id_icon_image = isset( $params['icon_upload']['id'] ) ? intval( $params['icon_upload']['id'] ) : intval( $params['icon_upload'] );
                            if ( $id_icon_image ) {
                                $icon_upload = wp_get_attachment_image_src( $id_icon_image, 'full' );
                                $icon        = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="">';
                                echo $icon;
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="content">
                        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <p class="description">
                            <?php echo wp_trim_words( get_the_content(), 35, '...' ); ?>
                        </p>
                        <a class="view_more" href="<?php the_permalink(); ?>"><?php echo $params['text_button']; ?></a>
                    </div>
                <?php } else { ?>
                    <div class="content">
                        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <p class="description">
                            <?php echo wp_trim_words( get_the_content(), 35, '...' ); ?>
                        </p>
                        <a class="view_more" href="<?php the_permalink(); ?>"><?php echo $params['text_button']; ?></a>
                    </div>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="thumbnail">
                            <?php thim_thumbnail( get_the_ID(), '426x426', 'post', true ); ?>
                            <?php
                            $id_icon_image = isset( $params['icon_upload']['id'] ) ? intval( $params['icon_upload']['id'] ) : intval( $params['icon_upload'] );
                            if($id_icon_image){
                                $icon_upload   = wp_get_attachment_image_src( $id_icon_image, 'full' );
                                $icon          = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="">';
                                echo $icon;
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                <?php } ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
        <?php endif; ?>
    <?php } elseif ( $params['layout'] == 'layout-2' ) { ?>
        <div class="row">
            <?php if ( $params['query']->have_posts() ) : ?>
                <?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
                    <div class="col-md-<?php echo $col; ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="thumbnail">
                                <?php thim_thumbnail( get_the_ID(), '360x280', 'post', true ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="content">
                            <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <p class="description">
                                <?php echo wp_trim_words( get_the_content(), 20, '...' ); ?>
                            </p>
                            <a class="view_more"
                               href="<?php the_permalink(); ?>"><?php echo $params['text_button']; ?></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
            <?php endif; ?>
        </div>
    <?php } else { ?>
        <div class="row">
            <?php if ( $params['query']->have_posts() ) : ?>
                <?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
                    <div class="col-md-<?php echo $col; ?>">
                        <div class="wrapper">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="thumbnail">
                                    <?php thim_thumbnail( get_the_ID(), '302x212', 'post', true ); ?>
                                </div>
                            <?php endif; ?>
                            <div class="content">
                                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="info">
                                    <div class="author">
                                        <i class="ion-android-person"></i>
                                        <?php echo '<span>' . esc_html( get_the_author() ) . '</span>'; ?>
                                    </div>
                                    <div class="comment">
                                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                        <?php echo get_comments_number(); ?>
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
    <?php } ?>
</div>
