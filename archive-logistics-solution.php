<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Logistics Solution archive page
 */

get_template_part( 'gpw-templates/global/header' );

get_template_part( 'gpw-templates/global/hero-section', 'with-content' );

get_template_part( 'gpw-templates/global/services-section', null, ['title' => __('3A Logistics Solution', GPW_TEXT_DOMAIN)] );

get_template_part( 'gpw-templates/global/get-free-quote-section' );

get_template_part( 'gpw-templates/global/testimonial-section');

get_template_part( 'gpw-templates/home-page/blogs-section' );

get_template_part( 'gpw-templates/global/footer' );