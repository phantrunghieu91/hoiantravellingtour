<?php
/**
 * @author Hieu "JIN" Phan Trung
 * * Template: Home page - Blogs section
 */
$frontPageId = get_option('page_on_front');
$sectionData = get_field('blogs', $frontPageId);
$args = [
  'post_type' => 'post',
  'numberposts' => 6,
  'post_status' => 'publish',
];

$posts = [];
$addedPostIds = [];

$categories = get_categories([
  'taxonomy' => 'category',
  'hide_empty' => true,
  'orderby' => 'term_id',
  'order' => 'ASC',
]);

foreach( $categories as $category ) {
  $cat_posts = get_posts( array_merge( $args, [
    'category' => $category->term_id,
  ] ) );
  foreach( $cat_posts as $post ) {
    if( !in_array( $post->ID, $addedPostIds ) ) {
      $posts[] = $post;
      $addedPostIds[] = $post->ID;
    }
  }
}

if (empty($posts)) {
  error_log('BLOGS SECTION - Don\'t have posts data!!');
  return;
}
?>
<section class="blogs">
  <div class="section__inner">
    <?php if (!empty($sectionData['sub_title'])): ?>

      <span class="section__sub-title section__sub-title--center"><?php esc_html_e($sectionData['sub_title']) ?></span>

    <?php endif;
    if (!empty($sectionData['title'])): ?>

      <h2 class="section__title section__title--center">
        <?= wp_kses_post($sectionData['title']) ?>
      </h2>

    <?php endif;
    if (!empty($sectionData['description'])): ?>

      <div class="section__description section__description--center">
        <?= wp_kses_post($sectionData['description']) ?>
      </div>

    <?php endif; ?>

    <nav class="blogs__nav">
      <ul class="blogs__nav-list">

        <li class="blogs__nav-item blogs__nav-item--active" data-cat="0">
          <?php _e('All', GPW_TEXT_DOMAIN) ?>
        </li>

        <?php foreach ($categories as $category): ?>

          <li class="blogs__nav-item" data-cat="<?= esc_attr($category->term_id) ?>">

            <?= esc_html($category->name) ?>

          </li>

        <?php endforeach ?>

      </ul>
    </nav>

    <main class="blogs__grid">

      <?php foreach ($posts as $idx => $post) {
        setup_postdata($post);
        get_template_part( 'gpw-templates/post/post-card', null, [ 'show_category' => true, 'footer_display' => 'meta', 'is_hidden' => $idx > 5 ] );
      } 
      wp_reset_postdata(); ?>

    </main>

    <?php if (!empty($sectionData['button_label'])) {
      get_template_part('gpw-templates/global/gpw-button', null, [
        'class' => 'blogs__view-all-btn',
        'label' => $sectionData['button_label'],
        'url' => get_permalink( get_option( 'page_for_posts' ) ),
        'style' => 'primary',
        'position' => 'center',
      ]);
    } ?>

  </div>
</section>
<?php
// ! Cleanup variables
unset($sectionData, $posts, $addedPostIds, $categories);