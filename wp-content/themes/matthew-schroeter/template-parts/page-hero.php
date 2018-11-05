<?php
/**
 * Template part for displaying the hero on pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */

$postid = tfr_post_id();
$sub_head = get_field( 'sub_heading', $postid );
?>

<div id="ms-page-hero">
	<div class="ms-wrap">
		<div class="ms-hero-content">
			<h1 class="page-title"><?=get_the_title($postid)?></h1>
			<?php if ( ! empty( $sub_head ) ) : ?>
				<p class="sub-heading"><?=do_shortcode( $sub_head )?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
