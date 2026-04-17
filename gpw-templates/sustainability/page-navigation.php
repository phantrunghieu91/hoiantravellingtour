<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Sustainability page - Page navigation
 */
$navItems = isset( $args['nav_items'] ) ? $args['nav_items'] : [];
if( empty( $navItems ) ) {
    return;
}
?>
<nav class="page-nav">
  <ul class="page-nav__list">
    <?php foreach( $navItems as $navItem ) : ?>
      <li class="page-nav__item" data-target="<?= esc_attr( $navItem['id'] ) ?>"><?= esc_html( $navItem['label'] ) ?></li>
    <?php endforeach ?>
  </ul>
</nav>