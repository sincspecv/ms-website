<?php


/**
 * Dequeue jQuery amd wp-embed from the front end
 */
function my_jquery_enqueue() {
	wp_deregister_script('jquery');
	wp_deregister_script('wp-embed');
}
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 10);

/**
 * Enqueue scripts and styles.
 */
function tfr_scripts() {
	wp_enqueue_style( 'min-css', get_template_directory_uri() . '/css/site.min.css' );

	wp_register_script( 'site-js', get_template_directory_uri() . '/js/site.js', array(), NULL, true );
	wp_enqueue_script( 'site-js' );

	// Load particles.js on home page
	if( is_front_page() ) {
		wp_register_script( 'particles-js', get_template_directory_uri() . '/js/particles.min.js', array(), '', true );
		wp_enqueue_script( 'particles-js' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tfr_scripts' );