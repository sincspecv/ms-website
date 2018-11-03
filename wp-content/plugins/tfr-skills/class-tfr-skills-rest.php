<?php
/**
 * CLASS TFR_Skills_REST
 *
 * Creates REST endpoints to return skills in JSON format
 */

if( ! class_exists( 'TFR_Skills_REST' ) ) {

	class TFR_Skills_REST {

		/**
		 * SKILLS POST DATA
		 *
		 * @since 1.0.0
		 * @var array
		 */
		private $skills_posts;

		/**
		 * CONSTRUCT
		 *
		 * Get skills from the database and register endpoints
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			// Get skills
			$query = new WP_Query(array(
				'post_type' => 'skill',
				'post_status' => 'publish',
				'posts_per_page' => -1,
			));

			$this->skills_posts = $query->posts;

			// Register endpoints
			self::register_endpoints();
		}


		/**
		 * CREATE REST ENDPOINT(S)
		 *
		 * @since 1.0.0
		 */
		private function register_endpoints() {
			//Get all skills
			add_action( 'rest_api_init', function () {
				register_rest_route( 'skills/v1', '/all', array(
					'methods' => 'GET',
					'callback' => array( $this, 'return_all_skills' ),
				) );
			} );

			// Get skills formatted for chart.js
			add_action( 'rest_api_init', function () {
				register_rest_route( 'skills/v1', '/chart', array(
					'methods' => 'GET',
					'callback' => array( $this, 'return_skills_chart' ),
				) );
			} );
		}

		/**
		 * CALLBACK FOR /all ENDPOINT
		 *
		 * Returns all skills ID, title and level
		 *
		 * @return mixed|WP_REST_Response
		 */
		public function return_all_skills() {

			$skills = array();

			foreach ( $this->skills_posts as $skill ) {
				array_push( $skills, array(
					'ID'          => $skill->ID,
					'skill'       => $skill->post_title,
					'skill_level' => get_post_meta( $skill->ID, 'tfr_skill_level', true ),
				) );
			}

			return rest_ensure_response( $skills );
		}

		/**
		 * CALLBACK FOR /chart ENDPOINT
		 *
		 * Returns all skills title and level formatted for chart.js
		 *
		 * @return mixed|WP_REST_Response
		 */
		public function return_skills_chart() {

			$skills = array();
			$labels = array();
			$data   = array();

			foreach ( $this->skills_posts as $skill ) {
				// Create labels array
				array_push( $labels, $skill->post_title );

				// Create data points array
				array_push( $data, get_post_meta( $skill->ID, 'tfr_skill_level', true ) );
			}

			// Bring it all together and return it
			$skills = array(
				'labels'      => $labels,
				'data'        => $data,
			);

			return rest_ensure_response( $skills );
		}
	}

	new TFR_Skills_REST();
}