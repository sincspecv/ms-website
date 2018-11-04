<?php
/**
 * Scheduled events for theme
 *
 * @since 1.0.0
 */


/**
 * Set hooks for GitLab push count transient
 */
function ms_set_push_count() {
	// Get GitLab instance
	$gitlab = new MS_Gitlab();
	$push_count = $gitlab->get_push_count();
	$transient = $gitlab->push_count_key;

	// Set the transient
	set_transient( $transient, $push_count, 86400 );;
}
add_action( 'ms_update_push_count', 'ms_set_push_count' );

/**
 * Set hooks for GitLab commit count transient
 */
function ms_set_commit_count() {
	// Get GitLab instance
	$gitlab = new MS_Gitlab();
	$commit_count = $gitlab->get_commit_count();
	$transient = $gitlab->commit_count_key;

	// Set the transient
	set_transient( $transient, $commit_count, 86400 );
}
add_action( 'ms_update_commit_count', 'ms_set_commit_count' );

/**
 * Update GitLab Push Count
 */
function ms_gitlab_cron_push_count() {
	// Make sure we're not double booked
	if ( ! wp_next_scheduled( 'ms_update_push_count', array( false ) ) ) {
		wp_schedule_event( time(), 'hourly', 'ms_update_push_count' );
	}
}
register_activation_hook( __FILE__, 'ms_gitlab_cron_push_count' );

/**
 * Update GitLab Commit Count
 */
function ms_gitlab_cron_commit_count() {
	// Make sure we're not double booked
	if ( ! wp_next_scheduled( 'ms_update_commit_count', array( false ) ) ) {
		wp_schedule_event( time(), 'hourly', 'ms_update_commit_count' );
	}
}
register_activation_hook( __FILE__, 'ms_gitlab_cron_commit_count' );