<?php 
/**
 * @author Hieu "JIN" Phan Trung
 * * Template: Certificate List Shortcode
 */
namespace gpweb\shortcodes;
class CertificateList extends BaseShortcode {
  private function getCertificateImage() {
    $mainSectionData = get_field('main_section', 'gpw_settings');
    return isset($mainSectionData['certificate_image']) && !empty($mainSectionData['certificate_image']) ? $mainSectionData['certificate_image'] : false;
  }
  public function shortcodeCallback(array $atts, $content = null) {
    $certificateImageID = $this->getCertificateImage();
    if( !$certificateImageID ) {
      return '';
    }
    ob_start();
    ?>
    <div class="certificate-list">
      <?= wp_get_attachment_image( $certificateImageID, 'full', false, [ 'class' => 'certificate-list__image' ] ) ?>
    </div>
    <?php
    return ob_get_clean();
  }
}