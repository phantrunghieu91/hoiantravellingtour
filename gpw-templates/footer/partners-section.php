<?php
/**
 * @author Hieu "JIN" Phan Trung
 * * Template: Footer - Partners Section
 */
$partners = get_field('partner_section', 'gpw_settings');
if (empty($partners['logos'])) {
  return;
}
?>
<section class="partners">
  <div class="section__inner">
    <?php if (!empty($partners['sub_title'])): ?>
      <span class="section__sub-title section__sub-title--center"><?= esc_html($partners['sub_title']) ?></span>
    <?php endif; ?>
    <h2 class="section__title section__title--center section__title--has-separator">
      <?= wp_kses_post($partners['title']) ?>
    </h2>
    <div class="partners__grid">
      <?php foreach ($partners['logos'] as $logoID) {
        echo sprintf('<div class="partners__item">%s</div>', wp_get_attachment_image($logoID, 'medium', false, ['loading' => 'lazy', 'class' => 'partners__image']));
      } ?>
    </div>
  </div>
</section>
<?php
// ! Clean up variables
unset($partners);