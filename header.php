<?php
/**
 * 7boom template for displaying the header
 *
 * @package WordPress
 * @subpackage 7boom
 * @since 7boom 1.0
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="ie ie-no-support" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title( ); ?></title>
		<meta name="viewport" content="width=device-width" />

		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<![endif]-->

		<?php wp_head(); ?>
	</head>


	<body <?php body_class(); ?>>



		<!-- MAIN CONTAINER -->
		<div id="main_container">
		
		
        
            <!-- HEADER & MAIN NAV -->
            <header>
                <div class="logo_container">
                    <a class="logo" href="<?php echo home_url(); ?>">
                        <img src="<?php echo bloginfo('template_url'); ?>/images/logo-7boom.svg" alt="<?php bloginfo( 'name' ); ?>"> 
                    </a>

                    <ul class="mobile_items">
                        <li class="search">Buscar</li>
                        <li class="menu"></li>
                    </ul>
                </div>




                <?php
                $nav_menu = wp_nav_menu(
                    array(
                        'container' => 'nav',
                        'container_id' => 'menu_main',
                        'items_wrap' => '<ol>%3$s</ol>',
                        'theme_location' => 'main-menu',
                        'fallback_cb' => '__return_false',
                    )
                ); ?>


                <ul class="social_media">
                    <li class="search"><a href="#">Buscar</a></li>
                    <li class="facebook"><a href="#">Facebook</a></li>
                </ul>
            </header>
            <!-- END: HEADER & MAIN NAV -->
			
