<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matthew_Schroeter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="ms-wrap">

        <?php matthew_schroeter_post_thumbnail();

        // Only print the content section if we have content
        $content = get_the_content();
        if ( ! empty( $content ) ) : ?>
            <div class="entry-content">
                <?php
                 echo wpautop( $content );

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'matthew-schroeter' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div><!-- .entry-content -->
            <?php endif; ?>

        <?php if ( get_edit_post_link() ) : ?>
            <footer class="entry-footer">
                <?php
                edit_post_link(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __( 'Edit <span class="screen-reader-text">%s</span>', 'matthew-schroeter' ),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
                ?>
            </footer><!-- .entry-footer -->
        <?php endif; ?>

    </div>
</article><!-- #post-<?php the_ID(); ?> -->
