<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: SINGLE LOGISTICS SOLUTION - Other services section
 */
$sectionData = get_field('other_services', get_the_ID());
if (empty($sectionData['service'])) {
  do_action('qm/debug', 'No other services found');
  return;
}
foreach ($sectionData['service'] as $service): 
  ob_start(); ?>
  <article class="other-service">
    <?= wp_get_attachment_image($service['image'], 'medium_large', false, ['class' => 'other-service__image']) ?>
    <div class="other-service__content">
      <h3 class="other-service__title"><?= esc_html($service['title']) ?></h3>
      <div class="other-service__description"><?= wp_kses_post($service['description']) ?></div>
    </div>
  </article>
<?php 
  $slideItems[] = ob_get_clean();
endforeach ?>
<section class="other-services">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?= esc_html($sectionData['title']) ?></h2>

    <?php if (!empty($sectionData['description'])): ?>
      <div class="section__description"><?= wp_kses_post($sectionData['description']) ?></div>
    <?php endif ?>

    <div class="other-services__carousel">

      <?php get_template_part( 'gpw-templates/global/swiper-template', null, ['slide_items' => $slideItems, 'has_nav' => true ] ) ?>

    </div>
  </div>
</section>
<?php
// ! Cleanup variables
unset($sectionData, $service);