<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: POST CATEGORY - Posts grid section
 */
rewind_posts();
if( !have_posts() ) : ?>
  <p class="posts-grid__no-posts-message"><?php esc_html_e( 'No posts found in this category.', 'gpw' ) ?></p>
<?php
endif;

$categories = get_categories( [
  'taxonomy'   => 'category',
  'hide_empty' => true,
  'orderby'    => 'term_id',
  'order'      => 'ASC',
] );
$maxPages     = $wp_query->max_num_pages;
$postsPerPage = get_option( 'posts_per_page', 9 );

$mainQueryPostIds = [];
$preloadedPosts   = [];
$preloadedPostIds = [];

while( have_posts() ) {
  the_post();
  $preloadedPosts[]   = get_post();
  $mainQueryPostIds[] = get_the_ID();
  $preloadedPostIds[] = get_the_ID();
}
if( is_home() ) {
  $preloadedQueryDefaultArgs = [
    'numberposts' => $postsPerPage,
    'post_status' => 'publish',
    'exclude'     => $mainQueryPostIds,
  ];

  foreach( $categories as $category ) {
    $preloadedQueryArgs = $preloadedQueryDefaultArgs + [ 'category' => $category->term_id ];
    $queryPosts         = get_posts( $preloadedQueryArgs );
    foreach( $queryPosts as $p ) {
      $preloadedPosts[]   = $p;
      $preloadedPostIds[] = $p->ID;
    }
  }

  $remainingCount = $wp_query->found_posts - count( $preloadedPostIds );
  $maxPages       = max( 1 , ceil( $remainingCount / $postsPerPage ) );
}
?>
<section class="posts-grid">
  <div class="section__inner">

    <?php if( have_posts() ): ?>

      <?php if( !is_category() ) : ?>

        <nav class="posts-grid__nav">
          <ul class="posts-grid__nav-list">

            <li class="posts-grid__nav-item posts-grid__nav-item--active" data-cat="0"><?php _e( 'All', 'gpw' ) ?></li>

            <?php foreach( $categories as $category ): ?>

            <li class="posts-grid__nav-item" data-cat="<?= esc_attr( $category->term_id ) ?>">
              
              <?= esc_html( $category->name ) ?>

            </li>

            <?php endforeach ?>

          </ul>
        </nav>

      <?php endif ?>

      <main class="posts-grid__grid">

        <?php foreach( $preloadedPosts as $post ) {
          setup_postdata( $post );
          get_template_part( 'gpw-templates/post/post-card', null, [ 'show_category' => true, 'footer_display' => 'meta' ] );
        } ?>
        <?php wp_reset_postdata(); ?>

      </main>

      <?php if( $maxPages > 1 ): ?>
        <button type="button" class="posts-grid__load-more-btn gpw-button gpw-button__primary gpw-button--center" 
          data-max="<?php esc_attr_e( $maxPages ) ?>" data-cat="<?= is_category() ? get_queried_object_id() : 0 ?>"
          data-exclude="<?= esc_attr( json_encode( $preloadedPostIds ) ) ?>"
        >
          <span class="gpw-button__text"><?php _e( 'Load more', 'gpw' ) ?></span>
        </button>
      <?php endif; ?>
  
    <?php endif; ?>
    
  <?php get_template_part( 'gpw-templates/post/post-card', null, [ 'is_template' => true, 'show_category' => true, 'footer_display' => 'meta' ] ); ?>
  </div>
</section>