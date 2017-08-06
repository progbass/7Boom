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
	<div class="image_holder">
		<a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
	</div>

	<div class="info_holder">
		<h3>
			<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		</h3>

		<div class="meta"><?php the_time('d F y') ?></div>
		<a href="<?php the_permalink() ?>" class="more_btn">Ver M&aacute;s</a>
	</div>
	
	<?php
	$category = get_the_category( $id )[0];
	$category_link = get_category_link( $category->term_id );
	?>
	<div class="cat_display"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category->name ?></a></div>
</li>

