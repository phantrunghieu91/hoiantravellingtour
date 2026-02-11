<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home Page - Statistic Section
 */
use gpweb\inc\base\Utilities as Utils;
$sectionData = get_field('statistic', get_the_ID());
if( empty( $sectionData['numbers'] ) ) {
  error_log('Statistic Section: No numbers found.');
  return;
}
$hasVideo = ($sectionData['video_type'] == 'upload_video' && !empty( $sectionData['upload_video'] )) || ($sectionData['video_type'] == 'youtube' && !empty( $sectionData['youtube'] ));
$sectionBgID = !empty( $sectionData['section_background_image'] ) ? $sectionData['section_background_image'] : false;
$contentBgImgID = isset( $sectionData['content']) && !empty( $sectionData['content']['background_image'] ) ? $sectionData['content']['background_image'] : false;
$sectionSubTitle = isset( $sectionData['content'] ) && !empty( $sectionData['content']['sub_title'] ) ? $sectionData['content']['sub_title'] : false;
$sectionTitle = isset( $sectionData['content'] ) && !empty( $sectionData['content']['title'] ) ? $sectionData['content']['title'] : false;
$sectionDesc = isset( $sectionData['content'] ) && !empty( $sectionData['content']['description'] ) ? $sectionData['content']['description'] : false;
$trustScoreLabel = isset( $sectionData['trust_score'] ) && !empty( $sectionData['trust_score']['label'] ) ? $sectionData['trust_score']['label'] : false;
$trustScoreQuoteImgID = isset( $sectionData['trust_score'] ) && !empty( $sectionData['trust_score']['quote_image'] ) ? $sectionData['trust_score']['quote_image'] : false;
$trustScoreBgImgID = isset( $sectionData['trust_score'] ) && !empty( $sectionData['trust_score']['background_image'] ) ? $sectionData['trust_score']['background_image'] : false;
$horizontalArrowImgID = 635;
$verticalArrowImgID = 636;
$verticalDotLineImgID = 638;
?>
<section class="statistic">
  <div class="section__inner section__inner--full">

    <?php if( $sectionBgID ) {
      echo wp_get_attachment_image( $sectionBgID, 'full', false, [ 'class' => 'statistic__section-bg' ] );
    } ?>

    <button class="statistic__video-btn"><span class="material-symbols-outlined">play_arrow</span></button>

    <div class="statistic__content" <?php if( $contentBgImgID ) echo sprintf('style="--_content-background-image:url(%s);"', wp_get_attachment_url( $contentBgImgID, 'full' )); ?>>
      
      <?php if( $sectionSubTitle ) : ?>
        <span class="section__sub-title"><?= esc_html( $sectionSubTitle ); ?></span>
      <?php endif; ?>

      <?php if( $sectionTitle ) : ?>
        <h2 class="section__title"><?= esc_html( $sectionTitle ); ?></h2>
      <?php endif; ?>

      <?php if( $sectionDesc ) : ?>
        <div class="section__description"><?= wp_kses_post( $sectionDesc ) ?></div>
      <?php endif ?>

      <div class="statistic__numbers">
  
        <?php foreach( $sectionData['numbers'] as $number ) :
          $numberValue = !empty( $number['number'] ) ? $number['number'] : '';
          $numberLabel = !empty( $number['label'] ) ? $number['label'] : '';
          $numberInt = intval( $numberValue );
          // replace number with empty string to get only the string part
          $numberText = str_replace( $numberInt, '', $numberValue );
          
          $steps = $numberInt >= 1000 ? 100 : ( $numberInt >= 100 ? 10 : 1 );
          $startingValue = $numberInt >= 1000 ? 100 : ( $numberInt >= 100 ? 10 : 1 );
        ?>
  
          <div class="statistic__number">
            <div class="statistic__number-value">
              <span class="statistic__number-int" data-step="<?php esc_attr_e($steps) ?>" data-start="<?php esc_attr_e($startingValue) ?>"><?= esc_html( $numberInt ); ?></span><span class="statistic__number-suffix"><?= esc_html( $numberText ); ?></span>
            </div>
            <span class="statistic__number-label"><?= esc_html( $numberLabel ); ?></span>
          </div>
  
        <?php endforeach ?>
  
      </div>

    </div>

    <div class="statistic__trust-score" <?php if( $trustScoreBgImgID ) echo sprintf('style="--_trust-background-image:url(%s);"', wp_get_attachment_url( $trustScoreBgImgID, 'full' )); ?>>
      
      <?php if( $trustScoreQuoteImgID ) {
        echo wp_get_attachment_image( $trustScoreQuoteImgID, 'thumbnail', false, [ 'class' => 'statistic__trust-score-quote-img' ] );
      } ?>
      
      <?php if( $trustScoreLabel ) : ?>
        <span class="statistic__trust-score-label"><?= esc_html( $trustScoreLabel ); ?></span>
      <?php endif; ?>

      <ul class="statistic__stars">
        <?php for( $i = 0; $i < 5; $i++ ) : ?>
          <li class="statistic__star">
            <span class="material-symbols-outlined"><?= $i < 4 ? 'star' : 'star_half' ?></span>
          </li>
        <?php endfor; ?>
      </ul>

    </div>

    <?= wp_get_attachment_image( $horizontalArrowImgID, 'full', false, [ 'class' => 'statistic__horizontal-arrow', 'alt' => 'Floating image' ] ) ?>
    <?= wp_get_attachment_image( $verticalArrowImgID, 'full', false, [ 'class' => 'statistic__vertical-arrow', 'alt' => 'Floating image' ] ) ?>
    <?= wp_get_attachment_image( $verticalDotLineImgID, 'full', false, [ 'class' => 'statistic__vertical-dot-line', 'alt' => 'Floating image' ] ) ?>

    <?php if( $hasVideo ) {
      echo '<dialog class="statistic__video-dialog">';

        if( $sectionData['video_type'] == 'upload_video' && !empty( $sectionData['upload_video'] ) ) {
          Utils::renderVideoBlock( $sectionData['upload_video'], '', false );
        } elseif( $sectionData['video_type'] == 'youtube' && !empty( $sectionData['youtube'] ) ) {
          Utils::renderYoutubeEmbed( $sectionData['youtube_link'], false );
        }

      echo '</dialog>';
    } ?>

  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData, $hasVideo, $number, $numberValue, $numberLabel, $trustScoreLabel, $trustScoreQuoteImgID, $trustScoreBgImgID, $contentBgImgID, $sectionSubTitle, $sectionTitle, $sectionDesc, $horizontalArrowImgID, $verticalArrowImgID, $verticalDotLineImgID );
?>