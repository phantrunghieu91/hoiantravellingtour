<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: SINGLE LOGISTICS SOLUTION - Related posts section
 */
$keyword = isset( $args['keyword'] ) ? sanitize_text_field( $args['keyword'] ) : get_the_title();
$postQueryArgs = [
  'post_type' => 'post',
  's' => $keyword,
  'numberposts' => 6,
  'post_status' => 'publish',
];

$relatedPosts = [];
$addedPostIds = [];

$categories = get_categories([
  'taxonomy' => 'category',
  'hide_empty' => true,
  'orderby' => 'term_id',
  'order' => 'ASC',
]);

$categoriesPostsCount = [];

foreach( $categories as $category ) {
  $catPosts = get_posts( array_merge( $postQueryArgs, [
    'category' => $category->term_id,
  ] ) );
  $categoriesPostsCount[ $category->term_id ] = count( $catPosts );
  foreach( $catPosts as $post ) {
    if( !in_array( $post->ID, $addedPostIds ) ) {
      $relatedPosts[] = $post;
      $addedPostIds[] = $post->ID;
    }
  }
}

if (empty($relatedPosts)) {
  do_action('qm/debug', 'Related posts not found');
  return;
}
?>
<section class="related-posts">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?php esc_html_e('Related Posts', 'gpw'); ?></h2>
    <nav class="related-posts__nav">
      <ul class="related-posts__nav-list">

        <li class="related-posts__nav-item related-posts__nav-item--active" data-cat="0">
          <?php _e('All', 'gpw') ?>
        </li>

        <?php foreach ($categories as $category):
          if( $categoriesPostsCount[ $category->term_id ] === 0 ) {
            continue;
          }
        ?>

          <li class="related-posts__nav-item" data-cat="<?= esc_attr($category->term_id) ?>">

            <?= esc_html($category->name) ?>

          </li>

        <?php endforeach ?>

      </ul>
    </nav>
    <main class="related-posts__grid">

      <?php foreach ($relatedPosts as $idx => $post) {
        setup_postdata($post);
        get_template_part( 'gpw-templates/post/post-card', null, [ 'show_category' => true, 'footer_display' => 'meta', 'is_hidden' => $idx > 5 ] );
      } 
      wp_reset_postdata(); ?>
        
    </main>
    <a href="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>" class="gpw-button gpw-button__primary gpw-button--center related-posts__view-all-btn" role="button">
      <span class="gpw-button__text"><?php esc_html_e( 'View all', 'gpw' ) ?></span>
    </a>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $postQueryArgs, $relatedPosts, $addedPostIds, $categories, $categoriesPostsCount );