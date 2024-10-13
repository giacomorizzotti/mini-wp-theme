<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mini
 */

?>

	</div><?php /* closing .sheet div */ ?>

	<footer id="footer" class="footer">
        <div class="container space-top-bot">
            <div class="boxes">
                <div class="box box-33 footer-info px-2">
                    <p class=""><?php echo date("Y"); ?>&nbsp;©&nbsp;<span class="bold">uwa.agency</span></p>
                    <p class="s">A <a href="https://mini.uwa.agency/" target="_blank" class="mini-text"><i>mini</i></a> based website by <a href="https://www.uwa.agency/" target="_blank" class="mini-text"><strong>UWA</strong></a></p>
                </div>
                <div class="box box-33 footer-logo px-2">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="">
						<?php the_custom_logo(); ?>
					</a>
                </div>
                <div class="box box-33 footer-menu px-2">
                    <nav class="menu footer-menu">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'menu_id'        => 'footer-menu',
					)
				);
				?>
                    </nav>
                </div>
            </div>
        </div>
    </footer>
	
    <div id="credits" class="fw-bg">
        <p class="S m-0 center grey-text p-1 pt-05">
            <i class="fa fa-heart mini-text heart" aria-hidden="true"></i>&nbsp;
            Proudly <i>fully custom</i> designed & developed by&nbsp;
            <a href="https://www.uwa.agency/" target="_blank" class="fb-text hover-col">
                <img src="https://mini.uwa.agency/img/uwa/brand/uwa_logo.svg" class="img" alt="UWA logo" style="display: inline-block; width: 26px; transform: translate(0, 25%);"/>
            </a>&nbsp;
            using&nbsp;
            <a href="https://mini.uwa.agency/" target="_blank" class="fb-text link-hover-text">
                <img src="https://mini.uwa.agency/img/brand/mini_emblem.svg" class="img" alt="mini logo" style="display: inline-block; width: 16px;"/>&nbsp;
                mini
            </a>
        </p>
    </div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
