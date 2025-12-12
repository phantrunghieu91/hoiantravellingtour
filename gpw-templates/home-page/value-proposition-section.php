<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Value Proposition Section
 */
$logisticSolutions = get_posts([
  'post_type' => 'logistic-solution',
  'numberposts' => -1,
  'orderby' => 'DATE',
  'order' => 'DESC',
]);
?>
<section class="value-proposition">
  <div class="section__inner">
    <?php dump($logisticSolutions) ?>
  </div>
</section>