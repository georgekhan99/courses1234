<?php
/**
 * Template Name: Home Page - No Header Footer
 *
 **/
?><!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action( 'thim_before_body' ); ?>

<div id="wrapper-container" <?php thim_wrapper_container_class(); ?>>

    <div class="overlay-close-menu"></div>

    <nav class="visible-xs mobile-menu-container mobile-effect" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <?php

        get_template_part( 'templates/header/mobile-menu' ); ?>

    </nav><!-- nav.mobile-menu-container -->

    <div id="main-content">
        <div id="home-main-content-2" class="home-content home-page container" role="main">
            <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </div><!-- #home-main-content -->
    </div><!-- #main-content -->

        <?php if ( is_active_sidebar( 'after_main' ) ) : ?>
        <div class="after-main">
            <div class="container">
                <?php thim_footer_after_main_widgets(); ?>
            </div>
        </div>
<?php endif; ?>

</div><!-- wrapper-container -->

<?php do_action( 'thim_space_body' ); ?>
<?php wp_footer(); ?>
</body>
</html>

