<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Post - Post card
 */
$postID = get_the_ID();
$title = get_the_title();
$excerpt = get_the_excerpt();
$permalink = get_permalink();
$featuredImageID = get_post_thumbnail_id() ?: PLACEHOLDER_IMAGE_ID;
?>
<article class="post-card post-card--<?= esc_attr( $postID ) ?>">
  <a href="<?= esc_url( $permalink ) ?>" class="post-card__thumbnail">
    <?= wp_get_attachment_image( $featuredImageID, 'medium_large', false, [ 'class' => 'post-card__image', 'alt' => esc_attr( $title ) ] ) ?>
  </a>
  <div class="post-card__content">
    <h3 class="post-card__title line-clamp">
      <a href="<?= esc_url( $permalink ) ?>"><?= esc_html( $title ) ?></a>
    </h3>
    <?php if ( ! empty( $excerpt ) ): ?>
      <div class="post-card__excerpt line-clamp">
        <?= esc_html( $excerpt ) ?>
      </div>
    <?php endif; ?>
    <a href="<?= esc_url( $permalink ) ?>" class="post-card__read-more">
      <span><?php esc_html_e( 'Read More', 'gpw' ); ?></span>
      <span class="material-symbols-outlined">arrow_right_alt</span>
    </a>
  </div>
</article>
<?php 
// ! Cleanup variables
unset( $postID, $title, $excerpt, $permalink, $featuredImageID );