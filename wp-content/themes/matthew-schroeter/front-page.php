<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */

$postid = tfr_post_id();

get_header();

// Load the hero for the home page
if ( is_front_page() ) {
    get_template_part( 'template-parts/home', 'hero' );
}

get_template_part(  'template-parts/content', 'hook' );

?>

	<div class="ms-section" id="ms-skills">
			<div class="ms-content">
                <div id="ms-skills-chart">
				    <?php echo do_shortcode( get_field( 'skills', $postid ) ); ?>
                </div>
                <div id="ms-skills-image" style="background-image:url('<?=get_field( 'image', $postid )?>')">
                    <?php the_field( 'skills_content', $postid ); ?>
                </div>
			</div>
	</div>
    <p><?php do_shortcode('[gitlab-commit-count]'); ?> Commits</p>
<?php


get_footer();