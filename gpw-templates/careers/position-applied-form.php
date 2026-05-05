<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Career page - Position applied form
 */
$careerPageID = GPW_CURRENT_LANGUAGE == 'en' ? 508 : 2310;
$sectionData = get_field('position_applied_for', $careerPageID);
if( empty($sectionData['contact_form_sc']) ) {
  do_action('qm/debug', 'Please enter contact form SC!');
  return;
}
?>
<section class="position-applied">
  <div class="section__inner">
    <main class="position-applied__main">
      <div class="position-applied__form-wrapper">
        <h2 class="section__title section__title--has-separator"><?= esc_html( $sectionData[ 'title' ]) ?></h2>
        <?php if( !empty($sectionData['description']) ): ?>
          <div class="section__description"><?= wp_kses_post( $sectionData['description'] ) ?></div>
        <?php endif; ?>
        <?= do_shortcode( $sectionData['contact_form_sc'] ) ?>
      </div>
      <div class="position-applied__image-wrapper">
        <?= wp_get_attachment_image( $sectionData['image'] ?? PLACEHOLDER_IMAGE_ID, 'large', false, [ 'class' => 'position-applied__image' ]) ?>
      </div>
    </main>
  </div>
</section>