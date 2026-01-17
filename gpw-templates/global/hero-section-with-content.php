<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Hero section with content
 */
use gpweb\inc\base\Utilities as Utils;
$heroData = get_field( 'hero', is_archive() ? 'gpw_settings' : get_the_ID() );
if( !$heroData || ( $heroData['video_type'] == 'upload' && empty($heroData['background_video']) ) && ( $heroData['video_type'] == 'youtube' && empty($heroData['background_video']['youtube_link']) ) ) {
  do_action('qm/error', 'Hero section: Missing background video' );
  return;
}
$url = isset($heroData['link_to']) ? Utils::getUrl($heroData['link_to']) : '';
$title = isset( $heroData['title'] ) && !empty( $heroData['title'] ) ? $heroData['title'] : ( is_archive() ? get_the_archive_title() : get_the_title() );
?>
<section class="hero hero--with-content">
  <div class="section__inner section__inner--full">

    <?php $heroData['video_type'] == 'upload' 
      ? Utils::renderVideoBlock($heroData['background_video'], 'hero__background-video') 
      : Utils::renderYoutubeEmbed( $heroData['youtube_link'], true, 'hero__background-video' ) ?>

    <div class="hero__content">
      <?php if( !empty($heroData['sub_title']) ): ?>
        <span class="hero__sub-title"><?= esc_html($heroData['sub_title']) ?></span>
      <?php endif; ?>
      
      <h1 class="hero__title"><?= esc_html($title) ?></h1>

      <?php if( !empty($heroData['description']) ): ?>

        <div class="hero__description"><?= esc_html($heroData['description']) ?></div>

      <?php endif; ?>

      <?php if( isset($heroData['link_tp']) && $heroData['link_to']['label'] && $url ) {
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