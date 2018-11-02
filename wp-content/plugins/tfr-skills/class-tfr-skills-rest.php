<?php
/**
 * CLASS TFR_Skills_REST
 *
 * Creates REST endpoint to return skills in JSON format
 */

if( ! class_exists( 'TFR_Skills_REST' ) ) {

	class TFR_Skills_REST {

		function __construct() {
			self::init();
		}

		/**
		 * CREATE REST ENDPOINT(S)
		 *
		 * @since 1.0.0
		 */
		private function init() {
			//Get all skills
			add_action( 'rest_api_init', function () {
				register_rest_route( 'tfr/v1/skills', '/all', array(
					'methods' => 'GET',
					'callback' => array( $this, 'return_all_skills' ),
				) );
			} );


		}

		/**
		 * CALLBACK FOR /all ENDPOIMT
		 *
		 * Returns all skills title and level
		 *
		 * @return mixed|WP_REST_Response
		 */
		public function return_all_skills() {
			$query = new WP_Query(array(
				'post_type' => 'skill',
				'post_status' => 'publish',
				'posts_per_page' => -1,
			));

			$skills = array();

			foreach ( $query->posts as $skill ) {
				array_push( $skills, array(
					'skill' => $skill->post_title,
					'skill_level' => get_post_meta( $skill->ID, 'tfr_skill_level', true ),
				) );
			}

			return rest_ensure_response( $skills );
		}
	}

	new TFR_Skills_REST();
}