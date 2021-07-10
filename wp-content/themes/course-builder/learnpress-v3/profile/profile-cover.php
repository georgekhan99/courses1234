<?php
/**
 * Template for displaying user profile cover image.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/profile/profile-cover.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Profile::instance();

$user = $profile->get_user();
$custom_img   = $user->get_upload_profile_src();
$gravatar_img = $user->get_profile_picture( 'gravatar' );
$user_meta = get_user_meta( $user->get_id() );
$user_meta = array_map( function ( $a ) {
    return $a[0];
}, $user_meta );


?>

<div class="user-info">

    <div class="author-avatar">
        <?php if ( $custom_img ) { ?>
            <img src="<?php echo $custom_img; ?>"/>
        <?php } else { ?>
            <?php echo $gravatar_img; ?>
        <?php } ?>
    </div>

    <div class="user-information">

        <?php thim_get_user_socials($user_meta); ?>
        
        <h3 class="author-name"><?php echo learn_press_get_profile_display_name( $user ); ?></h3>

        <ul class="list-contact">
            <?php if ( ! empty( $user_meta['lp_info_phone'] ) ): ?>
                <li><a href="tel:<?php echo esc_attr( $user_meta['lp_info_phone'] ); ?>"><?php echo esc_html( $user_meta['lp_info_phone'] ); ?></a></li>
            <?php endif; ?>

            <li><a href="mailto:<?php echo esc_attr( $user->get_email() ); ?>"><?php echo esc_html( $user->get_email() ); ?></a></li>
        </ul>

        <p class="description"><?php echo  wp_trim_words(get_user_meta( $user->get_id(), 'description', true ), 15, '...'); ?></p>

    </div>
</div>


