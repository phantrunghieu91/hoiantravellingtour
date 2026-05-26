<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Why choose us section
 */
$sectionData = get_field( 'why_choose_us' );
if( empty($sectionData['reason']) ) {
  do_action( 'qm/debug', 'ABOUT PAGE: why choose us section still NOT have data!' );
  return;
} 
$slideItems = [];
foreach( $sectionData['reason'] as $reason ): ob_start(); ?>
  <article class="why-choose-us__reason">
    <?php if( !empty( $reason['icon'] ) ) {
      echo sprintf('<div class="why-choose-us__reason-icon">%s</div>', wp_get_attachment_image( $reason['icon'], 'medium' ));
    } ?>
    <h3 class="why-choose-us__reason-title line-clamp"><?= esc_html( $reason['title'] ) ?></h3>
    <div class="why-choose-us__reason-content"><?= wp_kses_post( $reason['content'] ) ?></div>
  </article>
<?php $slideItems[] = ob_get_clean(); ;endforeach ?>
<section class="why-choose-us">
  <div class="section__inner">
    <header class="why-choose-us__header">
      <?php if( !empty( $sectionData['title'] ) ): ?>
        <h2 class="section__title section__title--center section__title--has-separator"><?= wp_kses_post( $sectionData['title'] ) ?></h2>
      <?php endif ?>
      <?php if( !empty( $sectionData['description'] ) ): ?>
        <div class="section__description"><?= wp_kses_post( $sectionData['description'] ) ?></div>
      <?php endif ?>
    </header>
    <main class="why-choose-us__reasons">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems, 'has_nav' => true, 'has_pagination' => true ]) ?>
    </main>
  </div>
</section>