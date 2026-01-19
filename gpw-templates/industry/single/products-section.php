<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: INDUSTRY SINGLE - Products section
 */
$sectionData = get_field('products', get_the_ID());
if( empty( $sectionData['product'] )) {
  do_action('qm/debug', 'Industry single - Products section: No product data found!!');
  return;
}
?>
<section class="products">
  <div class="section__inner">
    <h2 class="section__title">
      <?php esc_html_e( $sectionData['title'] ) ?>
    </h2>
    <?php if( !empty( $sectionData['description'] ) ) : ?>

      <div class="section__description">
        <?= wp_kses_post( $sectionData['description'] ) ?>
      </div>

    <?php endif ?>
    <div class="products__carousel">
      <?php foreach( $sectionData['product'] as $product ) {
        $title = $product['title'];
        $imageIds = $product['images'];
        if( empty($imageIds) ) {
          continue;
        }
        ob_start();
        ?>

        <article class="product">
          <div class="product__images-carousel">
            <?php 
            $productImageItems = [];
            foreach( $imageIds as $imageId ) {
              $productImageItems[] = wp_get_attachment_image( $imageId, 'medium_large', false, [ 'class' => 'product__image' ] );
            }
            get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $productImageItems, 'has_nav' => true, 'has_pagination' => true ] );
            ?>
          </div>
          <h3 class="product__title"><?php esc_html_e( $title ) ?></h3>
        </article>

        <?php $productSlideItems[] = ob_get_clean();
      }
      get_template_part( 'gpw-templates/global/swiper-template', null, [ 'slide_items' => $productSlideItems, 'has_nav' => true, 'has_pagination' => true ] ); 
      ?>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $sectionData );