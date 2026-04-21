<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Related posts section
 */
$sectionData = get_field( 'related_posts', get_the_ID() );
if( empty( $sectionData['categories' ] ) ) {
  do_action('qm/debug', 'Please select categories for related posts!');
  return;
}
$defaultQuery = [
  'post_type' => 'post',
  'numberposts' => 6,
  'post_status' => 'publish',
];
$relatedPosts = [];
$addedPostIds = [];
foreach( $sectionData['categories'] as $catId ) {
  $query = array_merge( $defaultQuery, [ 'category' => $catId ] );
  $posts = get_posts( $query );
  if( empty( $posts ) ) {
    continue;
  }
  foreach( $posts as $post ) {
    if( !in_array( $post->ID, $addedPostIds ) ) {
      $relatedPosts[] = $post;
      $addedPostIds[] = $post->ID;
    }
  }
}
?>
<section class="related-posts">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?= esc_html( $sectionData['title'] ) ?></h2>
    <nav class="related-posts__nav">
      <ul class="related-posts__nav-list">

        <li class="related-posts__nav-item related-posts__nav-item--active" data-cat="0">
          <?php _e('All', 'gpw') ?>
        </li>

        <?php foreach ($sectionData['categories'] as $catID):
          $category = get_category( $catID );
          if( $category->count === 0 ) {
            continue;
          }
        ?>

          <li class="related-posts__nav-item" data-cat="<?= esc_attr($catID) ?>">

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