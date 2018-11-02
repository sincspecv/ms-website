<?php
/**
 * Class TFR_Skills_Metabox
 *
 * SKILL LEVEL METABOX
 * https://www.wp-hasty.com/tools/wordpress-metabox-generator/
 *
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists( 'TFR_Skills_Metabox' ) ) {

	class TFR_Skills_Metabox {
		/**
		 * @var array Screens to show meta boxes
		 */
		private $screen = array(
			'skill',
		);

		/**
		 * @var array Metaboxes to be generated
		 * @since 1.0.0
		 */
		private $meta_fields = array(
			array(
				'label' => 'Skill Level',
				'id' => 'tfr_skill_level',
				'default' => '0',
				'type' => 'number',
			),
		);

		public function __construct() {
			self::init();
		}

		/**
		 * METABOX HOOKS
		 *
		 * @since 1.0.0
		 */
		private function init() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_fields' ) );
		}

		/**
		 * CREATE META BOXES
		 *
		 * @since 1.0.0
		 */
		public function add_meta_boxes() {
			foreach ( $this->screen as $single_screen ) {
				add_meta_box(
					'skilllevel',
					__( 'Skill Level', 'tfr-skills' ),
					array( $this, 'meta_box_callback' ),
					$single_screen,
					'normal',
					'default'
				);
			}
		}

		public function meta_box_callback( $post ) {
			wp_nonce_field( 'skilllevel_data', 'skilllevel_nonce' );
			$this->field_generator( $post );
		}

		public function field_generator( $post ) {
			$output = '';
			foreach ( $this->meta_fields as $meta_field ) {
				$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
				$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
				if ( empty( $meta_value ) ) {
					$meta_value = $meta_field['default']; }
				switch ( $meta_field['type'] ) {
					default:
						$input = sprintf(
							'<input %s id="%s" name="%s" type="%s" value="%s">',
							$meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
							$meta_field['id'],
							$meta_field['id'],
							$meta_field['type'],
							$meta_value
						);
				}
				$output .= $this->format_rows( $label, $input );
			}
			echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
		}
		public function format_rows( $label, $input ) {
			return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
		}
		public function save_fields( $post_id ) {
			if ( ! isset( $_POST['skilllevel_nonce'] ) )
				return $post_id;
			$nonce = $_POST['skilllevel_nonce'];
			if ( !wp_verify_nonce( $nonce, 'skilllevel_data' ) )
				return $post_id;
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			foreach ( $this->meta_fields as $meta_field ) {
				if ( isset( $_POST[ $meta_field['id'] ] ) ) {
					switch ( $meta_field['type'] ) {
						case 'email':
							$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
							break;
						case 'text':
							$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
							break;
					}
					update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
				} else if ( $meta_field['type'] === 'checkbox' ) {
					update_post_meta( $post_id, $meta_field['id'], '0' );
				}
			}
		}
	}

	new TFR_Skills_Metabox;
}