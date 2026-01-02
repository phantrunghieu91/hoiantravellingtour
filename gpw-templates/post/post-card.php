<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Post - Post card
 * ! Args:
 *  - orientation: 'vertical' | 'horizontal' (default: 'vertical')
 *  - show_category: bool (default: false)
 *  - show_excerpt: bool (default: true)
 *  - is_featured: bool (default: false)
 *  - is_template: bool (default: false)
 *  - footer_display: 'none' | 'meta' | 'read-more' (default: 'none')
 */
$orientation = $args['orientation'] ?? 'vertical';
$showExcerpt = $args['show_excerpt'] ?? true;
$showCategory = $args['show_category'] ?? false;
$isFeatured = $args['is_featured'] ?? false;
$footerDisplay = $args['footer_display'] ?? 'none';
$isTemplate = $args['is_template'] ?? false;

$postID = get_the_ID();
$title = get_the_title();
$excerpt = get_the_excerpt();
$permalink = get_permalink();
$authorName = get_the_author();
$publishDate = get_the_date( 'F j, Y' );
$featuredImageID = get_post_thumbnail_id() ?: PLACEHOLDER_IMAGE_ID;
$categories = get_the_category();
$primaryCategory = get_post_meta( $postID, 'rank_math_primary_category', true );
$primaryCategory = $primaryCategory 
  ? get_term( $primaryCategory ) 
  : ( has_category() ? $categories[0] : null );

$classes = [ 'post-card', "post-card--{$orientation}" ];
$classes[] = $isTemplate ? 'post-card--template' : "post-card--{$postID}";

if( $isFeatured ) {
  $classes[] = 'post-card--featured';
}
?>
<?php if( $isTemplate ) {
  echo '<template class="post-card__template">';
} ?>
<article class="<?= esc_attr( implode( ' ', $classes ) ) ?>" 
  <?php if( !$isTemplate ) echo sprintf('data-cat="%s"', esc_attr( implode( ',', wp_list_pluck( $categories, 'term_id' ) ) ) ) ?>
>
  <a href="<?= esc_url( $permalink ) ?>" class="post-card__thumbnail">
    <?= $isTemplate ? '<img src="" alt="" class="post-card__image" />'
      : wp_get_attachment_image( $featuredImageID, 'medium_large', false, [ 'class' => 'post-card__image', 'alt' => esc_attr( $title ) ] ) ?>
  </a>
  <div class="post-card__content">
    <?php if( $showCategory && $primaryCategory ) {
      echo $isTemplate ? ''
        : sprintf('<a href="%s" class="post-card__category">%s</a>',
            esc_url( get_category_link( $primaryCategory->term_id ) ),
            esc_html( $primaryCategory->name )
          );
    } ?>

    <h3 class="post-card__title line-clamp">

      <?= sprintf('<a href="%s">%s</a>', 
        $isTemplate ? '' : esc_url( $permalink ), 
        $isTemplate ? '' : esc_html( $title ) ) ?>

    </h3>
    <?php if ( $showExcerpt && !empty( $excerpt ) ): ?>
      <div class="post-card__excerpt line-clamp">
        <?= $isTemplate ? '' : esc_html( $excerpt ) ?>
      </div>
    <?php endif; ?>
    <?php if( $footerDisplay === 'read-more' ): ?>

      <a href="<?= $isTemplate ? '' : esc_url( $permalink ) ?>" class="post-card__read-more">
        <span><?php esc_html_e( 'Read More', 'gpw' ); ?></span>
        <span class="material-symbols-outlined">arrow_right_alt</span>
      </a>

    <?php elseif( $footerDisplay === 'meta' ): ?>

      <ul class="post-card__meta">
        <li class="post-card__meta-item author"><?= $isTemplate ? '' : esc_html( $authorName ) ?></li>
        <li class="post-card__meta-item date"><?= $isTemplate ? '' : esc_html( $publishDate ) ?></li>
      </ul>

    <?php endif ?>
  </div>
</article>
<?php 
if( $isTemplate ) {
  echo '</template>';
}

// ! Cleanup variables
unset( $postID, $title, $excerpt, $permalink, $featuredImageID, $authorName, $publishDate, $orientation, $showExcerpt, $isFeatured, $footerDisplay, $classes );