<?php
/**
 * MATTHEW SCHROETER SHORTCODES
 *
 * @package Matthew Schroeter
 * @since   1.0.0
 */

function ms_gitlab_commit_count_shortcode( $atts ) {
	// Get GitLab instance
	$gitlab = new MS_Gitlab();
	$transient = $gitlab->commit_count_key;

	// Check if transient is set, and set it if it isn't
	if ( false === get_transient( $transient ) ) {
		$commit_count = $gitlab->get_commit_count();
		set_transient( $transient, $commit_count, 86400 );
	}

	// Return the commit count
	$commit_count = get_transient( $transient );
	echo $commit_count;
}

add_shortcode( 'gitlab-commit-count', 'ms_gitlab_commit_count_shortcode' );