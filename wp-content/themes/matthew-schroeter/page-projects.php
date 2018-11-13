<?php
/**
 * Template Name: Projects Page
 */

get_header();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			// Load the hook template
			get_template_part( 'template-parts/content', 'hook' );

			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->

		<div id="ms-projects">

			<?php get_template_part( 'template-parts/projects', 'list' ); ?>

		</div><!-- #ms-projects -->
	</div><!-- #primary -->

<?php
get_footer();
