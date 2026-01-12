<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: FOOTER - Consultant block
 */
$contactPageID = 14;
$imgID = 306;
?>
<section class="consultant">
  <div class="section__inner">
    <div class="consultant__image-wrapper">
      <svg class="consultant__arc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 100" width="250" height="500">
        <path d="M0,0 l50,0 q0,70 -40,100 l-10,0 z"/>
      </svg>
      <?= wp_get_attachment_image( $imgID, 'medium_large', false, [ 'class' => 'consultant__image' ] ) ?>
    </div>
    <div class="consultant__content">
      <h2 class="consultant__title">
        <?php esc_html_e('Get free consultation from 3A Logistics', GPW_TEXT_DOMAIN) ?></h2>
      <a href="<?= get_permalink($contactPageID) ?>" class="gpw-button gpw-button__secondary">
        <span class="gpw-button__text"><?php esc_html_e('Contact now', GPW_TEXT_DOMAIN) ?></span>
      </a>
    </div>

  </div>
</section>
<?php
// ! Cleanup variables
unset($contactPageID);