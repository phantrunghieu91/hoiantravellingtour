<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Get A Quote Section
 */
$sectionData = get_field('get_free_quote', 'gpw_settings');
if( empty( $sectionData['title'] ) ) {
  error_log('GET A QUOTE SECTION: Title is required.');
  return;
}
// $formSC = '[contact-form-7 id="4e0f5b0" title="GLOBAL: Get a free quote"]';
$formSC = '[contact-form-7 id="3149cb5" title="GLOBAL: Get a free quote (NEW)"]';
$sectionBgUrl = !empty( $sectionData['background_image'] ) ? wp_get_attachment_image_url( $sectionData['background_image'], 'full' ) : false;
?>
<section class="get-free-quote" <?php if( $sectionBgUrl ) echo sprintf('style="--_background-image:url(%s)"', esc_url($sectionBgUrl)); ?> >
  <div class="section__inner">

    <?php if( !empty( $sectionData['sub_title'] )): ?>
      <span class="section__sub-title section__sub-title--center"><?php esc_html_e( $sectionData['sub_title'] ); ?></span>
    <?php endif ?>
    <?php if( !empty( $sectionData['title'] )): ?>
      <h2 class="section__title section__title--center"><?php esc_html_e( $sectionData['title'] ); ?></h2>
    <?php endif ?>
    <?php if( !empty( $sectionData['description'] )): ?>
      <div class="section__description section__description--center"><?php echo wp_kses_post( $sectionData['description'] ); ?></div>
    <?php endif ?>

    <div class="get-free-quote__form">
      <?= do_shortcode( $formSC ) ?>
    </div>

  </div>
</section>
<?php
// ! Cleanup variables
unset( $sectionData, $sectionBgUrl, $formSC );