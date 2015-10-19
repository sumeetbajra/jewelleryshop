<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

global $article_width;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($article_width); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			endif;
			$post_grid = ot_get_option('blog_post_grid');

			if ( ( $post_grid == 'on' && !is_single() ) && !is_search() ) {
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'shopera-post-picture');
			} else {
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'shopera-full-width');
			}
			
			if ( empty($img[0]) ) {
				$img[0] = get_template_directory_uri() . '/images/default-image.jpg';
			}

			if ( $post->post_type == 'post' ) {
				echo '<div class="content-image"><img src="'.$img[0].'" alt="post-img" class="post-inner-picture"></div>';
			}
		?>

		<div class="entry-meta">
			<?php if ( !is_single() ) { ?>
				<div class="entry-meta-left">
					<span class="date"><?php echo get_the_date('d', $post->ID); ?></span>
					<span class="month"><?php echo get_the_date('F', $post->ID); ?></span>
					<span class="year"><?php echo get_the_date('Y', $post->ID); ?></span>
				</div>
				<div class="entry-meta-right">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo get_the_title(); ?></a>
					<span class="post-by"><?php echo __('by', 'shopera').' '; ?><a href="<?php echo get_author_posts_url( get_post_field( 'post_author', $post->id ) );?>"><?php echo get_userdata( get_post_field( 'post_author', $post->id ) )->display_name; ?></a></span>
				</div>
				<div class="clearfix"></div>
			<?php } else {
				$tc = wp_count_comments($post->ID); ?>
				<div class="entry-meta-full">
					<span class="post-author"><span class="glyphicon glyphicon-user"></span><?php echo __('by', 'shopera').' ';?><a href="<?php echo get_author_posts_url( get_post_field( 'post_author', $post->id ) );?>"><?php echo get_userdata( get_post_field( 'post_author', $post->id ) )->display_name; ?></a></span>
					<?php
						$entry_utility_bottom = '';
						$categories_list = get_the_category_list( __( ', ', 'vh' ) );
						if ( $categories_list ) {
							$entry_utility_bottom .= '
							<span class="post-category"><span class="glyphicon glyphicon-folder-open"></span>
							' . $categories_list;
							$show_sep = TRUE;
							$entry_utility_bottom .= '
							</span>';
						}
						$tags_list = get_the_tag_list( '', __( ', ', 'vh' ) );
						if ( $tags_list ) {
							$entry_utility_bottom .= '
							<span class="post-category"><span class="glyphicon glyphicon-tag"></span>
							' . $tags_list;
							$show_sep = true;
							$entry_utility_bottom .= '
							</span>';
						}
						echo $entry_utility_bottom;
					?>
					<span class="post-comments"><span class="glyphicon glyphicon-comment"></span><?php echo $tc->total_comments.' '.__('Comments', 'shopera'); ?></span>
					<div class="post-share">
						<?php
							if ( defined('SSBA_VERSION') ) {
								echo do_shortcode('[ssba]');
							}
						?>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
			$content = wp_strip_all_tags( get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'shopera' ) ) );

			$post_grid = ot_get_option('blog_post_grid');

			if( empty( $content ) ) {
				$post_content = __( 'No excerpt for this post.', 'vh' );
			} elseif ( $post_grid == '' || $post_grid == 'off' || is_single() ) {
				echo '<p>'.$content.'</p>';
			} else {
				if ( strlen($content) > 140 ) {
					$post_content = substr($content, 0, 140) . '..';
				} else {
					$post_content = $content;
				}
				echo '<p>'.$post_content.'</p>';
			}
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'shopera' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post-## -->
