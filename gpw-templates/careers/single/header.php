<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single career page - Header
 */
$title = get_the_title();
$locationTerms = get_the_terms(get_the_ID(), 'work-location');
$locationName = !empty($locationTerms) && !is_wp_error($locationTerms) ? $locationTerms[0]->name : false;
$quantity = get_field('quantity', $jobID);
$deadline = get_field('application_deadline', $jobID);
$deadline = DateTime::createFromFormat('d/m/Y', $deadline)->format('F j, Y');
?>
<header class="single-career-header">
  <div class="section__inner">
    <h1 class="single-career-header__title"><?= esc_html($title) ?></h1>
    <ul class="single-career-header__meta">
      <li class="single-career-header__meta-item"><strong>Location:</strong> <?= esc_html($locationName) ?></li>
      <li class="single-career-header__meta-item"><strong>Quantity:</strong> <?= esc_html($quantity) ?></li>
      <li class="single-career-header__meta-item"><strong>Deadline:</strong> <?= esc_html($deadline) ?></li>
    </ul>
  </div>
</header>