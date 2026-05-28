<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Member of group section
 */
$sectionData = get_field( 'member_of' );
if( empty( $sectionData['title'] ) && empty( $sectionData['logos_image'] ) ) {
  do_action( 'qm/debug', 'HOME PAGE - Member of group section: Missing data!' );
  return;
}
?>
<section class="member-of-group">
  <div class="section__inner">
    <?php if( !empty($sectionData[ 'title' ]) ) : ?>
      <header class="member-of-group__header">
        <?= sprintf( '<h2 class="section__title section__title--center section__title--has-separator">%s</h2>', wp_kses_post( $sectionData['title'] ) ); ?>
        <?php if( !empty( $sectionData['description'] )) {
          echo sprintf( '<div class="section__description section__description--center">%s</div>', wp_kses_post( $sectionData['description'] ) );
        } ?>
      </header>
    <?php endif ?>
    <main class="member-of-group__main">
      <?= wp_get_attachment_image( $sectionData[ 'logos_image' ], 'large', false, [ 'class' => 'member-of-group__logos-image', 'alt' => esc_attr($sectionData['title']) ] ); ?>
    </main>
  </div>
</section>