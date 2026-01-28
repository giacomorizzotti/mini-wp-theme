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
                    <p class="m-0 L"><?php echo date("Y"); ?>&nbsp;©&nbsp;<span class="bold"><?= do_shortcode('[get_company_name]'); ?></span></p>
                    <div class="space-1"></div>
                    <?php if (do_shortcode('[get_company_address_line_1]') != false): ?><p class="m-0"><?= do_shortcode('[get_company_address_line_1]'); ?></p><?php endif; ?>
                    <?php if (do_shortcode('[get_company_address_line_2]') != false): ?><p class="m-0"><?= do_shortcode('[get_company_address_line_2]'); ?></p><?php endif; ?>
                    <?php if (do_shortcode('[get_company_email]') != false || do_shortcode('[get_company_phone]') != false ): ?><div class="space-1"></div><?php endif; ?>
                    <?php if (do_shortcode('[get_company_email]') != false): ?><p class="m-0"><span class="label">email</span>&nbsp;&nbsp;<?= do_shortcode('[get_company_email]'); ?></p><?php endif; ?>
                    <?php if (do_shortcode('[get_company_phone]') != false): ?><p class="m-0"><span class="label">phone</span>&nbsp;&nbsp;<?= do_shortcode('[get_company_phone]'); ?></p><?php endif; ?>
                    <?php if (do_shortcode('[get_company_tax_number]') != false || do_shortcode('[get_company_id_code]') != false ): ?><div class="space-1"></div><?php endif; ?>
                    <?php if (do_shortcode('[get_company_tax_number]') != false): ?><p class="m-0"><span class="label">P.IVA</span>&nbsp;&nbsp;<?= do_shortcode('[get_company_tax_number]'); ?></p><?php endif; ?>
                    <?php if (do_shortcode('[get_company_id_code]') != false): ?><p class="m-0"><span class="label">C.F.</span>&nbsp;&nbsp;<?= do_shortcode('[get_company_id_code]'); ?></p><?php endif; ?>
                </div>
                <div class="box box-33 footer-logo px-2">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="">
						<?php if (has_custom_logo()): ?>
							<img src="<?= esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) ) ?>" class="logo emblem" alt="emblem"/>
                        <?php else: ?>
							<img src="<?php if (check_variable_from_option('mini_cdn_options', 'cdn_dev')): ?>https://serversaur.doingthings.space/mini/img/brand/mini_emblem.svg<?php else: ?>https://mini.uwa.agency/img/brand/mini_emblem.svg<?php endif; ?>" class="logo emblem" alt="emblem"/>
						<?php endif; ?>
                    </a>
                </div>
                <div class="box box-33 footer-menu px-2">
                    <nav class="menu footer-menu">
				<?php
				wp_nav_menu(
					array(
						'menu'           => 'footer-menu',
						'theme_location' => 'footer-menu',
						'container'		 => 'ul',
						'menu_id'        => 'footer-menu',
						'menu_class'     => 'menu footer-menu',
					)
				);
				?>
                    </nav>
                    <?php 
                    $social_networks = get_enabled_social_networks();
                    if (!empty($social_networks)): 
                    ?>
                    <div class="sep-1 my-2 light-grey-bg"></div>
                    <nav class="menu social-menu">
                        <ul class="menu flex-direction-row">
                            <?php foreach ($social_networks as $key => $social): ?>
                            <li class="p-1">
                                <a href="<?= esc_url($social['url']) ?>" target="_blank" rel="noopener noreferrer" title="<?= esc_attr($social['name']) ?>">
                                    <i class="<?= esc_attr($social['icon']) ?> XXL"></i>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                    <?php 
                    $get_in_touch = get_enabled_messaging_apps();
                    if (!empty($get_in_touch)): 
                    ?>
                    <div class="sep-1 my-2 light-grey-bg"></div>
                    <nav class="menu social-menu">
                        <ul class="menu flex-direction-row">
                            <?php foreach ($get_in_touch as $key => $messaging_app): ?>
                            <li class="p-1">
                                <a href="<?= esc_url($messaging_app['url']) ?>" target="_blank" rel="noopener noreferrer" title="<?= esc_attr($messaging_app['name']) ?>">
                                    <i class="<?= esc_attr($messaging_app['icon']) ?> XXL"></i>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>
<?php
if ( 
    get_variable('mini_options','mini_credits') != false
) {
?>
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
<?php
	}
?>

</div><!-- #page -->

<?php wp_footer(); ?>

<?php
	if ( 
		is_array(get_option( 'mini_ext_lib_options' )) && 
		array_key_exists('mini_aos', get_option( 'mini_ext_lib_options' ) ) && 
		get_option( 'mini_ext_lib_options' )['mini_aos'] != null 
	) {
?>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script><script>AOS.init();</script>
<?php
	}
?>

</body>
</html>
