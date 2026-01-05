<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Controller: PostController
 * Controllers related to posts
 */
namespace gpweb\inc\controller;
class PostController {
  private static PostController $instance;
  private $getPostsAction = 'gpw_get_posts';
  public static function getInstance(): PostController {
    if( !isset( self::$instance ) ) {
      self::$instance = new PostController();
    }
    return self::$instance;
  }
  public function register() {
    add_action( "wp_ajax_{$this->getPostsAction}", [ $this, 'handleGetPosts' ] );
    add_action( "wp_ajax_nopriv_{$this->getPostsAction}", [ $this, 'handleGetPosts' ] );
  }
  public function handleGetPosts() {
    if( ! check_ajax_referer( $this->getPostsAction, 'nonce', false ) ) {
      wp_send_json_error( [ 'message' => 'Invalid nonce' ], 400 );
      wp_die();
    }  
    $categoryID = isset( $_POST['category_id'] ) ? intval( $_POST['category_id'] ) : 0;
    $paged = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
    $postsPerPage = get_option( 'posts_per_page', 9 );
    $args = [
      'post_type' => 'post',
      'posts_per_page' => $postsPerPage,
      'paged' => $paged,
    ];
    if( $categoryID > 0 ) {
      $args['cat'] = $categoryID;
    }
    $query = new \WP_Query( $args );

    if( !$query->have_posts() ) {
      wp_send_json_error( [ 'message' => 'No posts found' ], 404 );
      wp_die();
    }

    $responseData = [];
    foreach( $query->posts as $post ) {
      $categories = get_the_category( $post->ID );
      $primaryCat = get_post_meta( $post->ID, 'rank_math_primary_category', true );
      $primaryCat = !empty($primaryCat) ? get_term( $primaryCat ) : $categories[0];

      $data = [
        'id' => $post->ID,
        'title' => get_the_title( $post ),
        'permalink' => get_permalink( $post ),
        'excerpt' => get_the_excerpt( $post ),
        'featured_image_url' => get_the_post_thumbnail_url( $post, 'medium_large' ) ?: wp_get_attachment_image_url( PLACEHOLDER_IMAGE_ID, 'medium_large' ),
        'author' => get_the_author_meta( 'display_name', $post->post_author ),
        'publish_date' => get_the_date( 'F j, Y', $post ),
        'category_ids' => implode(',', wp_list_pluck( $categories, 'term_id' )),
        'primary_category' => [ 'id' => $primaryCat->term_id, 'name' => $primaryCat->name, 'permalink' => get_category_link( $primaryCat->term_id ) ],
      ];
      $responseData[] = $data;
    }
    wp_send_json_success( $responseData );
    wp_die();
  }
  public function getAction() {
    return $this->getPostsAction;
  }
}