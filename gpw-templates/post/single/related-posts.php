<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Post - Related Posts
 */
$categories = get_the_category();
$categoryIDs = wp_list_pluck( $categories, 'term_id' );
$relatedPosts = get_posts( [
  'category__in' => $categoryIDs,
  'post__not_in' => [ get_the_ID() ],
  'posts_per_page' => 3,
  'orderby' => 'rand',
  'post_status' => 'publish',
]);
if( empty( $relatedPosts ) ) {
  return;
}
?>
<section class="related-posts">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?= __('Related Posts', GPW_TEXT_DOMAIN) ?></h2>
    <div class="related-posts__grid">
      <?php foreach( $relatedPosts as $post ) {
        setup_postdata( $post );
        get_template_part( 'gpw-templates/post/post-card', null, [ 'footer_display' => 'meta', 'show_category' => true ] );
      } 
      wp_reset_postdata(); ?>
    </div>
  </div>
</section>