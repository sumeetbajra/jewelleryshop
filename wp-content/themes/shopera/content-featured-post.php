<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('swiper-slide'); ?>>
	<div class="slide-inner">
		<?php
			// Output the featured image.
			if ( has_post_thumbnail() ) :
				if ( 'grid' == get_theme_mod( 'featured_content_layout' ) ) { ?>
					<a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php
				} else {
					$slide_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'shopera-huge-width' ); ?>
					<div class="slide-image" style="background-image:url('<?php echo $slide_image_url[0]; ?>');"></div>
					<?php
				}
			endif;
		?>
		<header class="entry-header">
			<span class="category-title-top"><?php _e('Brand new collection', 'vh'); ?></span>
			<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h1>' ); ?>
			<div class="clearfix"></div>
		</header><!-- .entry-header -->
		<div class="slider-content">
			<?php the_excerpt(); ?>
		</div>
	</div>
</article><!-- #post-## -->
