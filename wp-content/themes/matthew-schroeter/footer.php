<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Matthew_Schroeter
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
        <div id="footer-about">
            <?=get_field( 'about', 'options' )?>
            <ul id="social-links">
                <?php
                if ( have_rows( 'fontawesome_links', 'options' ) ) :
                    while ( have_rows( 'fontawesome_links', 'options' ) ) : the_row();
                    ?>

                    <li><a href="<?=get_sub_field( 'link' )?>" rel="noopener nofollow" target="_blank"><i class="fab <?=get_sub_field('icon')?>"></i></a></li>

                    <?php
                    endwhile;
                endif;
                ?>
            </ul>
        </div>
		<div id="site-info">
			<span id="copyright">  &copy; <?=get_field( 'copyright', 'options' )?></span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
