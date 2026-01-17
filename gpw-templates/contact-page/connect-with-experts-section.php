<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Contact page - Connect with experts section
 */
use gpweb\inc\base\Utilities as Utils;
$sectionData = get_field( 'connect_with_experts', get_the_ID() );
$imgID = !empty( $sectionData['image'] ) ? $sectionData['image'] : PLACEHOLDER_IMAGE_ID;
$url = isset( $sectionData['link_to'] ) ? Utils::getUrl( $sectionData['link_to'] ) : false;
?>
<section class="connect-with-expert">
  <div class="section__inner">
    <div class="connect-with-expert__wrapper">
      <?= wp_get_attachment_image( $imgID, 'medium_large', false, [ 'class' => 'connect-with-expert__image' ] ) ?>
      <div class="connect-with-expert__content">
        <h2 class="section__title"><?= esc_html( $sectionData['title'] ?? __('Connect with experts', GPW_TEXT_DOMAIN) ) ?></h2>
        
        <?php if( !empty( $sectionData['description'] )): ?>
          <div class="section__description"><?= wp_kses_post( $sectionData['description'] ) ?></div>
        <?php endif ?>
        
        <?php if( !empty( $sectionData['link_to']['label'] ) && !empty( $url ) ): ?>
          <a href="<?= $url ?>" class="gpw-button gpw-button__primary connect-with-expert__button" role="button">
            <span class="gpw-button__text"><?= esc_html( $sectionData['link_to']['label'] ) ?></span>
          </a>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData, $imgID, $url );