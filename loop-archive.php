
<li <?php post_class(); ?>>
    <?php
    $related_category = get_the_category( $id )[0];
    $related_category_link = get_category_link( $related_category->term_id );
    ?>
    <div class="category"><a href="<?php echo esc_url( $related_category_link ); ?>"><?php echo $related_category->name ?></a></div>
        
    <div class="photo_container">
        <a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
    </div>

    <div class="info_container">
        <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        
        
        <div class="date">Por <?php the_author() ?> | <?php the_time('d F y') ?></div>
        
        <div class="excerpt"><?php the_excerpt(); ?></div>
    </div>
</li>
