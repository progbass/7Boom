<?php
/**
 * 7boom template for displaying Single-Posts
 *
 * @package WordPress
 * @subpackage 7boom
 * @since 7boom 1.0
 */

get_header(); ?>

	<section id="single" class="grid_wrapper" role="main">
		
		<?php if( have_posts() ) {
			get_template_part( 'loop', 'single' );
    	} ?>

	</section>

<?php get_footer(); ?>