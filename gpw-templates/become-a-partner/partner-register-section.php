<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Become a partner page - Partner register form
 */
$sectionData = get_field('partner_register', get_the_ID());
if( empty( $sectionData['contact_form_7_shortcode'] ) ) {
  do_action('qm/debug', 'No data for partner register section');
  return;
}
?>
<section class="partner-register">
  <div class="section__inner">
    <main class="partner-register__content">
      <div class="partner-register__form-wrapper">
        <h2 class="section__title section__title--has-separator"><?= esc_html( $sectionData['title'] ) ?></h2>
        <?php if( !empty( $sectionData['description'] ) ) : ?>
          <div class="partner-register__description"><?= wp_kses_post( $sectionData['description'] ) ?></div>
        <?php endif; ?>
        <div class="partner-register__form">
          <?= do_shortcode( $sectionData['contact_form_7_shortcode'] ) ?>
        </div>
      </div>
      <div class="partner-register__image-wrapper">
        <?= wp_get_attachment_image( $sectionData['image'] ?? PLACEHOLDER_IMAGE_ID, 'large', false, [ 'class' => 'partner-register__image' ]) ?>
      </div>
    </main>
  </div>
</section>