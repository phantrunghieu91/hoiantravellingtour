<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Case study section
 */
$sectionData = get_field( 'case_studies' );
$caseStudies = get_posts([
  'post_type' => 'case-study',
  'post_status' => 'publish',
  'numberposts' => 4,
]);
if( empty( $caseStudies )) {
  do_action( 'qm/debug', 'GLOBAL: Case studies section - Please add case study post!');
  return;
}
$slideItems = [];
foreach( $caseStudies as $case ) {
  $caseID = $case->ID;
  $imgID = get_post_thumbnail_id( $caseID );
  $info = get_field( 'information', $caseID );
  ob_start();
  ?>
  <article class="case-study">
    <?= wp_get_attachment_image( $imgID ?: PLACEHOLDER_IMAGE_ID, 'large', false, ['class' => 'case-study__image', 'alt' => __('International logistics and freight forwarding projects by 3A Logistics', 'gpw') ] ) ?>
    <div class="case-study__content">
      <h3 class="case-study__title"><?= $case->post_title ?></h3>
      <ul class="case-study__info-list">
        <li class="case-study__info volume">
          <strong class="case-study__info-label"><?= __('Volume', 'gpw') ?>:</strong>
          <span class="case-study__info-content"><?= esc_html( $info['volume']) ?></span>
        </li>
        <li class="case-study__info route">
          <strong class="case-study__info-label"><?= __('Route', 'gpw') ?>:</strong>
          <span class="case-study__info-content"><?= esc_html( $info['route']) ?></span>
        </li>
        <li class="case-study__info key_achievement">
          <strong class="case-study__info-label"><?= __('Key achievement', 'gpw') ?>:</strong>
          <span class="case-study__info-content"><?= esc_html( $info['key_achievement']) ?></span>
        </li>
      </ul>
      <?php get_template_part( 'gpw-templates/global/gpw-button', null, [
        'label' => __('Read case study', 'gpw'),
        'url' => $link,
        'style' => 'outline',
      ]) ?>
    </div>
  </article>
  <?php
  $slideItems[] = ob_get_clean();
}

$title = isset( $sectionData['title'] ) && !empty( $sectionData['title'] ) ? esc_html( $sectionData['title'] ) : __('Case studies', 'gpw');
$description = isset( $sectionData['description'] ) && !empty( $sectionData['description'] ) ? wp_kses_post( $sectionData['description']) : '';
?>
<section class="case-studies">
  <div class="section__inner section__inner--full">
    <div class="case-studies__content">
      <h2 class="section__title section__title--has-separator"><?= $title ?></h2>
      <?php if( !empty( $description ) ): ?>
        <div class="section__description"><?= $description ?></div>
      <?php endif ?>
      <div class="case-studies__carousel-nav-btns">
        <a class="gpw-nav-btn gpw-nav-btn__prev" role="button" aria-label="Previous slide">
          <span class="material-symbols-outlined">chevron_left</span>
        </a>
        <a class="gpw-nav-btn gpw-nav-btn__next" role="button" aria-label="Next slide">
          <span class="material-symbols-outlined">chevron_right</span>
        </a>
      </div>
    </div>
    <div class="case-studies__carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems ] ) ?>
    </div>
  </div>
</section>