<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Services Section
 */
$currentObj = get_queried_object(  );
if( !is_a( $currentObj, 'WP_Post_Type' )) {
  do_action( 'qm/debug', 'Please use this section inside post type archive only!');
  return;
}
$services = get_posts([
  'post_type' => $currentObj->name,
  'numberposts' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
]);
$sectionTitle = isset($args['title']) ? $args['title'] : sprintf( '%s <span class="highlight">%s</span>', __('Our value', 'gpw'), __('proposition', 'gpw') );
$hasViewAllButton = $args['has_view_all_button'] ?? false;
if( empty($services) ) {
  do_action( 'qm/debug', 'SERVICES SECTION: No logistic solution found.');
  return;
}
foreach( $services as $card ) {
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
      <?php if( !empty($shortDescription) ): ?>
        <div class="services__card-description line-clamp"><?= wp_kses_post($shortDescription) ?></div>
      <?php endif ?>
      <a href="<?= $permalink ?>" class="services__card-read-more-btn gpw-button gpw-button__outlined gpw-button--center" role="button">
        <span class="material-symbols-outlined">chevron_right</span>
        <span><?php esc_html_e('Read more', 'gpw') ?></span>
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
        <span class="gpw-button__text"><?php esc_html_e('View all services', 'gpw') ?></span>
      </a>

    <?php endif; ?>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $logisticSolutions, $valuePropositionCard );