<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Core value section
 */
use gpweb\inc\base\Utilities as Utils;
$sectionData = get_field('core_value', get_the_ID());
if (empty($sectionData['tabs'])) {
  do_action('qm/error', 'Core value section: Missing data');
  return;
}
$tabNavItems = [];
$tabNavPanels = [];
foreach( $sectionData['tabs'] as $idx => $tabData ) {
  $id = "core-value-tabs-$idx";
  $tabNavItems[] = [
    'id' => $id,
    'title' => $tabData['title'],
  ];
  $tabNavPanels[] = [
    'id' => $id,
    'content' => $tabData['content'],
  ];
}
$btnUrl = Utils::getUrl($sectionData['link_to']);
?>
<section class="core-value">
  <div class="section__inner">
    <div class="core-value__image-wrapper">
      <?= wp_get_attachment_image( $sectionData['left_side_image'] ?: PLACEHOLDER_IMAGE_ID, 'medium_large', false, ['class' => 'core-value__image']) ?>
    </div>
    <div class="core-value__content">
      <h2 class="section__title section__title--center section__title--has-separator">
        <?= wp_kses_post($sectionData['title']) ?>
      </h2>
      <?php if( !empty( $sectionData['description' ] ) ): ?>

        <div class="core-value__description">

          <?= wp_kses_post( $sectionData['description'] ) ?>

        </div>

      <?php endif ?>
      <div class="core-value__tabs tabs">

        <?php get_template_part('gpw-templates/global/tabs/tabs-nav', null, [ 'nav_items' => $tabNavItems]); ?>

        <?php get_template_part('gpw-templates/global/tabs/tabs-content', null, [ 'panels' => $tabNavPanels ]); ?>

      </div>

      <?php if ( $sectionData['link_to']['label'] && $btnUrl ) {
        get_template_part( 'gpw-templates/global/gpw-button', null, [
          'label' => $sectionData['link_to']['label'],
          'url' => $btnUrl,
          'style' => 'secondary',
          'icon_code' => 'arrow_circle_right',
        ]);
      } ?>
    </div>
  </div>
</section>
<?php
// ! Clean up variables
unset($sectionData);