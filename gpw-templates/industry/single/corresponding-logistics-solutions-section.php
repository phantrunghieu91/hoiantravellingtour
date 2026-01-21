<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Industry single - Corresponding logistics solutions section
 */
$sectionData = get_field('corresponding_logistics_solutions', get_the_ID());
if( empty( $sectionData['logistics_solution'] )) {
  do_action('qm/debug', 'Industry single - Corresponding logistics solutions section: No logistics solutions data found!!');
  return;
}
foreach( $sectionData['logistics_solution'] as $logisticsSolution ) {
  $postID = $logisticsSolution['solution'] ?: null;
  $id = $postID ? get_post_field( 'post_name', $postID ) : sanitize_title( $logisticsSolution['title'] );
  $title = !empty( $logisticsSolution['title'] ) ? $logisticsSolution['title'] : get_the_title( $postID );
  $imgID = !empty( $logisticsSolution['image'] ) ? $logisticsSolution['image'] : ( $postID ? get_post_thumbnail_id( $postID ) : PLACEHOLDER_IMAGE_ID );
  $navItems[] = [
    'id' => $id,
    'title' => $title,
  ];
  $permalink = $postID ? get_permalink( $postID ) : false;
  ob_start();
  ?>
  <article class="logistics-solutions__item">
    <?= wp_get_attachment_image( $imgID, 'large', false, [ 'class' => 'logistics-solutions__item-img' ]) ?>
    <div class="logistics-solutions__item-content">
      <h3 class="logistics-solutions__item-title"><?= esc_html( $title ) ?></h3>
      <div class="logistics-solutions__item-description"><?= wp_kses_post( $logisticsSolution['description'] ) ?></div>
      
      <?php 
        if( $permalink ) {
          get_template_part( 'gpw-templates/global/gpw-button', null, [
            'label' => __('Tìm hiểu thêm', GPW_TEXT_DOMAIN),
            'url' => $permalink,
            'style' => 'primary',
          ]); 
        }
      ?>

    </div>
  </article>
  <?php
  $panelItems[] = [
    'id' => $id,
    'content' => ob_get_clean(),
  ];
}
?>
<section class="logistics-solutions">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?php esc_html_e( $sectionData['title']) ?></h2>
    <?php if( !empty( $sectionData['description'] ) ) : ?>

      <div class="section__description">
        <?= wp_kses_post( $sectionData['description'] ) ?>
      </div>

    <?php endif ?>

    <div class="logistics-solutions__tabs tabs">

      <?php get_template_part( 'gpw-templates/global/tabs/tabs-nav', null, ['nav_items' => $navItems, 'style' => 'underline' ] ) ?>
      <?php get_template_part( 'gpw-templates/global/tabs/tabs-content', null, ['panels' => $panelItems ] ) ?>

    </div>
  </div>
</section>
<?php
// ! Cleanup variables
unset( $sectionData, $navItems, $panelItems, $logisticsSolution, $id );