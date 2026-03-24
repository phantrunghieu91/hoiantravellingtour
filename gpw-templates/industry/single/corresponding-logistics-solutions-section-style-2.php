<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Industry - Corresponding logistics solutions section style 2
 */
$sectionData = get_field('corresponding_logistics_solutions', get_the_ID());
if( empty( $sectionData['logistics_solution'] )) {
  do_action('qm/debug', 'Industry single - Corresponding logistics solutions section: No logistics solutions data found!!');
  return;
}
$slideItems = [];
foreach( $sectionData['logistics_solution'] as $logisticsSolution ) {
  $link = !empty( $logisticsSolution['solution'] ) ? get_permalink( $logisticsSolution['solution'] ) : 'javascript:void(0);';
  ob_start();
  ?>
  <article class="logistics-solution">
    <?= wp_get_attachment_image( $logisticsSolution['image'] ?: PLACEHOLDER_IMAGE_ID, 'large', false, ['class' => 'logistics-solution__image'] ) ?>
    <div class="logistics-solution__content">
      <h3 class="logistics-solution__title"><?= esc_html( $logisticsSolution['title'] ) ?></h3>
      <?php if( !empty( $logisticsSolution['description'] ) ) : ?>
        <div class="logistics-solution__description"><?= wp_kses_post( $logisticsSolution['description'] ) ?></div>
      <?php endif; ?>
      <?php get_template_part( 'gpw-templates/global/gpw-button', null, [
        'label' => __('Khám phá ngay', 'gpw'),
        'url' => $link,
        'style' => 'outline',
      ]) ?>
    </div>
  </article>
  <?php
  $slideItems[] = ob_get_clean();
}
?>
<section class="logistics-solutions">
  <div class="section__inner section__inner--full">
    <div class="logistics-solutions__content">
      <h2 class="section__title section__title--has-separator"><?php esc_html_e( $sectionData['title']) ?></h2>
      <?php if( !empty( $sectionData['description'] ) ) : ?>
        <div class="section__description">
          <?= wp_kses_post( $sectionData['description'] ) ?>
        </div>
      <?php endif ?>
      <div class="logistics-solutions__carousel-nav-btns">
        <a class="gpw-nav-btn gpw-nav-btn__prev" role="button" aria-label="Previous slide">
          <span class="material-symbols-outlined">chevron_left</span>
        </a>
        <a class="gpw-nav-btn gpw-nav-btn__next" role="button" aria-label="Next slide">
          <span class="material-symbols-outlined">chevron_right</span>
        </a>
      </div>
    </div>
    <div class="logistics-solutions__carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, ['slide_items' => $slideItems]) ?>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData, $slideItems );