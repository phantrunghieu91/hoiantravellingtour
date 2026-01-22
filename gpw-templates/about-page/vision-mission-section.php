<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Vision, mission section
 */
$sectionData = get_field( 'mission_vision', get_the_ID() );
if ( empty( $sectionData ) ) {
  return;
}
foreach( $sectionData as $section ) :
  $title = $section['title'];
  $slug = sanitize_title( $title );
?>
<section class="principle <?= esc_attr( $slug ) ?>">
  <div class="section__inner">
    <?= wp_get_attachment_image( $section['image'], 'large', false, ['class' => 'principle__image']) ?>
    <div class="principle__main">
      <h2 class="section__title section__title--secondary"><?= esc_html( $title ) ?></h2>
      <div class="principle__content">
        <?= wp_kses_post( $section['content'] ) ?>
      </div>
    </div>
  </div>
</section>
<?php 
endforeach;

// ! Cleanup variables
unset( $sectionData, $section, $title, $slug );