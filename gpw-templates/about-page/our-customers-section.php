<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Our customers section
 */
$sectionData = get_field('our_customers');
if (empty($sectionData['customer'])) {
  do_action('qm/debug', 'ABOUT PAGE: Our customers section do NOT have customers data!');
  return;
}
?>
<section class="our-customers">
  <div class="section__inner">
    <header class="our-customers__header">
      <h2 class="section__title section__title--center section__title--has-separator">
        <?= wp_kses_post($sectionData['title']) ?></h2>
      <?php if (!empty($sectionData['description'])): ?>
        <div class="section__description section__description--center"><?= wp_kses_post($sectionData['description']) ?>
        </div>
      <?php endif ?>
    </header>
    <main class="our-customers__grid">
      <?php foreach ($sectionData['customer'] as $customer): ?>
        <article class="our-customers__item">
          <div class="our-customers__item-image">
            <?= wp_get_attachment_image($customer['image'] ?: PLACEHOLDER_IMAGE_ID, 'medium_large' ) ?>
          </div>
          <?php if (!empty($customer['title'])): ?>
            <h4 class="our-customers__item-title"><?= esc_html($customer['title']) ?></h4>
          <?php endif ?>
          <?php if (!empty($customer['content'])): ?>
            <div class="our-customers__item-desc"><?= wp_kses_post($customer['content']) ?></div>
          <?php endif ?>
            </article>
      <?php endforeach ?>
    </main>
  </div>
</section>