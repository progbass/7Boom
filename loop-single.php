<div class="article_container">

    <?php
    if ( have_posts() ) : the_post(); ?>

        <?php
        $category = get_the_category( $id )[0];
        $category_link = get_category_link( $category->term_id );
        ?>
	    
	    <article id="<?php the_ID();?>" class="category-<?php echo $category->slug; ?>">
	    
	        <div class="title_holder">
                <ul class="tags">
                    <li><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category->name; ?></a></li>
                    <li><a href="<?php echo esc_url( $category_link ); ?>">Ciencias</a></li>
                    <li><a href="<?php echo esc_url( $category_link ); ?>">Ciudades</a></li>
                </ul>

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
                

				<div class="content_holder">
					<div class="ad_container">
                        <div class="ad_unit boxbanner">
                            <img src="http://via.placeholder.com/300x250" alt="">
                        </div>
                    </div>

					<?php the_content(); ?>
				</div>
				
					
                <!-- Social Share -->
                <?php get_template_part('template_parts/single', 'social_share'); ?>
                <!-- END: Social Share -->

                <ul class="tags">
                    <li>Tags:</li>
                    <li><a href="<?php echo esc_url( $category_link ); ?>">Ciencias</a></li>
                    <li><a href="<?php echo esc_url( $category_link ); ?>">Ciudades</a></li>
                </ul>
			</div>


            <aside>

                <div class="banner_holder box">
                    <div class="ad_unit boxbanner">
                        <img src="http://via.placeholder.com/300x250" alt="">
                    </div>
                </div>
                
                <div class="banner_holder box">
                    <div class="ad_unit boxbanner">
                        <img src="http://via.placeholder.com/300x250" alt="">
                    </div>
                </div>


                <div class="related">
                    <h4>M&aacute;s Le&iacute;dos</h4>

                    <ul>
                        <?php
                        $chronological_args = array(
                            'posts_per_page' => 3,
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
                                $counter++;
                            endwhile;

                            // Restore original Post Data
                            wp_reset_postdata();

                        endif;
                        ?>
                    </ul>
                </div>
            </aside>
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
                    $counter++;
                endwhile;

                // Restore original Post Data
                wp_reset_postdata();

            endif;
            ?>
        </ul>
    </div>
        
        
	<div class="ad_container full_width">
        <div class="ad_unit billboard">
            <img src="http://via.placeholder.com/970x250" alt="">
        </div>
    </div>
</div>