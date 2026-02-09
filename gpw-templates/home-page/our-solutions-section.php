<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Our solutions section
 */
use gpweb\inc\base\Utilities as Utils;
$sectionData = get_field('our_solutions', get_the_ID());
if (empty($sectionData['solution'])) {
  do_action('qm/error', 'Our solutions section: Missing data');
  return;
}
foreach ($sectionData['solution'] as $solution):
  $url = Utils::getUrl($solution['link_to']);
  $title = $solution['link_to']['label'];
  $slug = sanitize_title($title);
  $imgID = $solution['image'] ?? PLACEHOLDER_IMAGE_ID;
  ob_start();
  ?>

  <a class="our-solution <?= esc_attr($slug) ?>" href="<?= $url ?>">

    <?= wp_get_attachment_image($imgID, 'medium', false, ['class' => 'our-solution__image']) ?>

    <div class="our-solution__content">

      <h3 class="our-solution__title"><?= esc_html($title) ?></h3>

    </div>

  </a>

<?php 
  $slideItems[] = ob_get_clean();
endforeach;
?>
<section class="our-solutions">
  <div class="section__inner section__inner--full">
    <div class="our-solutions__header">
      <h2 class="section__title section__title--has-separator">
        <?= wp_kses_post($sectionData['title']) ?>
      </h2>
      <div class="our-solutions__navigators">
        <a class="gpw-nav-btn gpw-nav-btn__prev" role="button" aria-label="Previous slide">
          <span class="material-symbols-outlined">chevron_left</span>
        </a>
        <a class="gpw-nav-btn gpw-nav-btn__next" role="button" aria-label="Next slide">
          <span class="material-symbols-outlined">chevron_right</span>
        </a>
      </div>
    </div>
    <div class="our-solutions__carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems, 'has_pagination' => true ] ) ?>
    </div>
  </div>
</section>
<?php
// ! Clean up variables
unset($sectionData, $slideItems, $solution, $url, $title, $slug, $imgID);