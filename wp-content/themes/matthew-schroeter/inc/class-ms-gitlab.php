<?php
/**
 * GITLAB API INTEGRAGION
 *
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MS_Gitlab' ) ) {
	class MS_Gitlab {
		/**
		 * @var string  $token GitLab private token
		 */
		private $token;

		/**
		 * @var string  $host GitLab API URL
		 */
		private $host;

		/**
		 * @var string  $push_count_key  Transient key for push count
		 */
		public $push_count_key;

		/**
		 * @var string  $commit_count_key  Transient key for commit count
		 */
		public $commit_count_key;

		/**
		 * MS_Gitlab constructor.
		 *
		 * @param string $url
		 */
		function __construct( $url = 'https://gitlab.com/api/v4' ) {
			// Get private token from customizer
			$this->token = esc_attr( get_theme_mod( 'ms_gitlab_token', '' ) );

			// Set the GitLab URL
			$this->host = esc_url_raw( $url );
		}

		/**
		 * Get data from specified endpoint
		 *
		 * @param $endpoint
		 * @param array $params
		 * @param array $args
		 *
		 * @return array|bool|WP_Error
		 */
		public function get( $endpoint, $params = array(), $args = array() ) {
			// If no endpoint was defined, we can't do anything
			if ( empty( $endpoint ) ) {
				return new WP_Error( 400, 'Variable $endpoint must be defined' );
			}

			// Make sure we have a leading slash on the endpoint
			if ( '/' !== substr( $endpoint, 1 ) ) {
				$endpoint = "/${endpoint}";
			}

			// Add private token to headers
			$args['headers'] = array(
				'Private-Token' => trim( $this->token ),
			);

			// Define the URL with endpoint that we will be sending request
			$url = $this->host . $endpoint;

			// Set up the request with supplied params
			$response = wp_remote_get( add_query_arg( $params, $url ), $args );

			// Make sure response is valid
			$response_code = wp_remote_retrieve_response_code( $response );
			if ( 200 !== $response_code ) {
				return new WP_Error( $response_code, 'GitLab Response Error: ', wp_remote_retrieve_body( $response )  );
			}

			// Return full response so that we have access to body and headers
			return $response;
		}

		/**
		 * Get data for all push events
		 *
		 * @param array $params
		 *
		 * @return array|bool|WP_Error
		 */
		public function get_pushed( $params = array() ) {
			// Set up params for request to GitLab
			$params['action'] = 'pushed';
			$params['per_page'] = '100';

			// Send the request
			$response = $this->get( 'events', $params );

			return $response;
		}

		/**
		 * Get total number of push events
		 *
		 * @return bool|string
		 */
		public function get_push_count() {
			// Get all pushes
			$pushes = $this->get_pushed();

			// Make sure we got a valid response
			if( is_wp_error( $pushes ) ) {
				return $pushes;
			}

			// Get total number of push events from header
			$push_count = wp_remote_retrieve_header( $pushes, 'x-total' );

			// Set transient key if it doesn't exist
			$key = '_ms_gitlab_push_count_' . md5( $this->token, $push_count );
			if ( false === get_transient( $key ) ) {
				$this->push_count_key = $key;
			}


			return $push_count;
		}

		/**
		 * Get total number of commits
		 *
		 * @return bool|int
		 */
		public function get_commit_count() {
			// Get all pushes
			$pushes = $this->get_pushed();

			// Make sure we got a valid response
			if( is_wp_error( $pushes ) ) {
				return $pushes;
			}

			// Get page count from header
			$page_count = wp_remote_retrieve_header( $pushes, 'x-total-pages' );

			// Start counting the commits
			$commit_count = 0;
			$body = json_decode( wp_remote_retrieve_body( $pushes ), true );

			// Loop through all push events and add the commit count
			foreach ( $body as $event ) {
				$count = $event['push_data']['commit_count'];
				$commit_count = $commit_count + $count;
			}

			// If page count is greater than 1, get the rest of the data
			if ( ! empty( $page_count ) && $page_count > 1 ) {
				for ( $i = 1; $i < $page_count; $i++ ) {
					// Add page number to parameters
					$params = array( 'page' => $i + 1 );

					// Request next page
					$next_page = $this->get_pushed( $params );

					// Get the commits and add them up
					$body = json_decode( wp_remote_retrieve_body( $next_page ), true );

					// Loop through all push events and add the commit count
					foreach ( $body as $event ) {
						// GitLab is returning Merge events as Pushed events,
						// so we need to filter those out. It is highly unlikely
						// that there would be more than 10 commits before a push
						$count = $event['push_data']['commit_count'];
						if ( $count < 11 ) {
							$commit_count = $commit_count + $count;
						}
					}
				}
			}

			// Set transient key if it doesn't exist
			$key = '_ms_gitlab_commit_count_' . md5( $this->token, $commit_count );
			if ( false === get_transient( $key ) ) {
				$this->commit_count_key = $key;
			}

			return $commit_count;
		}
	}
}