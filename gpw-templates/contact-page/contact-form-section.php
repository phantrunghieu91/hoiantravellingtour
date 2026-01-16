<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: CONTACT PAGE - Contact form section
 */
$sectionData = get_field( 'contact_form', get_the_ID() );
$formSC = '[contact-form-7 id="3149cb5" title="CONTACT PAGE: Contact form"]';
?>
<section class="contact-form">
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
    <?= do_shortcode( $formSC ); ?>
  </div>
</section>