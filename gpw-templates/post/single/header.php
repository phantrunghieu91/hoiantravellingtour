<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Post - Header
 */
$title = get_the_title();
$featuredImageID = get_post_thumbnail_id() ?: PLACEHOLDER_IMAGE_ID;
$categories = get_the_category( $postID );
$primaryCategory = get_post_meta( $postID, 'rank_math_primary_category', true );
$primaryCategory = $primaryCategory 
  ? get_term( $primaryCategory ) 
  : ( has_category( '', $postID ) ? $categories[0] : null );
$authorName = get_the_author_meta( 'display_name', get_post_field( 'post_author', $postID ) );
?>
<header class="single-post-header">
  <div class="section__inner">
    <div class="single-post-header__content">
      <a href="<?= get_term_link( $primaryCategory ) ?>" class="single-post-header__category"><?= esc_html( $primaryCategory->name ) ?></a>
      <h1 class="single-post-header__title"><?= esc_html( $title ) ?></h1>
      <p class="single-post-header__author">
        <span class="material-symbols-outlined">star</span>
        <span><?= esc_html( $authorName ) ?></span>
      </p>
    </div>
    <?= wp_get_attachment_image( $featuredImageID, 'large', false, [ 'class' => 'single-post-header__image', 'alt' => $title ]) ?>
  </div>
</header>
<?php 
// ! Cleanup variables
unset( $title, $featuredImageID, $categories, $primaryCategory );