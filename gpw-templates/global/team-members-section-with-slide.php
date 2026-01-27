<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Global - Team members section with slides
 */
$sectionData = get_field('team_members', 'gpw_settings');
if (empty($sectionData['member'])) {
  do_action('qm/debug', 'TEAM MEMBERS WITH SLIDE: No members data found');
  return;
}
$mainSlideItems = [];
$thumbSlideItems = [];
foreach ($sectionData['member'] as $member) {
  $avatarID = $member['avatar'] ?: PLACEHOLDER_IMAGE_ID;
  $name = $member['name'] ?: false;
  $position = $member['position'] ?: false;
  $quote = $member['quote'] ?: false;
  ob_start();
  ?>
  <article class="team-members__info">
    <header class="team-members__info-header">
      <h3 class="team-members__info-name"><?= esc_html($name); ?></h3>
      <?php if (!empty($position)): ?>
        <span class="team-members__info-position"><?= esc_html($position); ?></span>
      <?php endif; ?>
    </header>
    <main class="team-members__info-quote"><?= wp_kses_post($quote); ?></main>
    <aside class="team-members__info-avatar">
      <?= wp_get_attachment_image( $avatarID, 'medium_large' ) ?>
    </aside>
  </article>
  <?php
  $mainSlideItems[] = ob_get_clean();
  ob_start();
  ?>
  <div class="team-members__thumb-avatar">
    <?= wp_get_attachment_image( $avatarID, 'medium', false, ['alt' => $name] ) ?>
  </div>
  <?php
  $thumbSlideItems[] = ob_get_clean();
}
?>
<section class="team-members">
  <div class="section__inner">
    <header class="team-members__header">
      <?php if (!empty($sectionData['sub_title'])): ?>
        <span
          class="section__sub-title"><?php esc_html_e($sectionData['sub_title']); ?></span>
      <?php endif ?>
      <?php if (!empty($sectionData['title'])): ?>
        <h2 class="section__title">
          <?= wp_kses_post($sectionData['title']); ?></h2>
      <?php endif ?>
      <?php if (!empty($sectionData['description'])): ?>
        <div class="section__description"><?= wp_kses_post($sectionData['description']); ?>
        </div>
      <?php endif ?>
    </header>
    <main class="team-members__main-carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $mainSlideItems, 'has_pagination' => true ]); ?>
    </main>
    <aside class="team-members__thumb-carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $thumbSlideItems, 'has_nav' => true ]); ?>
    </aside>
  </div>
</section>
<?php
// ! Cleanup variables
unset($sectionData);