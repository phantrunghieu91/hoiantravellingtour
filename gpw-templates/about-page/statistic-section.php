<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Statistic section
 */
$frontPageID = get_option( 'page_on_front' );
$sectionData = get_field( 'statistic', $frontPageID );
if( empty( $sectionData['numbers'] ) ) {
  error_log('About page - Statistic Section: No numbers found.');
  return;
}
?>
<section class="statistic">
  <div class="section__inner section__inner--full">
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
unset( $frontPageID, $sectionData );