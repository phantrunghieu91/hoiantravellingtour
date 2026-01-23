<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Careers page - About us section
 */
$sectionData = get_field('about_us', get_the_ID());
if( empty( $sectionData ) ) {
  do_action('qm/debug', 'About us section data is empty.');
  return;
}
foreach( $sectionData as $item ) {
  $title = $item['title'];
  $content = $item['content'];
  $imgID = $item['image'] ?: PLACEHOLDER_IMAGE_ID;
  $id = sanitize_title( $title );
  $tabNavItems[] = [
    'id' => $id,
    'title' => $title,
  ];
  ob_start();
  ?>
  <article class="about-us__item">
    <?= wp_get_attachment_image( $imgID, 'large', false, ['class' => 'about-us__item-img']) ?>
    <div class="about-us__item-content"><?= wp_kses_post( $content ) ?></div>
  </article>
  <?php
  $tabNavPanels[] = [
    'id' => $id,
    'content' => ob_get_clean(),
  ];
}
?>
<section class="about-us tabs">
  <div class="section__inner section__inner--full">

    <?php get_template_part('gpw-templates/global/tabs/tabs-nav', null, [ 'nav_items' => $tabNavItems, 'style' => 'underline']); ?>

    <?php get_template_part('gpw-templates/global/tabs/tabs-content', null, [ 'panels' => $tabNavPanels ]); ?>

  </div>
</section>
<?php
// ! Cleanup variables
unset( $sectionData );