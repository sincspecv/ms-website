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
		if( ! is_wp_error( $commit_count ) ) {
			set_transient( $transient, $commit_count, 86400 ); // One day is 86400 seconds
		}
	}

	// Return the commit count
	$commit_count = get_transient( $transient );
	if( ! is_wp_error( $commit_count ) ) {
		echo '<span id="ms-gitlab-commit-count" data-number="' . $commit_count . '">0</span>';
	}
}

add_shortcode( 'gitlab-commit-count', 'ms_gitlab_commit_count_shortcode' );