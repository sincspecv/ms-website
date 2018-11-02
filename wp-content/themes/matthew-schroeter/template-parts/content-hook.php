<?php
/**
 * Template part for displaying the hook in content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */

$postid = tfr_post_id();

?>

<div class="ms-hook ms-section">
	<div class="ms-wrap">
		<div class="ms-content">
			<?php the_field( 'hook', $postid ); ?>
		</div>
	</div>
</div>
