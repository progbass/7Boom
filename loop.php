<?php
/**
 * 7boom template for displaying the standard Loop
 *
 * @package WordPress
 * @subpackage 7boom
 * @since 7boom 1.0
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
                

