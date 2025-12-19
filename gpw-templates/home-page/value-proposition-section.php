<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Value Proposition Section
 */
$logisticSolutions = get_posts([
  'post_type' => 'logistic-solution',
  'numberposts' => -1,
  'orderby' => 'DATE',
  'order' => 'DESC',
]);
if( empty($logisticSolutions) ) {
  error_log('VALUE PROPOSITION SECTION: No logistic solution found.');
  return;
}
$valuePropositionCard = function($post) {
  $title = get_the_title($post);
  $excerpt = get_the_excerpt($post);
  $permalink = get_permalink($post);
  $thumbnailID = get_post_thumbnail_id($post) ?: PLACEHOLDER_IMAGE_ID;
  $iconID = get_field('icon', $post->ID);
  $shortDescription = get_field('short_description', $post->ID);
  
  ob_start();
  ?>

  <article class="value-proposition__card">
    <?= wp_get_attachment_image( $thumbnailID, 'large', false, [ 'class' => 'value-proposition__card-bg-img', 'alt' => $title ]) ?>
    <div class="value-proposition__card-content">
      <div class="value-proposition__card-icon">
        <?= wp_get_attachment_image( $iconID, 'thumbnail', true ) ?>
      </div>
      <h3 class="value-proposition__card-title"><?= esc_html($title) ?></h3>
      <span class="value-proposition__card-separator"></span>
      <div class="value-proposition__card-description"><?= wp_kses_post($shortDescription) ?></div>
      <a href="<?= $permalink ?>" class="value-proposition__card-read-more-btn">
        <span class="material-symbols-outlined">chevron_right</span>
        <span><?php esc_html_e('Read more', GPW_TEXT_DOMAIN) ?></span>
      </a>
    </div>
  </article>

  <?php
  echo ob_get_clean();
}
?>
<section class="value-proposition">
  <div class="section__inner">
    <h2 class="section__title section__title--center section__title--has-separator"><?php esc_html_e('Our value', GPW_TEXT_DOMAIN) ?> <span class="highlight"><?php esc_html_e('proposition', GPW_TEXT_DOMAIN) ?></span></h2>
    
    <div class="value-proposition__grid">
      <?php foreach( $logisticSolutions as $card ) {
        $valuePropositionCard($card);
      } ?>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $logisticSolutions, $valuePropositionCard );