<?php
/**
 * LearnPress Collections Metabox
 * Use in LP4.
 */
class LP_Collections_Meta_Box_Settings {

	public static function output( $post ) {
		$appended_courses = array();
		$post_id          = LP_Request::get_int( 'post' );
		$course_chosen    = array( 0 => '' );

		if ( $post_id ) {
			$appended_courses = get_post_meta( $post_id, '_lp_collection_courses', false );
			if ( count( $appended_courses ) ) {
				foreach ( $appended_courses as $course ) {
					$course_chosen[ $course ] = get_the_title( $course );
				}
			}
		}
		wp_nonce_field( 'learnpress_save_meta_box', 'learnpress_meta_box_nonce' );
		?>

		<div class="lp-meta-box lp-meta-box--collectionss">
			<div class="lp-meta-box__inner">
				<?php
				do_action( 'learnpress/collections-settings/before' );

				lp_meta_box_select_field(
					array(
						'id'            => '_lp_collection_courses',
						'label'         => esc_html__( 'Courses', 'learnpress-collections' ),
						'description'   => esc_html__( 'Collecting related courses into one collection.', 'learnpress-collections' ),
						'desc_tip'      => false,
						'multiple'      => true,
						'value'         => $appended_courses,
						'options'       => $course_chosen,
						'style'         => 'width:300px',
						'type'          => 'select',
						'wrapper_class' => 'lp-select-2',
						'default'       => '',
					)
				);
				lp_meta_box_text_input_field(
					array(
						'id'          => '_lp_collection_courses_per_page',
						'label'       => esc_html__( 'Courses per page', 'learnpress-collections' ),
						'description' => esc_html__( 'Number of courses per each page. Default is 10.', 'learnpress-collections' ),
						'default'     => '10',
						'type'        => 'text',
						'type_input'  => 'number',
					)
				);

				do_action( 'learnpress/collections-settings/after' );
				?>
			</div>
		</div>

		<?php
	}

	public static function save( $post_id ) {
			$new_courses = isset( $_POST['_lp_collection_courses'] ) ? (array) wp_unslash( $_POST['_lp_collection_courses'] ) : array();
			$old_courses = get_post_meta( $post_id, '_lp_collection_courses', false ) ? get_post_meta( $post_id, '_lp_collection_courses', false ) : array();
			$added       = array_diff( $new_courses, $old_courses );
			$removed     = array_diff( $old_courses, $new_courses );

		if ( $added ) {
			foreach ( $added as $course ) {
				add_post_meta( $post_id, '_lp_collection_courses', $course, false );

				$collections = get_post_meta( $course, '_lp_course_collections', false );
				if ( ! in_array( $post_id, $collections ) ) {
					add_post_meta( $course, '_lp_course_collections', $post_id );
				}
			}
		}

		if ( $removed ) {
			foreach ( $removed as $course ) {
				delete_post_meta( $post_id, '_lp_collection_courses', $course );

				$collections = get_post_meta( $course, '_lp_course_collections', false );
				if ( in_array( $post_id, $collections ) ) {
					delete_post_meta( $course, '_lp_course_collections', $post_id );
				}
			}
		}

		$course_pp = isset( $_POST['_lp_collection_courses_per_page'] ) ? absint( wp_unslash( $_POST['_lp_collection_courses_per_page'] ) ) : 0;
		update_post_meta( $post_id, '_lp_collection_courses_per_page', $course_pp );

	}
}

add_action( 'learnpress_save_lp_collection_metabox', 'LP_Collections_Meta_Box_Settings::save' );
