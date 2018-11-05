<?php
/**
 * Template part for displaying the hero on the home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */

$description = get_bloginfo( 'description', 'display' );
?>

<div id="ms-home-hero">
    <div class="ms-wrap">
        <div class="ms-hero-content">
            <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
            <?php if ( $description || is_customize_preview() ) : ?>
            <p class="site-description"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
