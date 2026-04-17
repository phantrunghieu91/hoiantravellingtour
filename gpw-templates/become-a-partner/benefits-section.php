<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Be our agent page - Benefits section
 */
$sectionData = get_field('benefit', get_the_ID() );
if( empty( $sectionData['benefits'] ) ) {
  do_action('qm/debug', 'No data for benefit section');
  return;
}
?>
<section class="benefits">
  <div class="section__inner">
    <h2 class="section__title section__title--has-separator"><?= esc_html( $sectionData['title'] ) ?></h2>
    <?php if( ! empty( $sectionData['description'] ) ) : ?>
      <div class="benefits__description"><?= wp_kses_post( $sectionData['description'] ) ?></div>
    <?php endif; ?>
    <ul class="benefits__list">
      <?php foreach( $sectionData['benefits'] as $benefit ) : ?>
        <li class="benefits__item">
          <?= wp_get_attachment_image( $benefit['icon'] ?? PLACEHOLDER_IMAGE_ID, 'medium', false, [ 'class' => 'benefits__item-icon' ] ) ?>
          <h3 class="benefits__item-label"><?= esc_html( $benefit['label'] ) ?></h3>
          <?php if( ! empty( $benefit['content'] ) ) : ?>
            <div class="benefits__item-content"><?= wp_kses_post( $benefit['content'] ) ?></div>
          <?php endif; ?>
        </li>
      <?php endforeach ?>
    </ul>
  </ul>
</section>