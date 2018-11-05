<?php
/**
 * Template part for displaying projects
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */
?>


<div class="ms-wrap" id="ms-projects-list-wrap">
	<?php

	if ( have_rows( 'projects', 'options' ) ) :
		while ( have_rows( 'projects', 'options' ) ) : the_row();
			$image = get_sub_field( 'screenshot' );
			?>

			<div class="project">
				<div class="project-wrap">
					<div class="project-details">
						<div class="project-title"><h3><?=get_sub_field( 'title')?></h3></div>
						<div class="project-description"><?php the_sub_field( 'description' ) ?></div>
						<div class="project-link"><a href="<?=get_sub_field( 'link' )?>" rel="noopener" target="_blank">Visit</a></div>
					</div>
					<div class="project-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" /></div>
				</div>
			</div>

		<?php
		endwhile;
	endif;

	?>
</div>


