<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Be our agent page - Introduction section
 */
$sectionData = get_field('introduction', get_the_ID());
if( empty( $sectionData['title'] ) && empty( $sectionData['content' ] ) ) {
  do_action('qm/debug', 'No data for introduction section');
  return;
}
$imgID = $sectionData['image'] ?? PLACEHOLDER_IMAGE_ID;
?>
<section class="introduction">
  <div class="section__inner">
    <div class="introduction__image-wrapper">
      <?= wp_get_attachment_image( $imgID, 'full', false, [ 'class' => 'introduction__image' ]) ?>
    </div>
    <main class="introduction__main">
      <h2 class="section__title section__title--has-separator"><?= esc_html( $sectionData['title'] ) ?></h2>
      <?php if( ! empty( $sectionData['content'] ) ) : ?>
        <div class="introduction__content"><?= wp_kses_post( $sectionData['content'] ) ?></div>
      <?php endif; ?>
    </main>
  </div>
</section>