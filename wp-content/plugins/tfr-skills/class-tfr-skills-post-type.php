<?php
/**
 * Created by PhpStorm.
 * User: dino
 * Date: 11/2/18
 * Time: 8:08 PM
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TFR_Skills_Post_Type' ) ) {

	class TFR_Skills_Post_Type {
		/**
		 * REGISTER SKILL CUSTOM POST TYPE
		 *
		 * @since 1.0.0
		 */
		public static function init() {

			$labels = array(
				'name' => __( 'Skills', 'Post Type General Name', 'tfr-skills' ),
				'singular_name' => __( 'Skill', 'Post Type Singular Name', 'tfr-skills' ),
				'menu_name' => __( 'Skills', 'tfr-skills' ),
				'name_admin_bar' => __( 'Skill', 'tfr-skills' ),
				'archives' => __( 'Skill Archives', 'tfr-skills' ),
				'attributes' => __( 'Skill Attributes', 'tfr-skills' ),
				'parent_item_colon' => __( 'Parent Skill:', 'tfr-skills' ),
				'all_items' => __( 'All Skills', 'tfr-skills' ),
				'add_new_item' => __( 'Add New Skill', 'tfr-skills' ),
				'add_new' => __( 'Add New', 'tfr-skills' ),
				'new_item' => __( 'New Skill', 'tfr-skills' ),
				'edit_item' => __( 'Edit Skill', 'tfr-skills' ),
				'update_item' => __( 'Update Skill', 'tfr-skills' ),
				'view_item' => __( 'View Skill', 'tfr-skills' ),
				'view_items' => __( 'View Skills', 'tfr-skills' ),
				'search_items' => __( 'Search Skill', 'tfr-skills' ),
				'not_found' => __( 'Not found', 'tfr-skills' ),
				'not_found_in_trash' => __( 'Not found in Trash', 'tfr-skills' ),
				'featured_image' => __( 'Featured Image', 'tfr-skills' ),
				'set_featured_image' => __( 'Set featured image', 'tfr-skills' ),
				'remove_featured_image' => __( 'Remove featured image', 'tfr-skills' ),
				'use_featured_image' => __( 'Use as featured image', 'tfr-skills' ),
				'insert_into_item' => __( 'Insert into Skill', 'tfr-skills' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Skill', 'tfr-skills' ),
				'items_list' => __( 'Skills list', 'tfr-skills' ),
				'items_list_navigation' => __( 'Skills list navigation', 'tfr-skills' ),
				'filter_items_list' => __( 'Filter Skills list', 'tfr-skills' ),
			);
			$args = array(
				'label' => __( 'Skill', 'tfr-skills' ),
				'description' => __( 'Define skill set', 'tfr-skills' ),
				'labels' => $labels,
				'menu_icon' => 'dashicons-chart-bar',
				'supports' => array( 'title' ),
				'taxonomies' => array( 'skill-level' ),
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 5,
				'show_in_admin_bar' => false,
				'show_in_nav_menus' => false,
				'can_export' => true,
				'has_archive' => false,
				'hierarchical' => false,
				'exclude_from_search' => true,
				'show_in_rest' => true,
				'publicly_queryable' => false,
				'capability_type' => 'post',
			);
			register_post_type( 'skill', $args );

		}
	}

	add_action( 'init', 'TFR_Skills_Post_Type::init', 0 );
}
