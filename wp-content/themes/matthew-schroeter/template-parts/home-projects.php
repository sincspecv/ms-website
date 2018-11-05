<?php
/**
 * Template part for displaying the projects section on the home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */

$postid = tfr_post_id();
?>

<div id="ms-home-projects">
	<div class="ms-wrap">
		<h2><?=get_field( 'projects_title', $postid )?></h2>
		<div id="ms-projects-wrap">
			<?php

			if ( have_rows( 'projects', 'options' ) ) :
				while ( have_rows( 'projects', 'options' ) ) : the_row();
				$image = get_sub_field( 'screenshot' );
			?>

			<div class="project">
				<div class="project-wrap">
					<div class="project-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" /></div>
					<div class="project-title"><h4><?=get_sub_field( 'title')?></h4></div>
					<div class="project-description"><?php the_sub_field( 'description' ) ?></div>
					<div class="project-link"><a href="<?=get_sub_field( 'link' )?>" rel="noopener" target="_blank">Visit</a></div>
				</div>
			</div>

			<?php
				endwhile;
			endif;

			?>
		</div>
	</div>
</div>
