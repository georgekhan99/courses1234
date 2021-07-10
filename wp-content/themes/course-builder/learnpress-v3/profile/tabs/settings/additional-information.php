<?php
/**
 * Template for displaying editing basic information form of user in profile page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/settings/tabs/basic-information.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Profile::instance();

if ( ! isset( $section ) ) {
    $section = 'additional-information';
}

$user = $profile->get_user();
$user_meta = get_user_meta( $user->get_id() );
$user_meta = array_map( function ( $a ) {
    return $a[0];
}, $user_meta );

$phone = ! empty( $user_meta['lp_info_phone'] ) ? $user_meta['lp_info_phone'] : '';
$skype = ! empty( $user_meta['lp_info_skype'] ) ? $user_meta['lp_info_skype'] : '';
$gg    = ! empty( $user_meta['lp_info_google_plus'] ) ? $user_meta['lp_info_google_plus'] : '';
$fb    = ! empty( $user_meta['lp_info_facebook'] ) ? $user_meta['lp_info_facebook'] : '';
$tt    = ! empty( $user_meta['lp_info_twitter'] ) ? $user_meta['lp_info_twitter'] : '';
$pt    = ! empty( $user_meta['lp_info_pinterest'] ) ? $user_meta['lp_info_pinterest'] : '';
$lk   = ! empty( $user_meta['lp_info_linkedin'] ) ? $user_meta['lp_info_linkedin'] : '';
$in    = ! empty( $user_meta['lp_info_instagram'] ) ? $user_meta['lp_info_instagram'] : '';

?>

<form method="post" id="your-profile" name="profile-basic-information"
      enctype="multipart/form-data" class="learn-press-form">

    <div class="learn-press-subtab-content content50">
        <?php
        /**
         * @since 3.0.0
         */
        do_action( 'learn-press/before-profile-basic-information-fields', $profile );

        ?>
        <ul class="lp-form-field-wrap">

            <?php
            /**
             * @since 3.0.0
             */
            do_action( 'learn-press/begin-profile-basic-information-fields', $profile );

            // @deprecated
            do_action( 'learn_press_before_' . $section . '_edit_fields' );
            ?>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_phone"><?php esc_html_e( 'Phone Number', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_phone" id="lp_info_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
                </div>
            </li>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_skype"><?php esc_html_e( 'Skype', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_skype" id="lp_info_skype" value="<?php echo esc_attr( $skype ); ?>" class="regular-text">
                </div>
            </li>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_google_plus"><?php esc_html_e( 'Google Plus URL', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_google_plus" id="lp_info_google_plus" value="<?php echo esc_attr( $gg ); ?>" class="regular-text">
                </div>
            </li>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_facebook"><?php esc_html_e( 'Facebook URL', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_facebook" id="lp_info_facebook" value="<?php echo esc_attr( $fb ); ?>" class="regular-text">
                </div>
            </li>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_twitter"><?php esc_html_e( 'Twitter URL', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_twitter" id="lp_info_twitter" value="<?php echo esc_attr( $tt ); ?>" class="regular-text">
                </div>
            </li>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_pinterest"><?php esc_html_e( 'Pinterest URL', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_pinterest" id="lp_info_pinterest" value="<?php echo esc_attr( $pt ); ?>" class="regular-text">
                </div>
            </li>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_linkedin"><?php esc_html_e( 'Linkedin URL', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_linkedin" id="lp_info_linkedin" value="<?php echo esc_attr( $lk ); ?>" class="regular-text">
                </div>
            </li>

            <li class="lp-form-field">
                <label class="lp-form-field-label" for="lp_info_instagram"><?php esc_html_e( 'Instagram URL', 'course-builder' ); ?></label>
                <div class="lp-form-field-input">
                    <input type="text" name="lp_info_instagram" id="lp_info_instagram" value="<?php echo esc_attr( $in ); ?>" class="regular-text">
                </div>
            </li>

            <?php
            // @deprecated
            do_action( 'learn_press_after_' . $section . '_edit_fields' );

            /**
             * @since 3.0.0
             */
            do_action( 'learn-press/end-profile-basic-information-fields', $profile );

            ?>
        </ul>

        <?php
        /**
         * @since 3.0.0
         */
        do_action( 'learn-press/after-profile-basic-information-fields', $profile );
        ?>

        <p>
            <input type="hidden" name="save-profile-basic-information"
                   value="<?php echo wp_create_nonce( 'learn-press-save-profile-basic-information' ); ?>"/>
        </p>

        <button type="submit" name="submit"><?php _e( 'Save changes', 'course-builder' ); ?></button>
    </div>

</form>