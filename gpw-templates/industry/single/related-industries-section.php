<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single industry - Related industries
 */
$sectionData = get_field( 'related_industries', get_the_ID() );
if ( empty( $sectionData['title'] ) ) {
  do_action('qm/warn', 'Related industries section data is empty in industry ID: ' . get_the_ID() );
  return;
}
$industries = get_posts([
  'post_type' => 'industry',
  'numberposts' => -1,
  'post_status' => 'publish',
  'exclude' => [ get_the_ID() ],
]);
if( empty( $industries ) ) {
  do_action('qm/warn', 'No related industries found for industry ID: ' . get_the_ID() );
  return;
}
foreach( $industries as $industry ) {
  $imgID = get_post_thumbnail_id( $industry->ID ) ?: PLACEHOLDER_IMAGE_ID;
  $title = get_the_title( $industry->ID );
  $permalink = get_permalink( $industry->ID );
  ob_start();
  ?>

  <a class="industry" href="<?= $permalink ?>">
    <div class="industry__image"><?= wp_get_attachment_image( $imgID, 'large', false, ['alt' => esc_attr( $title )] ) ?></div>
    <h3 class="industry__title"><?= esc_html( $title ) ?></h3>
  </a>

  <?php 
  $slideItems[] = ob_get_clean();
}
?>
<section class="related-industries">
  <div class="section__inner">
    <h2 class="section__title"><?php esc_html_e( $sectionData['title'] ) ?></h2>
    <?php if( !empty( $sectionData['description'])) : ?>
      <div class="section__description">
        <?php echo wp_kses_post( $sectionData['description'] ) ?>
      </div>
    <?php endif; ?>
    <div class="related-industries__carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems, 'has_nav' => true ]) ?>
    </div>
  </div>
</section>
<?php
// ! Cleanup variables
unset( $sectionData, $industries, $slideItems );