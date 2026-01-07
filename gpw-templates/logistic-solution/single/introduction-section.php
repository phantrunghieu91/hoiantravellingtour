<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Logistics Solution Single - Introduction section
 */
$sectionData = get_field('introduction', get_the_ID());
if( empty( $sectionData['title'] && $sectionData['content'] ) ) {
  do_action( 'qm/error', 'No introduction section data found for Logistics Solution ID ' . get_the_ID() );
  return;
}
?>
<section class="introduction">
  <div class="section__inner">
    <div class="introduction__image-wrapper">
      <?= wp_get_attachment_image( $sectionData['image'], 'large', false, ['class' => 'introduction__image'] ) ?>
    </div>
    <div class="introduction__content">
      <h2 class="section__title"><?= esc_html($sectionData['title']) ?></h2>
      <?php if( !empty($sectionData['content']) ): ?>
        <div class="introduction__description"><?= wp_kses_post($sectionData['content']) ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData );