<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - What make 3A different section
 */
$sectionData = get_field( 'what_make_us_different' );
if( empty( $sectionData['reason'])) {
  do_action( 'qm/debug', 'HOME PAGE: What make different section - Empty Reason! ');
  return;
}
$slideItems = [];
foreach( $sectionData['reason'] as $reason ): ob_start(); ?>
  <article class="what-make-different__reason">
    <?php if( !empty( $reason['icon'] ) ) {
      echo sprintf('<div class="what-make-different__reason-icon">%s</div>', wp_get_attachment_image( $reason['icon'], 'medium' ));
    } ?>
    <h3 class="what-make-different__reason-title line-clamp"><?= esc_html( $reason['title'] ) ?></h3>
    <div class="what-make-different__reason-content"><?= wp_kses_post( $reason['content'] ) ?></div>
  </article>
<?php $slideItems[] = ob_get_clean(); ;endforeach ?>
<section class="what-make-different">
  <div class="section__inner">
    <?php if( !empty($sectionData[ 'title' ]) && !empty($sectionData[ 'description' ]) ) : ?>
      <header class="what-make-different__header">
        <?php if( !empty( $sectionData['title'] )) {
          echo sprintf( '<h2 class="section__title section__title--center section__title--has-separator">%s</h2>', wp_kses_post( $sectionData['title'] ) );
        } ?>
        <?php if( !empty( $sectionData['description'] )) {
          echo sprintf( '<div class="section__description section__description--center">%s</div>', wp_kses_post( $sectionData['description'] ) );
        } ?>
      </header>
    <?php endif ?>
    <main class="what-make-different__carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems, 'has_nav' => true, 'has_pagination' => true ] ) ?>
    </main>
  </div>
</section>