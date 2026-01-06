<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Post - Post content
 */
?>
<section class="post-content">
  <div class="section__inner">
    <!-- check sidebar exist -->
    <?php if( is_active_sidebar( 'sidebar-main' ) ) : ?>
    
      <aside class="post-content__sidebar">
        <div class="post-content__sidebar-inner"><?php dynamic_sidebar( 'sidebar-main' ); ?></div>
      </aside>

      <main class="post-content__content"><?php the_content(); ?></main>

    <?php endif ?>
  </div>
</section>