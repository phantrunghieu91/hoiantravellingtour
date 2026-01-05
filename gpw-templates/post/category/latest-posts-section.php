<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: POST CATEGORY - Latest posts section
 */
if( !have_posts() ) {
  return is_user_logged_in() && current_user_can( 'manage_options' )
    ? wp_die( esc_html__( 'LATEST POSTS SECTION: No posts found in this category.', GPW_TEXT_DOMAIN ) )
    : '';
}
?>
<section class="latest-posts">
  <div class="section__inner">

  <?php $postCount = 0; 
  while( have_posts() ) {
    if( $postCount >= 5 ) {
      break;
    }
    the_post();
    $postCardArgs = [
      'orientation' => 'horizontal',
      'show_category' => true,
      'show_excerpt' => false,
      'footer_display' => 'meta',
    ];
    if( $postCount === 0 ) {
      $postCardArgs = array_merge( $postCardArgs, [ 'show_excerpt' => true, 'is_featured' => true, 'orientation' => 'vertical']);
    }
    get_template_part( 'gpw-templates/post/post-card', null, $postCardArgs );
    $postCount++; 
  } 
   wp_reset_postdata() ?>

  </div>
</section>