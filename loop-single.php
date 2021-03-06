<div class="article_container">

    <?php
    if ( have_posts() ) : the_post(); ?>

        <?php
        $category = get_the_category( $id )[0];
        $category_link = get_category_link( $category->term_id );
        ?>

        <article id="<?php the_ID();?>" class="category-<?php echo $category->slug; ?>">

            <div class="title_holder">
                <!-- Tags -->
                <?php
                if(get_the_tag_list()) {
                    echo get_the_tag_list("<ul class='tags'><li><a href='". esc_url( $category_link ) ."'>". $category->name ."</a></li><li>",'</li><li>','</li></ul>');
                } ?>
                <!-- END Tags -->

                <h2><?php the_title(); ?></h2>


                <?php if( get_field('subtitle') ): ?>
                    <h3 class="subtitle"><?php the_field('subtitle'); ?></h3>
                <?php endif; ?>
            </div>




            <div class="article_wrapper">

                <div class="meta">
                    <?php if( get_field('autor') ): ?>
                        <div class="author">
                            Por: <strong><?php the_field('autor'); ?></strong> <a href="#" class="link"><?php the_field('autor_social'); ?></a> | 
                        </div>
                    <?php endif; ?>

                    <div class="date">
                        <?php the_time('d F Y') ?>
                    </div>
                </div>


                <!-- Social Share -->
                <?php get_template_part('template_parts/single', 'social_share'); ?>
                <!-- END: Social Share -->

                
                <?php
                if( wp_is_mobile() ){ ?>
                <div class="ad_container">
                    <div class="ad_unit boxbanner">
                       <?php
                        switch($category->slug){
                        case '9am-6pm': ?>
                            <!-- /94465771/7boom_m_Boxbanner_9am -->
                            <div id='div-gpt-ad-1503950165993-0'>
                                <script>
                                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503950165993-0'); });
                                </script>
                            </div>
                            <?php
                            break;

                        case '6pm-8pm': ?>
                            <!-- /94465771/7boom_m_Boxbanner_6pm -->
                            <div id='div-gpt-ad-1503950188173-0'>
                                <script>
                                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503950188173-0'); });
                                </script>
                            </div>
                            <?php
                            break;

                        case '8pm-finde': ?>
                            <!-- /94465771/7boom_m_Boxbanner_8pm -->
                            <div id='div-gpt-ad-1503950213186-0'>
                                <script>
                                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503950213186-0'); });
                                </script>
                            </div>
                            <?php
                            break;
                        } ?>
                    </div>
                </div>
                <?php
                } ?>
                   
                    

                <div class="content_holder">
                    <?php the_content(); ?>
                </div>


                <!-- Social Share -->
                <?php get_template_part('template_parts/single', 'social_share'); ?>
                <!-- END: Social Share -->

               
                <!-- Tags -->
                <?php
                if(get_the_tag_list()) {
                    echo get_the_tag_list("<ul class='tags'><li>Tags:</li><li>",'</li><li>','</li></ul>');
                } ?>
                <!-- END Tags -->
            </div>


            <!-- GET SIDEBAR -->
            <?php get_sidebar(); ?>
            <!-- END GET SIDEBAR -->
        </article>

    <?php
    else :
        get_template_part( 'loop', 'empty' );

    endif; ?>



    <div class="latest_posts">
        <h4>M&aacute;s Le&iacute;dos</h4>

        <ul>
            <?php
            $chronological_args = array(
                'posts_per_page' => 4,
                'post_status'	 => 'publish'
            );
            $chronological_posts = new WP_Query($chronological_args);

            if ( $chronological_posts->have_posts() ):

                $counter = 0;
                while( $chronological_posts->have_posts() ) :
                    $chronological_posts->the_post(); ?>

                    <li <?php post_class(); ?>>
                        <div class="photo_container">
                            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
                        </div>

                        <div class="info_container">
                            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

                               <?php
                                $chronological_category = get_the_category( $id )[0];
                                $chronological_category_link = get_category_link( $category->term_id );
                                ?>
                               <div class="meta">
                                <div class="category"><a href="<?php echo esc_url( $chronological_category_link ); ?>"><?php echo $chronological_category->name ?></a></div>
                                <div class="date"><?php the_time('d F y') ?></div>
                            </div>
                        </div>
                    </li>



                <?php
                    $counter++;
                endwhile;

                // Restore original Post Data
                wp_reset_postdata();

            endif;
            ?>
        </ul>
    </div>




    <!-- FULL BANNER CONTAINER -->
    <?php get_template_part('template_parts/banner', 'billboard'); ?>
    <!-- END: FULL BANNER CONTAINER -->

</div>