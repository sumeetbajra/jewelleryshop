<?php
/**
 * The template for displaying posts in the Audio post format
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<span class="post-format post-format-audio">
			<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'audio' ) ); ?>"><span class="glyphicon glyphicon-music"></span></a>
		</span>
		<?php

			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;
		?>
		<div class="entry-meta">
			<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && shopera_categorized_blog() ) : ?>
				<span class="cat-links"><span class="glyphicon glyphicon-eye-open"></span><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'shopera' ) ); ?></span>
			<?php
				endif;

				if ( 'post' == get_post_type() )
					shopera_posted_on();

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><span class="glyphicon glyphicon-comment"></span><?php comments_popup_link( __( 'Leave a comment', 'shopera' ), __( '1 Comment', 'shopera' ), __( '% Comments', 'shopera' ) ); ?></span>
			<?php
				endif;
			?>
			<?php the_tags( '<span class="tag-links"><span class="glyphicon glyphicon-tag"></span>', '', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<?php shopera_post_thumbnail(); ?>
	<div class="entry-content">
		<?php
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'shopera' ) );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'shopera' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			edit_post_link( __( 'Edit', 'shopera' ), '<span class="edit-link">', '</span>' );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
