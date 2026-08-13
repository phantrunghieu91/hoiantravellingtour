<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Popup block
 */
$popupData   = get_field( 'popup', 'gpw_settings' );
$title       = $popupData['title'][GPW_CURRENT_LANGUAGE];
$description = $popupData['description'][GPW_CURRENT_LANGUAGE];
$formSC      = $popupData['cf7_sc'][GPW_CURRENT_LANGUAGE];
if( empty( $formSC ) ) {
  return;
}
?>
<div class="jins-popup" popover="auto" id="jins-popup">
  <button class="jins-popup__close-btn" popovertarget="jins-popup" popovertargetaction="hide">
    <span class="material-symbols-outlined">close</span>
  </button>
  <?php if( !empty( $title ) ): ?>
    <h2 class="jins-popup__title"><?= esc_html( $title ) ?></h2>
  <?php endif ?>
  <?php if( !empty( $description ) ): ?>
    <div class="jins-popup__description"><?= esc_html( $description ) ?></div>
  <?php endif ?>
  <?= do_shortcode( $formSC ) ?>
</div>