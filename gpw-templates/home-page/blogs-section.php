<?php
/**
 * @author Hieu "JIN" Phan Trung
 * * Template: Home page - Blogs section
 */
const BLOGS_TERM_ID = 1;
$sectionData = get_field('blogs', get_the_ID());
$posts = get_posts([
  'post_type' => 'post',
  'numberposts' => 3,
  'post_status' => 'publish',
]);
if (empty($posts)) {
  error_log('BLOGS SECTION - Don\'t have posts data!!');
  return;
}
$slideItems = [];
foreach ($posts as $post) {
  setup_postdata($post);
  ob_start();
  get_template_part('gpw-templates/post/post-card');
  $slideItems[] = ob_get_clean();
}
wp_reset_postdata();
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

    <div class="blogs__post-grid">

      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems, 'has_scrollbar' => true ]) ?>

    </div>

    <?php if (!empty($sectionData['button_label'])) {
      get_template_part('gpw-templates/global/gpw-button', null, [
        'label' => $sectionData['button_label'],
        'url' => get_term_link(BLOGS_TERM_ID, 'category'),
        'style' => 'secondary',
        'position' => 'center',
      ]);
    } ?>

  </div>
</section>
<?php
// ! Cleanup variables
unset($sectionData, $posts);