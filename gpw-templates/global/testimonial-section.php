<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Testimonial Section
 */
$sectionData = get_field('testimonial', 'gpw_settings');
if (empty($sectionData['feedback'])) {
  error_log('TESTIMONIAL SECTION - Don\'t have feedback data!!');
  return;
}
foreach ($sectionData['feedback'] as $feedback):
  $avatarID = $feedback['avatar'] ?: PLACEHOLDER_IMAGE_ID;
  $name = $feedback['name'] ?: '';
  $position = $feedback['position'] ?: '';
  $company = $feedback['company'] ?: '';
  if (empty($name)) {
    continue;
  }
  ob_start();
  ?>
  <article class="testimonial">
    <div class="testimonial__info">
      <?= wp_get_attachment_image($avatarID, 'thumbnail', false, ['class' => 'testimonial__avatar', 'alt' => "$name's avatar"]) ?>
      <h3 class="testimonial__name"><?= esc_html($name) ?></h3>

      <?php if (!empty($position)): ?>

        <p class="testimonial__meta">
          <span class="testimonial__position"><?= esc_html($position) ?></span>

          <?php if (!empty($company)): ?>

            <span class="separator"> - </span>
            <span class="testimonial__company"><?= esc_html($company) ?></span>

          <?php endif ?>
        </p>

      <?php endif ?>
    </div>
    <div class="testimonial__content"><?= wp_kses_post($feedback['content']) ?></div>
  </article>
  <?php
  $slideItems[] = ob_get_clean();
endforeach;
?>
<section class="testimonials">
  <div class="section__inner">
    <?php if (!empty($sectionData['sub_title'])): ?>

      <span class="section__sub-title section__sub-title--center"><?php esc_html_e($sectionData['sub_title']) ?></span>

    <?php endif;
    if (!empty($sectionData['title'])): ?>

      <h2 class="section__title section__title--center section__title--has-separator">
        <?= wp_kses_post($sectionData['title']) ?>
      </h2>

    <?php endif ?>

    <?php get_template_part( 'gpw-templates/global/swiper-template', null, ['slide_items' => $slideItems, 'has_pagination' => true]) ?>
  </div>
</section>
<?php
// ! Cleanup variables
unset($sectionData, $feedback, $avatarID, $name, $position, $company);