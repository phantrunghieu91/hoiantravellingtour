<?php
/**
 * @author Hieu "JIN" Phan Trung
 * * Template: Footer - Subscribe Form Block
 */
$subscribeFormData = get_field('subscribe_form', 'gpw_settings');
$formSC = '[contact-form-7 id="766d840" title="FOOTER: Subcriber form"]';
?>
<div class="footer__subscribe-block subscribe-block">
  <div class="subscribe-block__content">
    <?php if (!empty($subscribeFormData['sub_title'])): ?>
      <span class="subscribe-block__sub-title"><?= esc_html($subscribeFormData['sub_title']) ?></span>
    <?php endif; ?>
    <?php if (!empty($subscribeFormData['title'])): ?>
      <h2 class="subscribe-block__title"><?= wp_kses_post($subscribeFormData['title']) ?></h2>
    <?php endif; ?>
    <?php if (!empty($subscribeFormData['description'])): ?>
      <div class="subscribe-block__desc"><?= wp_kses_post($subscribeFormData['description']) ?></div>
    <?php endif; ?>
  </div>
  <div class="subscribe-block__form">
    <?= do_shortcode($formSC) ?>
  </div>
</div>
<script>
  jQuery(document).ready(function($){$('.footer__subscribe-block').css('margin-top',function(){return $(this).outerHeight()/2*-1+'px'})});
</script>
<?php
// ! Clean up variables
unset($subscribeFormData, $formSC);