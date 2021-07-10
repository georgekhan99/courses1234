<?php
/**
 * Learnpress Collection Custom post type class.
 *
 * @author   ThimPress
 * @package  LearnPress/Collections/Classes
 * @version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Collection_Post_Type' ) ) {
	/**
	 * Class LP_Collection_Post_Type.
	 */
	final class LP_Collection_Post_Type extends LP_Abstract_Post_Type {

		/**
		 * @var null
		 */
		protected static $_instance = null;

		/**
		 * LP_Collection_Post_Type constructor.
		 *
		 * @param $post_type
		 */
		public function __construct( $post_type ) {
			parent::__construct( $post_type );

			add_filter( 'learn_press_admin_tabs_info', array( $this, 'admin_tabs_info' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'learnpress_collection_select2_enqueue' ) );
			add_action( 'wp_ajax_learnpress_search_course', array( __CLASS__, 'learnpress_search_course' ) );

			add_action( 'add_meta_boxes', array( $this, 'colection_add_meta_box' ) );
		}

		public function colection_add_meta_box() {
			add_meta_box( 'colection_settings', esc_html__( 'General Settings', 'learnpress-collection' ), 'LP_Collections_Meta_Box_Settings::output', 'lp_collection', 'normal', 'high' );
		}

		/**
		 *
		 */
		public static function learnpress_search_course() {
			$return = array();

			// you can use WP_Query, query_posts() or get_posts() here - it doesn't matter
			$search_results = new WP_Query(
				array(
					's'                   => $_GET['q'], // the search query
					'post_status'         => 'publish', // if you don't want drafts to be returned
					'ignore_sticky_posts' => 1,
					'post_type'           => LP_COURSE_CPT,
					'posts_per_page'      => 50, // how much to show at once
				)
			);
			if ( $search_results->have_posts() ) :
				while ( $search_results->have_posts() ) :
					$search_results->the_post();
					// shorten the title a little
					$title    = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
					$return[] = array( $search_results->post->ID, $title ); // array( Post ID, Post Title )
				endwhile;
			endif;
			echo json_encode( $return );
			die;
		}

		/**
		 *
		 */
		public function learnpress_collection_select2_enqueue() {
			// please create also an empty JS file in your theme directory and include it too
			wp_enqueue_script( 'learnpress-collection', plugins_url( '/assets/js/admin-collection.js', LP_ADDON_COLLECTIONS_FILE ), array( 'select2' ) );
		}

		/**
		 * Register collection post type.
		 *
		 * @return array|bool
		 */
		public function register() {
			$labels = array(
				'name'               => _x( 'Collections', 'Post Type General Name', 'learnpress-collections' ),
				'singular_name'      => _x( 'Collection', 'Post Type Singular Name', 'learnpress-collections' ),
				'menu_name'          => __( 'Collections', 'learnpress-collections' ),
				'parent_item_colon'  => __( 'Parent Item:', 'learnpress-collections' ),
				'all_items'          => __( 'Collections', 'learnpress-collections' ),
				'view_item'          => __( 'View Collection', 'learnpress-collections' ),
				'add_new_item'       => __( 'Add New Collection', 'learnpress-collections' ),
				'add_new'            => __( 'Add New', 'learnpress-collections' ),
				'edit_item'          => __( 'Edit Collection', 'learnpress-collections' ),
				'update_item'        => __( 'Update Collection', 'learnpress-collections' ),
				'search_items'       => __( 'Search Collection', 'learnpress-collections' ),
				'not_found'          => __( 'No collection found', 'learnpress-collections' ),
				'not_found_in_trash' => __( 'No collection found in Trash', 'learnpress-collections' ),
			);
			$slug   = LP()->settings->get( 'collections.slug' ) ? LP()->settings->get( 'collections.slug' ) : 'collections';
			$slug   = untrailingslashit( $slug );
			// var_dump( LP()->settings->get( 'collections.slug' ) );
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'has_archive'        => true,
				'capability_type'    => 'lp_order',
				'map_meta_cap'       => true,
				'show_in_menu'       => 'learn_press',
				'show_in_admin_bar'  => true,
				'show_in_nav_menus'  => true,
				'taxonomies'         => array(),
				'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions', 'comments', 'excerpt' ),
				'hierarchical'       => true,
				'rewrite'            => array(
					'slug'         => $slug, // _x( 'collections', 'collections-slug', 'learnpress-collections' ),
					'hierarchical' => true,
					'with_front'   => false,
				),
			);

			add_rewrite_tag( '%collection_page%', '([^&]+)' );
			add_rewrite_rule( '^' . $slug . '/([^/]*)/page/(.*)', 'index.php?lp_collection=$matches[1]&collection_page=$matches[2]', 'top' );

			$x = get_transient( 'learn-press-collection-flush-rewrite-rules' );
			if ( $x && ! is_admin() ) {
				flush_rewrite_rules();
				set_transient( 'learn-press-collection-flush-rewrite-rules', false );
			}
			return $args;
		}

		/**
		 * Add Collection tab into admin archive course page.
		 *
		 * @param $tabs
		 *
		 * @return mixed
		 */
		public function admin_tabs_info( $tabs ) {
			$post_type = filter_input( INPUT_GET, 'post_type' );
			$action    = filter_input( INPUT_GET, 'action' );
			$post      = filter_input( INPUT_GET, 'post' );
			if ( LP_COURSE_CPT == $post_type || $action == 'edit' && LP_COURSE_CPT == get_post_type( $post ) ) {
				$tabs[11] = array(
					'link' => 'edit.php?post_type=lp_collection',
					'name' => __( 'Collections', 'learnpress-collections' ),
					'id'   => 'edit-lp_collection',
				);
			}

			return $tabs;
		}

		/**
		 * Meta box in admin collection editor.
		 */

		/**
		 * Custom column.
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		public function columns_head( $columns ) {
			$columns = array(
				'cb'          => $columns['cb'],
				'title'       => $columns['title'],
				LP_COURSE_CPT => __( 'Courses', 'learnpress-collections' ),
				'comments'    => $columns['comments'],
				'date'        => $columns['date'],
			);

			return $columns;
		}

		/**
		 * Display content for custom column.
		 *
		 * @param $column
		 * @param int    $post_id
		 */
		public function columns_content( $column, $post_id = 0 ) {
			if ( LP_COURSE_CPT == $column ) {
				$ids = get_post_meta( $post_id, '_lp_collection_courses' );
				if ( empty( $ids ) ) {
					_e( 'No Items', 'learnpress-collections' );
				} else {
					foreach ( $ids as $id ) {
						$item = get_post( $id );
						if ( $item ) {
							echo '<a href="' . get_permalink( $item->ID ) . '">' . $item->post_title . '</a> | ';
						}
					}
				}
			}
		}

		/**
		 * Instance.
		 *
		 * @return LP_Collection_Post_Type|null
		 */
		public static function instance() {
			if ( ! self::$_instance ) {
				self::$_instance = new self( LP_COLLECTION_CPT );
			}

			return self::$_instance;
		}
	}
}

$collection_post_type = LP_Collection_Post_Type::instance();
