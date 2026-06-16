<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template name: PAGE - Home page
 */

get_template_part( 'gpw-templates/global/header' );

get_template_part( 'gpw-templates/global/hero-section', 'with-content' );

get_template_part( 'gpw-templates/global/services-section', null, [ 'has_view_all_button' => true ] );

get_template_part( 'gpw-templates/home-page/our-solutions-section' );

get_template_part( 'gpw-templates/global/case-studies-section' );

get_template_part( 'gpw-templates/home-page/statistic-section' );

get_template_part( 'gpw-templates/home-page/what-make-different-section' );

get_template_part( 'gpw-templates/home-page/member-of-group-section' );

get_template_part( 'gpw-templates/footer/partners-section' );

get_template_part( 'gpw-templates/home-page/destination-section' );

get_template_part( 'gpw-templates/global/testimonial-section');

get_template_part( 'gpw-templates/home-page/blogs-section' );

get_template_part( 'gpw-templates/global/footer' );