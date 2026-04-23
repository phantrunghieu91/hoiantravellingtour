<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Fixed social icons
 */
$socials = get_field( 'fixed_social_icons', 'gpw_settings' );
if( empty($socials) ) {
  return;
}
?>
<div class="fixed-social-icons">
  <ul class="fixed-social-icons__list">
    <?php foreach($socials as $social) : ?>
      <li class="fixed-social-icons__item">
        <a href="<?= esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer">
          <?= wp_get_attachment_image( $social['icon'], 'medium', false, [ 'class' => 'fixed-social-icons__icon', 'alt' => $social['name'] ] ) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>