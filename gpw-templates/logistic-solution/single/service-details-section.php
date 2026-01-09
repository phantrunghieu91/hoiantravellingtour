<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: SINGLE LOGISTICS SOLUTION - Service Details Section
 */
$sectionData = get_field( 'service_detail', get_the_ID() );
if( empty( $sectionData['detail'] ) ) {
  do_action('qm/debug', 'No data found for Service Details Section' );
  return;
}
foreach( $sectionData['detail'] as $detail ) {
  $id = sanitize_title( $detail['title'] );
  $navItems[] = [
    'id' => $id,
    'title' => $detail['title'],
  ];
  ob_start();
  ?>
  <article class="service-details__item">
    <?= wp_get_attachment_image( $detail['image'], 'large', false, [ 'class' => 'service-details__item-img' ]) ?>
    <div class="service-details__item-content">
      <h3 class="service-details__item-title"><?= esc_html( $detail['title'] ) ?></h3>
      <div class="service-details__item-description"><?= wp_kses_post( $detail['description'] ) ?></div>
    </div>
  </article>
  <?php
  $panelItems[] = [
    'id' => $id,
    'content' => ob_get_clean(),
  ];
}
?>
<section class="service-details">
  <div class="section__inner">
    <h2 class="section__title"><?php esc_html_e( $sectionData['title'] ) ?></h2>
    <?php if( !empty( $sectionData['description'] )): ?>
      <div class="section__description"><?= wp_kses_post( $sectionData['description'] ) ?></div>
    <?php endif ?>
    <div class="service-details__item-tabs tabs">
      <?php get_template_part( 'gpw-templates/global/tabs/tabs-nav', null, ['nav_items' => $navItems, 'style' => 'underline' ] ) ?>
      <?php get_template_part( 'gpw-templates/global/tabs/tabs-content', null, ['panels' => $panelItems ] ) ?>
    </div>
  </div>
</section>