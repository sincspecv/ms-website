<?php
/*
Plugin Name: Skills
Plugin URI: https://www.thefancyrobot.com/
Description: Define skill set
Version: 1.0.0
Author: Matthew Schroeter
Author URI: http://www.mattschroeter.me/
Copyright: GPL
Text Domain: tfr-skills
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Define plugin directory as constant
define( 'TFR_SKILLS_DIR', plugin_dir_path( __FILE__ ) );
define( 'TFR_SKILLS_URL', plugin_dir_url( __FILE__ ) );

// Load plugin files
require TFR_SKILLS_DIR . 'class-tfr-skills-post-type.php';
require TFR_SKILLS_DIR . 'class-tfr-skills-metabox.php';
require TFR_SKILLS_DIR . 'class-tfr-skills-rest.php';
require TFR_SKILLS_DIR . 'tfr-skills-shortcode.php';


