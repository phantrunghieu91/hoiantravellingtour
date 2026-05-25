<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Hero section with content
 */
use gpweb\inc\base\Utilities as Utils;
$isArchive = is_archive();
$heroData = get_field( 'hero', $isArchive ? 'gpw_settings' : get_the_ID() );
if( !$heroData || ( empty( $heroData['banner']) ) &&
  ( $heroData['video_type'] == 'upload' && empty($heroData['background_video']) ) && ( $heroData['video_type'] == 'youtube' && empty($heroData['youtube_link']) ) ) {
  do_action('qm/error', 'Hero section: Missing background video' );
  return;
}
$splitTitle = isset( $args['split_title'] ) ? $args['split_title'] : false;
$url = isset($heroData['link_to']) ? Utils::getUrl($heroData['link_to']) : '';
$title = isset( $heroData['title'] ) && !empty( $heroData['title'] ) ? ($isArchive ? esc_html($heroData['title'][GPW_CURRENT_LANGUAGE]) : esc_html($heroData['title'])) : ( $isArchive ? get_the_archive_title() : get_the_title() );
if( $splitTitle ) {
  $words = explode( ' ', $title );
  $half  = (int) floor( count( $words ) / 2 );
  $title = sprintf(
    '<span>%s</span> <span>%s</span>',
    esc_html( implode( ' ', array_slice( $words, 0, $half ) ) ),
    esc_html( implode( ' ', array_slice( $words, $half ) ) )
  );
}
$subTitle = isset( $heroData['sub_title'] ) && !empty( $heroData['sub_title'] ) ? ($isArchive ? esc_html($heroData['sub_title'][GPW_CURRENT_LANGUAGE]) : esc_html($heroData['sub_title'])) : '';
$description = isset( $heroData['description'] ) && !empty( $heroData['description'] ) ? ($isArchive ? wp_kses_post($heroData['description'][GPW_CURRENT_LANGUAGE]) : wp_kses_post($heroData['description'])) : '';
?>
<section class="hero hero--with-content">
  <div class="section__inner section__inner--full">

    <?php if( !empty( $heroData['banner'] ) ) {
      echo wp_get_attachment_image( $heroData['banner'], 'full', false, [ 'class' => 'hero__background-image' ] );
    } else {
      echo $heroData['video_type'] == 'upload' 
      ? Utils::renderVideoBlock($heroData['background_video'], 'hero__background-video') 
      : Utils::renderYoutubeEmbed( $heroData['youtube_link'], true, 'hero__background-video' );
    } ?>

    <div class="hero__content">
      <?php if( !empty($subTitle) ): ?>
        <span class="hero__sub-title"><?= $subTitle ?></span>
      <?php endif; ?>
      
      <h1 class="hero__title"><?= $title ?></h1>

      <?php if( !empty($description) ): ?>

        <div class="hero__description"><?= $description ?></div>

      <?php endif; ?>

      <?php if( isset($heroData['link_to']) && $heroData['link_to']['label'] && $url ) {
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