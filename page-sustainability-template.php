<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template name: Page Sustainability Template
 */
$fieldKeys = ['environment', 'social_governance', 'governance'];
$navItems = [];
$sections = [];
foreach( $fieldKeys as $fieldKey ) {
  $sectionData = get_field($fieldKey, get_the_ID());
  if( empty( $sectionData ) ) {
    continue;
  }
  $id = sanitize_title($sectionData['title']);
  $navItems[] = [
    'id' => $id,
    'label' => $sectionData['title'],
  ];
  $sections[] = [
    'key' => $fieldKey,
    'id' => $id,
    'data' => $sectionData,
  ];
}
get_template_part( 'gpw-templates/global/header' );

get_template_part( 'gpw-templates/global/hero-section', 'with-content', [ 'split_title' => true ] );

get_template_part( 'gpw-templates/sustainability/page-navigation', null, [ 'nav_items' => $navItems ] );

foreach( $sections as $section ) {
  get_template_part( 'gpw-templates/sustainability/section', null, [ 'section_data' => $section ] );
}

get_template_part( 'gpw-templates/global/get-free-quote-section' );

get_template_part( 'gpw-templates/global/footer' );