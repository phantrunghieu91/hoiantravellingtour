<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Logistics Solution - Expertise section
 */
$sectionData = get_field('expertise', get_the_ID());
if( empty( $sectionData['features'] )) {
  do_action( 'qm/error', 'No expertise section data found for Logistics Solution ID ' . get_the_ID() );
  return;
}
foreach( $sectionData['features'] as $index => $feature ) {
  $imgIds[$index] = $feature['image'] ?: PLACEHOLDER_IMAGE_ID;
  $items[$index] = [
    'title' => esc_html( $feature['title'] ),
    'content' => wp_kses_post( $feature['content'] ),
  ];
}
?>
<section class="expertise">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?= esc_html($sectionData['title']) ?></h2>
    <?php if( !empty( $sectionData['description'] )) : ?>
      <div class="expertise__description section__description section__description--center">
        <?= wp_kses_post( $sectionData['description'] ) ?>
      </div>
    <?php endif; ?>
    <div class="expertise__features">
      <?php get_template_part( 'gpw-templates/global/accordion-template', null, ['items' => $items, 'has_icon' => true ]) ?>
      <div class="expertise__features-imgs">
        <?php foreach( $imgIds as $idx => $imgID ) {
          echo wp_get_attachment_image( $imgID, 'medium_large', false, ['class' => 'expertise__features-img', 'aria-hidden' => $idx == 0 ? 'false' : 'true'] );
        } ?>
      </div>
    </div>
  </div>
</section>
<?php
// ! Cleanup variables
unset( $sectionData, $items, $imgIds );