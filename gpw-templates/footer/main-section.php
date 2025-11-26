<?php 
/**
 * @author Hieu "JIN" Phan Trung
 * * Template: Footer - Main Section
 */
$mainSectionData = get_field('main_section', 'gpw_settings');
$companyInfo = gpweb\inc\controller\CompanyInfo::getInstance();
$logo = $companyInfo->getDefaultLogo();
$logo = is_numeric($logo) 
  ? wp_get_attachment_image($logo, 'medium', false, ['class' => 'footer__logo'])
  : sprintf('<img src="%s" alt="%s" class="footer__logo" />', esc_url($logo), esc_attr(get_bloginfo('name')));
$phoneNumber = $companyInfo->getPhoneNumber();
$email = $companyInfo->getEmail();
$offices = $companyInfo->getOffice();
$socials = $companyInfo->getSocials();
$facebookEmbed = $companyInfo->getFacebookEmbed();
$mapEmbed = $companyInfo->getMainOfficeMap();
?>
<section class="footer__main">
  <div class="section__inner">

    <div class="footer__about">
      <?php if( isset( $mainSectionData['logo'] ) && !empty($mainSectionData['logo'])) {
        echo wp_get_attachment_image( $mainSectionData['logo'], 'medium', false, ['class' => 'footer__main-logo'] );
      } else {
        echo $logo;
      }?>
      <a class="footer__hotline" href="tel:<?= esc_attr($phoneNumber) ?>">
        <span class="material-symbols-outlined">call</span>
        <span><?= esc_html($phoneNumber) ?></span>
      </a>
      <a class="footer__email" href="mailto:<?= esc_attr($email) ?>">
        <span class="material-symbols-outlined">email</span>
        <span><?= esc_html($email) ?></span>
      </a>

      <?php if( !empty( $socials ) ) : ?>
        
        <ul class="footer__socials">

          <?php foreach( $socials as $social ): ?>

            <li class="footer__social">
              <a href="<?= $social['link'] != '' ? esc_url($social['link']) : 'javascript:void(0);' ?>" class="footer__social-link">
                <?= wp_get_attachment_image( $social['icon'], 'thumbnail', false, [ 'class' => 'footer__social-icon', 'alt' => $social['name'] ]) ?>
              </a>
            </li>

          <?php endforeach ?>

        </ul>
        
      <?php endif ?>

      <?php if( isset( $mainSectionData['certificate_image']) && !empty($mainSectionData['certificate_image']) ) {
        echo wp_get_attachment_image( $mainSectionData['certificate_image'], 'medium', false, ['class' => 'footer__certificate-image'] );
      } ?>
    </div>

    <?php if(!empty($offices) ): ?>

      <div class="footer__offices">

        <?php foreach( $offices as $office ): ?>

          <div class="footer__office">

            <h2 class="footer__office-name footer__title"><?= esc_html($office['name']) ?></h2>
            <p class="footer__office-address"><?= wp_kses_post( $office['address'] ) ?></p>

          </div>

        <?php endforeach ?>

      </div>

    <?php endif ?>

    <?php if( !empty($facebookEmbed) ) : ?>
      <div class="footer__facebook">
        <h2 class="footer__title"><?= __('Fanpage', GPW_TEXT_DOMAIN) ?></h2>
        
        <?= sprintf('<div class="footer__facebook-embed">%s</div>', $facebookEmbed ); ?>

        <?= sprintf('<div class="footer__main-office-map-embed">%s</div>', $mapEmbed ); ?>

      </div>
    <?php endif ?>
  </div>
</section>