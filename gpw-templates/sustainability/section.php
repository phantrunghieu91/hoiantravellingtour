<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Sustainability Page - Section
 */
$sectionData = isset( $args['section_data'] ) ? $args['section_data'] : null;
if( empty( $sectionData ) ) {
  return;
}
?>
<section class="sustainability-section" id="<?= esc_attr( $sectionData['id'] ) ?>">
  <div class="section__inner">
    <?php if( $sectionData['key'] === 'social_governance' ) : ?>
      <div class="sustainability-section__slogan"><?= wp_kses_post( $sectionData['data']['slogan'] ) ?></div>
    <?php endif ?>
    
    <?php if( isset( $sectionData['data']['content'] ) && !empty( $sectionData['data']['content'] ) ) :
      foreach( $sectionData['data']['content'] as $idx => $content ) : ?>
      
      <div class="sustainability-section__block">
        <?= wp_get_attachment_image( $content['image'] ?? PLACEHOLDER_IMAGE_ID, 'large', false, [ 'class' => 'sustainability-section__block-image' ]) ?>
        <div class="sustainability-section__block-content">
          <?php if( $idx === 0 ) : ?>
            <h2 class="section__title section__title--has-separator"><?= esc_html( $sectionData['data']['title']) ?></h2>
          <?php endif ?>
          <div class="sustainability-section__block-description"><?= wp_kses_post( $content['description'] ) ?></div>
        </div>
      </div>

    <?php endforeach; endif; ?>
  </div>
</section>