<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: LOGISTICS SOLUTION SINGLE - Suitable products section
 */
$sectionData = get_field( 'suitable_products', get_the_ID());
if( empty( $sectionData['industry'] ) ) {
  do_action( 'qm/error', 'No Suitable Products section data found for Logistics Solution ID ' . get_the_ID() );
  return;
}
foreach( $sectionData['industry'] as $industryID ) {
  $industryImgID = get_post_thumbnail_id( $industryID ) ?: PLACEHOLDER_IMAGE_ID;
  $industryTitle = get_the_title( $industryID );
  ob_start();
  ?>
  <article class="industry">
    <?= wp_get_attachment_image( $industryImgID, 'medium_large', false, ['class' => 'industry__img', 'alt' => $industryTitle ] ) ?>
    <div class="industry__content">
      <h3 class="industry__title"><?= esc_html( $industryTitle ) ?></h3>
    </div>
  </article>
  <?php
  $slideItems[] = ob_get_clean();
}
?>
<section class="suitable-industry">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?php esc_html_e( $sectionData['title'] ) ?></h2>
    <?php if( $sectionData['description'] ): ?>
      <div class="section__description section__description--center"><?= wp_kses_post( $sectionData['description'] ) ?></div>
    <?php endif ?>
    <div class="suitable-industry__carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems, 'has_nav' => true ]) ?>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData, $industryID, $industryImgID, $industryTitle, $slideItems );