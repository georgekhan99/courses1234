<div class="thim-sc-course-search <?php echo esc_attr( $params['layout'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">

	<?php if ( $params['layout'] == 'popup' ) { ?>
        <div class="toggle-form"><i class="ion-android-search"></i></div><!-- .toggle-form -->
        <div class="form-search-wrapper">
            <div class="background-toggle"></div>
            <form role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
                <input type="text" value="" name="s" placeholder="<?php echo esc_attr( $params['placeholder'] ); ?>" class="form-control courses-search-input" autocomplete="off" />
                <input type="hidden" value="course" name="ref" />
                <button type="submit"><i class="ion-android-search"></i></button>
                <div class="thim-loading-icon">
                    <div class="sk-three-bounce">
                        <div class="sk-child sk-bounce1"></div>
                        <div class="sk-child sk-bounce2"></div>
                        <div class="sk-child sk-bounce3"></div>
                    </div>
                </div>
                <span class="widget-search-close"></span>
                <ul class="courses-list-search list-unstyled"></ul>
            </form>
        </div>

	<?php } else { ?>
        <form role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
            <input type="text" value="" name="s" placeholder="<?php echo esc_attr( $params['placeholder'] ); ?>" class="form-control courses-search-input" autocomplete="off" />
            <input type="hidden" value="course" name="ref" />
            <button type="submit"><i class="ion-android-search"></i></button>
            <div class="thim-loading-icon">
                <div class="sk-three-bounce">
                    <div class="sk-child sk-bounce1"></div>
                    <div class="sk-child sk-bounce2"></div>
                    <div class="sk-child sk-bounce3"></div>
                </div>
            </div>
            <span class="widget-search-close"></span>
        </form>
        <ul class="courses-list-search list-unstyled"></ul>

	<?php } ?>

</div>