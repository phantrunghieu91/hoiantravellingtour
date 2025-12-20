<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Hero section with content
 */
use gpweb\inc\base\Utilities as Utils;
$heroData = get_field( 'hero', get_the_ID() );
if( !$heroData || empty($heroData['background_video']) ) {
  do_action('qm/error', 'Hero section: Missing background video' );
  return;
}
$url = Utils::getUrl($heroData['link_to']);
?>
<section class="hero hero--with-content">
  <div class="section__inner section__inner--full">

    <?php Utils::renderVideoBlock($heroData['background_video'], 'hero__background-video') ?>

    <div class="hero__content">
      <?php if( !empty($heroData['sub_title']) ): ?>
        <span class="hero__sub-title"><?= esc_html($heroData['sub_title']) ?></span>
      <?php endif; ?>
      
      <h1 class="hero__title"><?= esc_html($heroData['title']) ?></h1>

      <?php if( !empty($heroData['description']) ): ?>

        <div class="hero__description"><?= esc_html($heroData['description']) ?></div>

      <?php endif; ?>

      <?php if( $heroData['link_to']['label'] && $url ) {
        get_template_part( 'gpw-templates/global/gpw-button', null, [
          'label' => $heroData['link_to']['label'],
          'url' => $url,
          'style' => 'secondary',
          'icon_code' => 'arrow_circle_right',
        ]);
      } ?>

    </div>
  </div>
</section>