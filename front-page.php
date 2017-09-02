<?php
/**
 * 7boom template for displaying the Front-Page
 *
 * @package WordPress
 * @subpackage 7boom
 * @since 7boom 1.0
 */

get_header();

////////////////////////
$exlude_post_ids = [];
?>

	<!-- FEATURED CONTENT -->
	<section id="featured_articles">
		<div class="layout_container">
            <ul>
               
                <?php
                $featured_args = array(
                    'posts_per_page' => 4,
                    //'meta_key' => 'featuredPost-checkbox',
                    //'meta_value' => 'yes'
                );
                $featured_posts = new WP_Query($featured_args);
                
                if ($featured_posts->have_posts()):
                
                    while($featured_posts->have_posts()):
					   $featured_posts->the_post();
					   array_push($exlude_post_ids, get_the_ID());  ?>

                            <li <?php post_class(); ?>>
                                <div class="photo_container">
                                    <a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
                                </div>

                                <div class="info_container">
                                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                                    
                                    <?php
                                    $category = get_the_category( $id )[0];
                                    $category_link = get_category_link( $category->term_id );
                                    ?>
                                    <div class="meta"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category->name ?></a></div>
                                </div>
                            </li>
                    <?php
                    endwhile;

                    // Restore original Post Data
                    wp_reset_postdata();
                                         
                endif; ?>
            </ul>
        </div>
	</section>
	<!-- END: FEATURED CONTENT -->



    
    <!-- FULL BANNER CONTAINER -->
	<?php get_template_part('template_parts/banner', 'billboard'); ?>
    
    <?php if( wp_is_mobile() ){ ?>
       <div class="ad_container mobile">
            <div class="ad_unit boxbanner">
                <!-- /94465771/7boom_m_Boxbanner_All -->
                <div id='div-gpt-ad-1503950138877-0'>
                    <script>
                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503950138877-0'); });
                    </script>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- END: FULL BANNER CONTAINER -->




    <div class="content_wrapper">
        <section id="latest_articles">
            <ul class="article_container">
               <?php
                if ( have_posts() ) :

                    while ( have_posts() ) : the_post();

                        get_template_part( 'loop', get_post_format() );

                    endwhile;

                else :

                    get_template_part( 'loop', 'empty' );

                endif;
                ?>
            </ul>
        </section>


        <aside>
            <div class="module recent-posts">
                <h3>Lo &Uacute;ltimo</h3>

                <ul>
                   <?php
                    $recent_args = array(
                        'posts_per_page' => 4,
                        'post__not_in' => $exlude_post_ids
                    );
                    $recent_posts = new WP_Query($recent_args);
                    
                    if ( $recent_posts->have_posts() ) :

                        while ( $recent_posts->have_posts() ) :
                            $recent_posts->the_post();
                            array_push($exlude_post_ids, get_the_ID()); ?>
                        
                            <li <?php post_class(); ?>>
                                <div class="photo_container">
                                    <a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
                                </div>

                                <div class="info_container">
                                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                                    
                                       <?php
                                        $category = get_the_category( $id )[0];
                                        $category_link = get_category_link( $category->term_id );
                                        ?>
                                       <div class="meta">
                                        <div class="category"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category->name ?></a></div>
                                        <div class="date"><?php the_time('d F y') ?></div>
                                    </div>
                                </div>
                            </li>

                        <?php
                        endwhile;
				
                        // Restore original Post Data
                        wp_reset_postdata();
                                            

                    else :
                        get_template_part( 'loop', 'empty' );
                    endif;
                    ?>
                </ul>
            </div>


            <div class="module facebook-like">
                <div class="container">
                    <a href="https://www.facebook.com/7BoomMex">LIKE <span>1.5M</span></a>
                </div>
            </div>
        </aside>
    </div>


<?php get_footer(); ?>