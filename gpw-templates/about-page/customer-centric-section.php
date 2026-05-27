<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Customer centric
 */
$sectionData = get_field('customer_centric', get_the_ID() );
if( empty( $sectionData[ 'items' ])) {
  do_action( 'qm/debug', 'ABOUT PAGE: Customer centric do NOT have data.' );
  return;
}
$logoID = $sectionData['logo_icon'] ?: get_theme_mod( 'site_logo' );
?>
<section class="customer-centric">
  <div class="section__inner">
    <?php if( !empty( $sectionData[ 'title' ]) && !empty( $sectionData[ 'description' ] ) ) :?>
      <header class="customer-centric__header">
        <?php if( !empty( $sectionData['title'] )) : ?>
          <h2 class="section__title"><?= wp_kses_post( $sectionData['title'] ) ?></h2>
        <?php endif ?>
        <?php if( !empty( $sectionData['description'] )) : ?>
          <div class="section__description"><?= wp_kes_post( $sectionData['description'] ) ?></div>
        <?php endif ?>
      </header>
    <?php endif ?>
    <main class="customer-centric__main">
      <?php foreach( $sectionData[ 'items' ] as $item ) : ?>
        <div class="customer-centric__item">
          <h3 class="customer-centric__item-title"><?= esc_html( $item['title'] ) ?></h3>
          <div class="customer-centric__item-content"><?= wp_kses_post( $item['content'] ) ?></div>
          <?= wp_get_attachment_image( $item['icon'], 'medium', false, [ 'class' => 'customer-centric__item-icon' ] ) ?>
        </div>
      <?php endforeach ?>
      <div class="customer-centric__logo-wrapper">
        <?= wp_get_attachment_image( $logoID, 'medium', false, [ 'class' => 'customer-centric__logo', 'alt' => get_bloginfo('name') . '\'s logo' ]) ?>
      </div>
    </main>
  </div>
</section>