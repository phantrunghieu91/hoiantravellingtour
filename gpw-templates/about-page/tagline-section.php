<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Tagline section
 */
$sectionData = get_field( 'tagline' );
if( empty( $sectionData['content'] ) ) {
  do_action( 'qm/debug', 'Tagline still do NOT have content!' );
  return;
}
?>
<section class="tagline">
  <div class="section__inner">
    <div class="tagline__wrapper">
      <?php if( !empty( $sectionData[ 'quote_icon' ] )) {
        echo wp_get_attachment_image( $sectionData[ 'quote_icon' ], 'medium', false, [ 'class' => 'tagline__icon' ] );
      } ?>
      <div class="tagline__content"><?= wp_kses_post( $sectionData[ 'content' ] ) ?></div>
    </div>
  </div>
</section>