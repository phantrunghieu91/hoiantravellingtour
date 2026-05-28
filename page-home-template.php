<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template name: PAGE - Home page
 */

get_template_part( 'gpw-templates/global/header' );

get_template_part( 'gpw-templates/global/hero-section', 'with-content', [ 'split_title' => 'true' ] );

get_template_part( 'gpw-templates/global/services-section', null, [ 'has_view_all_button' => true ] );

get_template_part( 'gpw-templates/home-page/our-solutions-section' );

get_template_part( 'gpw-templates/global/case-studies-section' );

get_template_part( 'gpw-templates/home-page/statistic-section' );

get_template_part( 'gpw-templates/home-page/core-value-section', 'style-2' );

get_template_part( 'gpw-templates/global/get-free-quote-section' );

get_template_part( 'gpw-templates/global/testimonial-section');

get_template_part( 'gpw-templates/home-page/blogs-section' );

get_template_part( 'gpw-templates/global/footer' );