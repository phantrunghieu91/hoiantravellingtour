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
      <li class="page-nav__item">
        <a href="#<?= esc_attr( $navItem['id'] ) ?>" class="page-nav__link"><?= esc_html( $navItem['label'] ) ?></a>
      </li>
    <?php endforeach ?>
  </ul>
</nav>