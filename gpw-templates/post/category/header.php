<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: POST CATEGORY - Header
 */
if( !is_home() && !is_category() ) {
  return is_user_logged_in() && current_user_can('manage_options') 
    ? wp_die( esc_html__( 'CATEGORY HEADER: This template can only be used in category archive pages.', GPW_TEXT_DOMAIN ) ) 
    : '';
}
?>
<header class="category-header">
  <div class="section__inner">
    <h1 class="category-header__title">
      <?= is_home() ? __( "Blog ", GPW_TEXT_DOMAIN ) . get_bloginfo( 'name' ) : single_cat_title(); ?>
    </h1>
  </div>
</header>