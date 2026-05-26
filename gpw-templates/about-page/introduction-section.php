<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Introduction section
 */
$sectionData = get_field( 'introduction' );
?>
<section class="introduction">
  <div class="section__inner">
    <div class="introduction__content">
      <?php if( !empty( $sectionData[ 'title' ])): ?>
        <h2 class="section__title"><?= wp_kses_post( $sectionData[ 'title' ]) ?></h2>
      <?php endif ?>
      <?php if( !empty( $sectionData[ 'description' ])): ?>
        <div class="section__description"><?= wp_kses_post( $sectionData[ 'description' ]) ?></div>
      <?php endif ?>
      <?php if( !empty( $sectionData['cta_button']['link']) && !empty( $sectionData['cta_button']['label']) ) {
        get_template_part( 'gpw-templates/global/gpw-button', null, [ 'style' => 'primary', 'target' => '_blank', 'icon_code' => 'document_search', 
          'label' => $sectionData['cta_button']['label'], 'url' => $sectionData['cta_button']['link'] ]);
      } ?>
    </div>
    <?php if( !empty( $sectionData[ 'team_image' ] )) : ?>
    <div class="introduction__image-wrapper">
      <?= wp_get_attachment_image( $sectionData['team_image'], 'large', false, [ 'class' => 'introduction__image', 'alt' => $sectionData['image_alt']]) ?>
    </div>
    <?php endif ?>
  </div>
</section>