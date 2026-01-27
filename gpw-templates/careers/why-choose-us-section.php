<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Career page - Why choose us section
 */
$sectionData = get_field('why_choose_us', get_the_ID());
if( empty( $sectionData[ 'reason' ] )) {
  do_action('qm/debug', 'No reasons found for Why Choose Us section.');
  return;
}
?>
<section class="why-choose-us">
  <div class="section__inner">
    <h2 class="section__title section__title--center"><?= esc_html($sectionData['title']) ?></h2>
    <?php if( !empty( $sectionData['description'] ) ): ?>

      <div class="section__description section__description--center"><?= wp_kses_post($sectionData['description']) ?></div>

    <?php endif ?>
    <ul class="why-choose-us__reasons">

      <?php foreach( $sectionData['reason'] as $reason ): ?>

        <li class="why-choose-us__reason">
          <?= wp_get_attachment_image( $reason['icon'], 'medium', false, ['class' => 'why-choose-us__reason-icon']) ?>
          <span class="why-choose-us__reason-label"><?= esc_html($reason['label']) ?></span>
        </li>

      <?php endforeach ?>

    </ul>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData, $reason );