<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Matthew_Schroeter
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<?php
	// Add critical css to the head
	$critical_css = get_template_directory() . "/css/critical.css.php";
	if ( file_exists( $critical_css )) {
		include $critical_css;
	}

	?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'tfr_after_body_tag' ); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'matthew-schroeter' ); ?></a>

	<header id="masthead" class="site-header">
        <nav id="site-navigation" class="main-navigation">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'matthew-schroeter' ); ?></button>
                <div class="ms-wrap">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary-navigation',
                    'menu_id'        => 'ms-primary-navigation',
                ) );
                ?>
                </div><!-- .ms-wrap -->
        </nav><!-- #site-navigation -->

	</header><!-- #masthead -->

	<div id="content" class="site-content">
