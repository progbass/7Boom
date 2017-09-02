<?php
/**
 * 7boom template for displaying the footer
 *
 * @package WordPress
 * @subpackage 7boom
 * @since 7boom 1.0
 */
?>

			</div>
			<!-- MAIN CONTAINER -->
        
        <!-- FOOTER -->
        <footer>
            <div class="logo">
                <img src="<?php bloginfo('template_url') ?>/images/logo-7boom.svg" alt="7Boom">
            </div>

            <div class="logo_sponsor">
                <a href="http://brutalcontent.com"><img src="<?php bloginfo('template_url') ?>/images/logo-brutalContent.png" alt="Powered by Brutal Content"></a>
            </div>

            <div class="social-networks">
                <a href="https://www.facebook.com/7BoomMex" class="facebook">Facebook</a>
                
                <?php
                if(wp_is_mobile()): ?>
                    <a class="whatsapp" onclick="socialshare('whatsapp', '<?php bloginfo('url'); ?>', '<?php wp_title(); ?>');">Whatsapp</a>
                <?php
                endif; ?>
            </div>


            <nav class="menu">
                <ul>
                    <li><a href="#">T&eacute;rminos y Condiciones</a></li>
                    <li><a href="#">Aviso de Privacidad</a></li>
                    <li>Copyright © 2017 · All Rights Reserved</li>
                    <li><a href="mailto:contacto@brutalcontent.com">Contacto</a></li>
                </ul>
            </nav>
        </footer>
        <!-- END: FOOTER -->

		<?php wp_footer(); ?>
	</body>
</html>