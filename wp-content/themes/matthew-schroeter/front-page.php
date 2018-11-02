<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */

get_header();

// Load the hero for the home page
if ( is_front_page() ) {
    get_template_part( 'template-parts/home', 'hero' );
}

get_template_part(  'template-parts/content', 'hook' );

get_footer();