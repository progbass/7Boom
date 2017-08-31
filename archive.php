<?php
/**
 * 7boom template for displaying Archives
 *
 * @package WordPress
 * @subpackage 7boom
 * @since 7boom 1.0
 */

get_header(); ?>
    <?php
    $cat = get_term_by('name', single_cat_title('',false), 'category'); 
    ?>
                
    <section id="category" class="category-<?php echo $cat->slug; ?>" role="main">
	
        <div class="content_wrapper">    
            <?php
            if ( have_posts() ): ?>

                <h1 class="archive-title">
                    <?php
                        if ( is_category() ):
                            printf( single_cat_title( '', false ) );

                        elseif ( is_tag() ):
                            printf( single_tag_title( '', false ) );

                        elseif ( is_tax() ):
                            $term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                            $taxonomy = get_taxonomy( get_query_var( 'taxonomy' ) );
                            printf( $taxonomy->labels->singular_name, $term->name );

                        elseif ( is_day() ) :
                            printf( get_the_date() );

                        elseif ( is_month() ) :
                            printf( get_the_date( _x( 'F Y', 'monthly archives date format', '7boom' ) ) );

                        elseif ( is_year() ) :
                            printf( get_the_date( _x( 'Y', 'yearly archives date format', '7boom' ) ) );

                        elseif ( is_author() ) : the_post();
                            printf( get_the_author() );

                        else :
                            _e( 'Archives', '7boom' );

                        endif;
                    ?>
                </h1>

                <ul class="search_results">
                <?php
                while ( have_posts() ) : the_post();
                    get_template_part( 'loop', 'archive' );

                endwhile; ?>
                </ul>


            <?php
            else :

                get_template_part( 'loop', 'empty' );

            endif; ?>
        </div>
        
        <!-- GET SIDEBAR -->
        <?php get_sidebar(); ?>
        <!-- END GET SIDEBAR -->
	</section>

<?php get_footer(); ?>