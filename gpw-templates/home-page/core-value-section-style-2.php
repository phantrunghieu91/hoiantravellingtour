<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home Page - Core value section style 2
 */
use gpweb\inc\base\Utilities as Utils;
$sectionData = get_field('core_value', get_the_ID());
if (empty($sectionData['tabs'])) {
  do_action('qm/error', 'Core value section: Missing data');
  return;
}
$btnUrl = Utils::getUrl($sectionData['link_to']);
$footerBgImgID = isset( $sectionData['banner'] ) && !empty( $sectionData['banner']['overlay_image'] ) ? $sectionData['banner']['overlay_image'] : false;
$footerImgId = isset( $sectionData['banner'] ) && !empty( $sectionData['banner']['image'] ) ? $sectionData['banner']['image'] : false;
?>
<section class="core-value style-2">
  <div class="section__inner">
    <header class="core-value__header">
      <?php if( !empty( $sectionData['sub_title'] ) ) : ?>
        <span class="section__sub-title"><?= esc_html( $sectionData['sub_title'] ); ?></span>
      <?php endif; ?>

      <?php if( !empty( $sectionData['title'] ) ) : ?>
        <h2 class="section__title section__title--center section__title--has-separator"><?= wp_kses_post( $sectionData['title'] ); ?></h2>
      <?php endif; ?>

      <?php if( !empty( $sectionData['description'] ) ) : ?>
        <div class="section__description section__description--center"><?= wp_kses_post( $sectionData['description'] ); ?></div>
      <?php endif; ?>
    </header>
    <main class="core-value__grid">
      <?php foreach( $sectionData['tabs'] as $idx => $tabData ) : ?>
      <article class="core-value__item">
        <div class="core-value__item-icon"><?= wp_get_attachment_image( $tabData['icon'], 'thumbnail') ?></div>
        <h3 class="core-value__item-title"><?= esc_html( $tabData['title'] ) ?></h3>
        <div class="core-value__item-content"><?= wp_kses_post( $tabData['content'] ) ?></div>
      </article>
      <?php endforeach; ?>
    </main>
    <footer class="core-value__footer" <?php if( $footerBgImgID ) echo sprintf('style="--_footer-bg-img:url(%s)"', wp_get_attachment_image_url( $footerBgImgID, 'full' )) ?>>
      <div class="core-value__footer-overlay"></div>
      <?php if( $footerImgId ) {
        echo wp_get_attachment_image( $footerImgId, 'large', false, [ 'class' => 'core-value__footer-image' ] );
      } ?>
      <div class="core-value__footer-content">
      <?php if( !empty( $sectionData['banner']['sub_title'] ) ): ?>
        <span class="core-value__footer-sub-title"><?= esc_html( $sectionData['banner']['sub_title'] ) ?></span>
      <?php endif ?>
      <?php if( !empty( $sectionData['banner']['title'] ) ): ?>
        <h4 class="core-value__footer-title"><?= esc_html( $sectionData['banner']['title'] ) ?></h4>
      <?php endif ?>
      <?php if( $btnUrl && !empty( $sectionData['link_to']['label'] ) ) {
        get_template_part( 'gpw-templates/global/gpw-button', null, [
          'label' => $sectionData['link_to']['label'],
          'url' => $btnUrl,
          'style' => 'primary',
          'icon_code' => 'chevron_right',
        ]);
      } ?>
      </div>
    </footer>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData );