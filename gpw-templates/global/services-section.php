<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Services Section
 */
$logisticSolutions = get_posts([
  'post_type' => 'logistics-solution',
  'numberposts' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
]);
$sectionTitle = isset($args['title']) ? $args['title'] : sprintf( '%s <span class="highlight">%s</span>', __('Our value', GPW_TEXT_DOMAIN), __('proposition', GPW_TEXT_DOMAIN) );
$hasViewAllButton = $args['has_view_all_button'] ?? false;
if( empty($logisticSolutions) ) {
  error_log('SERVICES SECTION: No logistic solution found.');
  return;
}
foreach( $logisticSolutions as $card ) {
  $title = get_the_title($card);
  $permalink = get_permalink($card);
  $thumbnailID = get_post_thumbnail_id($card) ?: PLACEHOLDER_IMAGE_ID;
  $shortDescription = get_field('short_description', $card->ID);
  
  ob_start();
  ?>

  <article class="services__card">
    <div class="services__card-img-wrapper"><?= wp_get_attachment_image( $thumbnailID, 'large', false, [ 'class' => 'services__card-img', 'alt' => $title ]) ?></div>
    <div class="services__card-content">
      <h3 class="services__card-title line-clamp"><?= esc_html($title) ?></h3>
      <div class="services__card-description line-clamp"><?= wp_kses_post($shortDescription) ?></div>
      <a href="<?= $permalink ?>" class="services__card-read-more-btn gpw-button gpw-button__outlined gpw-button--center" role="button">
        <span class="material-symbols-outlined">chevron_right</span>
        <span><?php esc_html_e('Read more', GPW_TEXT_DOMAIN) ?></span>
      </a>
    </div>
  </article>

  <?php
  $slideItems[] = ob_get_clean();
}
?>
<section class="services">
  <div class="section__inner">
    <h2 class="section__title section__title--center section__title--has-separator"><?= $sectionTitle ?></h2>
    
    <div class="services__carousel">
      <?php get_template_part('gpw-templates/global/swiper-template', null, ['slide_items' => $slideItems, 'has_nav' => true ]) ?>
    </div>

    <?php if( $hasViewAllButton ): ?>

      <a href="<?= get_post_type_archive_link( 'logistics-solution' ) ?>" class="gpw-button gpw-button--center gpw-button__primary" role="button">
        <span class="gpw-button__text"><?php esc_html_e('View all services', GPW_TEXT_DOMAIN) ?></span>
      </a>

    <?php endif; ?>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $logisticSolutions, $valuePropositionCard );