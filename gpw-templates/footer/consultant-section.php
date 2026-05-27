<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: FOOTER - Consultant block
 */
$data = get_field( 'consultant_form', 'gpw_settings' );
?>
<section class="consultant">
  <div class="section__inner">
    <div class="consultant__image-wrapper">
      <svg class="consultant__arc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 100" width="250" height="500">
        <path d="M0,0 l50,0 q0,70 -40,100 l-10,0 z"/>
      </svg>
      <?= wp_get_attachment_image( $data['image'], 'medium_large', false, [ 'class' => 'consultant__image' ] ) ?>
    </div>
    <div class="consultant__content">
      <?php if( !empty( $data['title'][GPW_CURRENT_LANGUAGE])) : ?>
        <h2 class="consultant__title"><?= esc_html( $data['title'][GPW_CURRENT_LANGUAGE] ) ?></h2>
      <?php endif ?>

      <?php get_template_part( 'gpw-templates/global/gpw-button', null, [ 
        'style' => 'secondary',
        'label' => $data['button']['label'][GPW_CURRENT_LANGUAGE] ?: __('Contact now', 'gpw'),
        'url' => $data['button']['page_link'][GPW_CURRENT_LANGUAGE] ?: 'javascript:void(0);'
      ] ); ?>
    </div>

  </div>
</section>
<?php
// ! Cleanup variables
unset($contactPageID);