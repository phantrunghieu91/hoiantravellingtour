<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About page - Team members section
 */
$sectionData = get_field('team_members', get_the_ID() );
if( empty($sectionData['member']) ) {
  do_action('qm/debug', 'TEAM MEMBERS: No members data found');
  return;
}
?>
<section class="team-members">
  <div class="section__inner">
    <?php if( !empty( $sectionData['sub_title'] )): ?>
      <span class="section__sub-title section__sub-title--center"><?php esc_html_e( $sectionData['sub_title'] ); ?></span>
    <?php endif ?>
    <?php if( !empty( $sectionData['title'] )): ?>
      <h2 class="section__title section__title--center section__title--has-separator"><?= wp_kses_post( $sectionData['title'] ); ?></h2>
    <?php endif ?>
    <?php if( !empty( $sectionData['description'] )): ?>
      <div class="section__description section__description--center"><?= wp_kses_post( $sectionData['description'] ); ?></div>
    <?php endif ?>
    <div class="team-members__grid">
      
      <?php foreach( $sectionData['member'] as $member ) :
        $avatarID = $member['avatar'] ?: PLACEHOLDER_IMAGE_ID;
        $name = $member['name'] ?: false;
        $position = $member['position'] ?: false;
        $quote = $member['quote'] ?: false;
      ?>

        <article class="team-member">
          <?= wp_get_attachment_image( $avatarID, 'medium_large', false, ['class' => 'team-member__avatar', 'alt' => $name]) ?>
          <div class="team-member__content">
            <?php if( !empty( $name )): ?>
            <h3 class="team-member__name"><?php esc_html_e( $name ); ?></h3>
            <?php endif; ?>
            <?php if( !empty( $position )): ?>
            <span class="team-member__position"><?php esc_html_e( $position ); ?></span>
            <?php endif; ?>
            <?php if( !empty( $quote )): ?>
              <div class="team-member__quote"><?= wp_kses_post( $quote ) ?></div>
            <?php endif; ?>
          </div>
        </article>

      <?php endforeach ?>

    </div>
  </div>
</section>