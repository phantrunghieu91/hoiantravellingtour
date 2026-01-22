<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Our value section
 */
$sectionData = get_field( 'our_value', get_the_ID() );
if ( empty( $sectionData['items'] ) ) {
  do_action('qm/debug', 'Our Value section: No data found.');
  return;
}
?>
<section class="our-value">
  <div class="section__inner">
    <h2 class="section__title section__title--center section__title--secondary"><?= esc_html($sectionData['title']) ?></h2>
    <?php if( !empty($sectionData['description'])): ?>
      <div class="section__description section__description--center"><?= wp_kses_post($sectionData['description']) ?></div>
    <?php endif ?>
    <ul class="our-value__items">
      <?php foreach( $sectionData['items'] as $item ) : ?>
  
        <li class="our-value__item">
          <h3 class="our-value__item-title"><?= esc_html( $item['title'] ) ?></h3>
          <div class="our-value__item-desc"><?= wp_kses_post( $item['description'] ) ?></div>
        </li>
  
      <?php endforeach ?>
    </ul>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData );