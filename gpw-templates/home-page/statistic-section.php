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
?>
<section class="statistic">
  <div class="section__inner section__inner--full">

    <?php if( $hasVideo ) {
      echo '<div class="statistic__video">';

        if( $sectionData['video_type'] == 'upload_video' && !empty( $sectionData['upload_video'] ) ) {
          Utils::renderVideoBlock( $sectionData['upload_video'], '', false );
        } elseif( $sectionData['video_type'] == 'youtube' && !empty( $sectionData['youtube'] ) ) {
          Utils::renderYoutubeEmbed( $sectionData['youtube_link'], false );
        }

        echo '<button class="statistic__video-btn"><span class="material-symbols-outlined">play_arrow</span></button>';

      echo '</div>';
    } ?>

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
</section>
<?php 
// ! Cleanup variables
unset( $sectionData, $hasVideo, $number, $numberValue, $numberLabel );
?>