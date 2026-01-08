<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: SINGLE LOGISTICS SOLUTION - Why choose us section
 */
$sectionData = get_field( 'why_choose_us', get_the_ID());
if( empty($sectionData['reason']) ) {
  do_action( 'qm/error', 'No Why Choose Us section data found for Logistics Solution ID ' . get_the_ID() );
  return;
}
?>
<section class="why-choose-us">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?php esc_html_e( $sectionData['title'] ) ?></h2>
    <ul class="why-choose-us__reasons">

      <?php foreach( $sectionData['reason'] as $reason ): ?>

        <li class="why-choose-us__reason">
          <figure class="why-choose-us__reason-icon-wrapper">
            <?= wp_get_attachment_image( $reason['icon'], 'medium', false, [ 'class' => 'why-choose-us__reason-icon' ] ) ?>
          </figure>
          <span class="why-choose-us__reason-label"><?php esc_html_e( $reason['label'] ) ?></span>
        </li>

      <?php endforeach ?>

    </ul>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData, $reason );