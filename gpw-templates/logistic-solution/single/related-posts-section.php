<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: SINGLE LOGISTICS SOLUTION - Related posts section
 */
$keyword = get_the_title();
$keyword = '';
$args = [
  'post_type' => 'post',
  's' => $keyword,
  'numberposts' => 6,
  'post_status' => 'publish',
];
$related_posts = get_posts($args);

if (empty($related_posts)) {
  do_action('qm/debug', 'Related posts not found');
  return;
}

$categories = get_categories([
  'taxonomy' => 'category',
  'hide_empty' => true,
  'orderby' => 'term_id',
  'order' => 'ASC',
]);
?>
<section class="related-posts">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?php esc_html_e('Related Posts', GPW_TEXT_DOMAIN); ?></h2>
    <nav class="related-posts__nav">
      <ul class="related-posts__nav-list">

        <li class="related-posts__nav-item related-posts__nav-item--active" data-cat="0">
          <?php _e('All', GPW_TEXT_DOMAIN) ?>
        </li>

        <?php foreach ($categories as $category): ?>

          <li class="related-posts__nav-item" data-cat="<?= esc_attr($category->term_id) ?>">

            <?= esc_html($category->name) ?>

          </li>

        <?php endforeach ?>

      </ul>
    </nav>
    <main class="related-posts__grid">

      <?php foreach ($related_posts as $post) {
        setup_postdata($post);
        get_template_part( 'gpw-templates/post/post-card', null, [ 'show_category' => true, 'footer_display' => 'meta' ] );
      } 
      wp_reset_postdata(); ?>
        
    </main>
    <a href="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>" class="gpw-button gpw-button__primary gpw-button--center related-posts__view-all-btn" role="button">
      <span class="gpw-button__text"><?php esc_html_e( 'View all', GPW_TEXT_DOMAIN ) ?></span>
    </a>
  </div>
</section>