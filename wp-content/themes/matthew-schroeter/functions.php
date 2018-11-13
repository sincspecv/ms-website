<?php
/**
 * Matthew Schroeter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Matthew_Schroeter
 */

if ( ! function_exists( 'matthew_schroeter_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function matthew_schroeter_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Matthew Schroeter, use a find and replace
		 * to change 'matthew-schroeter' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'matthew-schroeter', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-navigation' => esc_html__( 'Primary Navigation', 'matthew-schroeter' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'matthew_schroeter_custom_background_args', array(
			'default-color' => 'fefefe',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'matthew_schroeter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function matthew_schroeter_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'matthew_schroeter_content_width', 640 );
}
add_action( 'after_setup_theme', 'matthew_schroeter_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function matthew_schroeter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'matthew-schroeter' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'matthew-schroeter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'matthew_schroeter_widgets_init' );

/**
 * Helper Functions
 */
require get_template_directory() . '/inc/helpers.php';

/**
 * Enqueue scripts
 */
require get_template_directory() . '/inc/scripts.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * GitLab integration.
 */
if ( ! class_exists( 'MS_Gitlab' ) ) {
	require get_template_directory() . '/inc/class-ms-gitlab.php';
}

/**
 * Cron jobs.
 */
require get_template_directory() . '/inc/cron.php';

/**
 * Shortcodes.
 */
require get_template_directory() . '/inc/shortcodes.php';


/**
 * Add options page for projects
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	// Projects
	acf_add_options_page(array(
		'page_title' 	=> 'Projects',
		'menu_title'	=> 'Projects',
		'menu_slug' 	=> 'projects-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	// Footer options
	acf_add_options_page(array(
		'page_title' 	=> 'Footer Settings',
		'menu_title'	=> 'Footer',
		'menu_slug' 	=> 'footer-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	// 404 options
	acf_add_options_page(array(
		'page_title' 	=> '404 Page Settings',
		'menu_title'	=> '404 Page',
		'menu_slug' 	=> '404-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}