<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: POST CATEGORY - Posts grid section
 */
$categories = get_categories([
  'taxonomy' => 'category',
  'hide_empty' => true,
  'orderby' => 'term_id',
  'order' => 'ASC',
]);
rewind_posts();
$maxPages = $wp_query->max_num_pages;
?>
<section class="posts-grid">
  <div class="section__inner">

    <?php if( have_posts() ): ?>

      <?php if( !is_category() ) : ?>

        <nav class="posts-grid__nav">
          <ul class="posts-grid__nav-list">

            <li class="posts-grid__nav-item posts-grid__nav-item--active" data-cat="0"><?php _e( 'All', GPW_TEXT_DOMAIN ) ?></li>

            <?php foreach( $categories as $category ): ?>

            <li class="posts-grid__nav-item" data-cat="<?= esc_attr($category->term_id) ?>">
              
              <?= esc_html( $category->name ) ?>

            </li>

            <?php endforeach ?>

          </ul>
        </nav>

      <?php endif ?>

    <main class="posts-grid__grid">

      <?php while( have_posts() ) {
        the_post();
        get_template_part( 'gpw-templates/post/post-card', null, [ 'show_category' => true, 'footer_display' => 'meta' ] );
      }
      wp_reset_postdata();
      ?>

</main>

<?php if( $maxPages > 1 ): ?>
  <button type="button" class="posts-grid__load-more-btn gpw-button gpw-button__primary gpw-button--center" 
    data-max="<?php esc_attr_e( $maxPages ) ?>" data-cat="<?= is_category() ? get_queried_object_id() : 0 ?>"
  >
    <span class="gpw-button__text"><?php _e( 'Load more', GPW_TEXT_DOMAIN ) ?></span>
  </button>
  <?php endif; ?>
  
  <?php else: ?>
    
    <p class="posts-grid__no-posts-message"><?php esc_html_e( 'No posts found in this category.', GPW_TEXT_DOMAIN ) ?></p>
    
  <?php endif; ?>
    
  <?php get_template_part( 'gpw-templates/post/post-card', null, [ 'is_template' => true, 'show_category' => true, 'footer_display' => 'meta' ] ); ?>
  </div>
</section>