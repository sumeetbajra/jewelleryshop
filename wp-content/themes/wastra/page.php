<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

get_header();

global $site_width;
?>

<div id="main-content" class="main-content row">
	<?php
		get_sidebar();
	?>
	<div id="primary" class="content-area <?php echo $site_width; ?>">
		<div id="content" class="site-content" role="main">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );


				endwhile;
			?>

                  <?php
                        if ( is_front_page() ) : ?>
				<div class="woocommerce columns-4">
					<ul class="products">
						<?php
							$args = array( 'post_type' => 'product', 'posts_per_page' => 10 );
							$loop = new WP_Query( $args );
							while ( $loop->have_posts() ) : $loop->the_post();
								$image = get_post_meta( get_the_ID(), 'picture', true);
			    					$price = get_post_meta( get_the_ID(), 'price', true);
			    					$code = get_post_meta( get_the_ID(), 'product_code', true);
						?>
							<a href = "<?php echo the_permalink(); ?>">
								<li class="product">
									<div class="product-image">
										<img src = "<?php echo wp_get_attachment_url( $image ); ?>" class="img-responsive">
										<span class="price">
											<span class="amount">Rs. <?php echo $price; ?></span><br>
										</span>
									</div>
									<h3>
										<?php the_title(); ?><br>
										Product code: <?php echo $code; ?>
									</h3>
								</li>
							</a>
						<?php endwhile; ?>
					</ul>
				</div>

				<?php
				$args = array(
					'type' => 'product',
					'orderby' => 'count',
					'order' => 'DESC',
					'taxonomy' => 'category',
					'number' => '4',
				);
				$categories = get_categories( $args ); ?>
				<div class="woo-category-container three">
					<?php foreach($categories as $category): ?>
						<?php if ( $category->name != 'Uncategorized') : ?>
							<div class="woo-category-item">
								<div class="woo-category-image" style="background-image:url(<?php echo z_taxonomy_image_url($category->cat_ID); ?>);"></div>
								<a href="<?php echo get_category_link( $category->term_id ); ?>" class="woo-category-inner category-caption">
									<span class="woo-category-title paint-area paint-area--text"><?php echo $category->name; ?><br>
									<span class="woo-category-excerpt paint-area paint-area--text">-Collection-</span></span>
								</a>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
					<div class="clearfix"></div>
				</div>
                  <?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_footer();
