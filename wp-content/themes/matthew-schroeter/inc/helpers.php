<?php
/**
 * ====================================================================================================
 * GET THE POST ID
 * @package Abstrakt
 * @version 1.6.1
 * @since 1.0.0
 * @return 		int 		$postid
 * ====================================================================================================
 */
function tfr_post_id() {
	global $post;

	// return false if $post is not set
	if (!isset($post)) return false;

	$posts_page = get_option( 'page_for_posts' );

	if (is_home() && isset($posts_page)) {
		$blog 		= get_post( $posts_page );
		$blog_id 	= $blog->ID;
		$postid 	= $blog_id;
	} else {
		$postid 	= $post->ID;
	}

	return $postid;
}
