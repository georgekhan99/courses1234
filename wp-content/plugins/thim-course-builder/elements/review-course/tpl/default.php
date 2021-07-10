<?php
$course        = new LP_Course( intval( $params['id_course'] ) );
$reviews       = '';
$course_review = learn_press_get_course_review( $course->id, isset( $_REQUEST['paged'] ) ? $_REQUEST['paged'] : 1, $params['number_review'], true );
$reviews       = $course_review['reviews'];
?>
<div class="thim-sc-review-course <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( ! empty( $reviews ) ): ?>
        <ul class="course-reviews-list">
			<?php foreach ( $reviews as $review ) : ?>
                <li class="sub-review">
                    <div class="review-container">
                        <div class="review-star">
							<?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $review->rate ) ); ?>
                        </div>
                        <h4 class="author-name">
                            <a href="<?php echo esc_url( learn_press_user_profile_link( $review->ID ) ); ?>">
								<?php echo esc_html( $review->display_name ); ?>
                            </a>
                        </h4>
                        <p class="description"><?php echo esc_html( $review->content ); ?></p>
                    </div>
                </li>
			<?php endforeach; ?>
        </ul>
		<?php
		if ( $params['read_more'] == 'yes' ): ?>
            <div class="read-more-link">
                <a class="read-more" href="<?php echo esc_url( add_query_arg( 'tab', 'reviews', get_the_permalink( $course->id ) ) . '#course-reviews' ); ?>" target="_blank">
					<?php echo esc_html__( 'Read More', 'course-builder' ) ?>
                </a>
            </div>
		<?php endif; ?>
	<?php endif; ?>
</div>