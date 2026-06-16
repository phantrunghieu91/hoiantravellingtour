<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Destination section
 */
$homePageID = get_option('page_on_front');
$sectionData = get_field('destination', $homePageID);
if (empty($sectionData['title'])) {
    do_action('qm/debug', 'HOME PAGE - Destination section: Missing data!');
    return;
}
$mapImageId = 2778;
?>
<section class="destination">
  <div class="section__inner">
    <?php if (!empty($sectionData[ 'title' ])) : ?>
      <header class="destination__header">
        <?= sprintf('<h2 class="section__title section__title--center section__title--has-separator">%s</h2>', wp_kses_post($sectionData['title'])); ?>
        <?php if (!empty($sectionData['description'])) {
            echo sprintf('<div class="section__description section__description--center">%s</div>', wp_kses_post($sectionData['description']));
        } ?>
      </header>
    <?php endif ?>
    <main class="destination__main">
      <svg viewBox="0 0 2400 1200" fill="none" xmlns="https://www.w3.org/2000/svg" class="destination__map">
        <image x="0" y="0" href="https://3alogistics.vn/wp-content/uploads/2026/05/destination-world-map.webp" />
        <g class="lines">
          <path d="M 323 380 C 429 345 822 622 853 668" stroke="var(--secondary-color-500)" stroke-width="3" stroke-dasharray="5 5" class="line europe" />
          <path d="M 844 530 C 772 493 839 661 853 668" stroke="var(--secondary-color-500)" stroke-width="3" stroke-dasharray="5 5" class="line china" />
          <path d="M 323 712 C 500 629 727 638 853 668" stroke="var(--secondary-color-500)" stroke-width="3" stroke-dasharray="5 5" class="line africa" />
          <path d="M 1018 905 C 1046 870 949 683 853 668" stroke="var(--secondary-color-500)" stroke-width="3" stroke-dasharray="5 5" class="line asia-pacific" />
          <path d="M 1780 310 C 1529 225 898 303 853 668" stroke="var(--secondary-color-500)" stroke-width="5" stroke-dasharray="8 8" class="line cananda" />
          <path d="M 1795 480 C 1500 386 985 469 853 668" stroke="var(--secondary-color-500)" stroke-width="5" stroke-dasharray="8 8" class="line america" />
          <path d="M 2098 848 C 1752 668 1033 600 853 668" stroke="var(--secondary-color-500)" stroke-width="5" stroke-dasharray="8 8" class="line south-america" />
        </g>
      </svg>
    </main>
  </div>
</section>