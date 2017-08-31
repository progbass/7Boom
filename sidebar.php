<aside>
    <div class="related">
        <h4>M&aacute;s Le&iacute;dos</h4>

        <ul>
            <?php
            $related_args = array(
                'posts_per_page' => 3,
                'post_status'	 => 'publish'
            );
            $related_posts = new WP_Query($related_args);

            if ( $related_posts->have_posts() ):

                $counter = 0;
                while( $related_posts->have_posts() ) :
                    $related_posts->the_post(); ?>

                    <li <?php post_class(); ?>>
                        <div class="photo_container">
                            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
                        </div>

                        <div class="info_container">
                            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

                               <?php
                                $related_category = get_the_category( $id )[0];
                                $related_category_link = get_category_link( $related_category->term_id );
                                ?>
                               <div class="meta">
                                <div class="category"><a href="<?php echo esc_url( $related_category_link ); ?>"><?php echo $related_category->name ?></a></div>
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