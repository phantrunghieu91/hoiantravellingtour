<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: About us page - Offices map section
 */
$companyInfo = gpweb\inc\controller\CompanyInfo::getInstance();
$offices = $companyInfo->getOffice();
$mapImageID = 2739;
$slideItems = [];
foreach( $offices as $office ): ob_start(); ?>
  <article class="office">
    <?= wp_get_attachment_image( $office['image'], 'medium', false, [ 'class' => 'office__image', 'alt' => $office['name'] ]) ?>
    <div class="office__content">
      <h4 class="office__name"><?= esc_html( $office['name']) ?></h4>
      <p class="office__address"><?= esc_html( $office['address'] ) ?></p>
    </div>
  </article>
<?php $slideItems[] = ob_get_clean(); endforeach ?>

<section class="offices-map" style="--_background-image-url:url(<?= esc_attr(wp_get_attachment_image_url( $mapImageID, 'full' )) ?>);">
  <div class="section__inner section__inner--full">
    <div class="offices-map__carousel">
      <?php get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $slideItems, 'has_nav' => true ]) ?>
    </div>
  </div>
</section>