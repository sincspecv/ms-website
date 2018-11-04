<?php
/**
 * SKILLS SHORTCODES
 *
 * @since 1.0.0
 */

function tfr_skills_chart_shortcode( $atts ) {
	extract(shortcode_atts(array(
		'color' => '#ededed',
	), $atts));

	// Load chart.js in the footer
	wp_enqueue_script( 'chart-js', TFR_SKILLS_URL . 'assets/js/chart.min.js', array(), NULL, true );
	wp_enqueue_script( 'skills-js', TFR_SKILLS_URL . 'assets/js/tfr-skills.min.js', array(), NULL, true );

	// Build output string
	$output = '';
	$output .= '<canvas id="tfr-skills-chart" width="undefined" height="385"></canvas>' . PHP_EOL;

	// Print the js var for defined color
	echo '<script>var chartColor = "'.$color.'";</script>';

	return $output;
}

add_shortcode( 'skills-chart', 'tfr_skills_chart_shortcode' );