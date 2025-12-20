<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Our solutions section
 */
use gpweb\inc\base\Utilities as Utils;
$sectionData = get_field( 'our_solutions', get_the_ID());
if( empty( $sectionData['solution'] ) ) {
  do_action('qm/error', 'Our solutions section: Missing data' );
  return;
}
?>
<section class="our-solutions">
  <div class="section__inner">
    <h2 class="section__title section__title--center section__title--has-separator"><?= wp_kses_post( $sectionData['title'] ) ?></h2>
    <div class="our-solutions__grid">
      <?php foreach( $sectionData['solution'] as $solution ) : 
        $url = Utils::getUrl( $solution['link_to'] );
        $title = $solution['link_to']['label'];
        $slug = sanitize_title( $title );  
        $imgID = $solution['image'] ?? PLACEHOLDER_IMAGE_ID;
      ?>

        <a class="our-solution <?= esc_attr($slug) ?>" href="<?= $url ?>">
          
          <?= wp_get_attachment_image( $imgID, 'medium', false, ['class' => 'our-solution__image'] ) ?>

          <div class="our-solution__content">

            <h3 class="our-solution__title"><?= esc_html( $title ) ?></h3>

          </div>

        </a>

      <?php endforeach ?>
    </div>
  </div>
</section>
<?php 
// ! Clean up variables
unset( $sectionData, $solution, $url, $title, $slug, $imgID );