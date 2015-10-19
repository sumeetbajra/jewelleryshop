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
				$image = get_post_meta( get_the_ID(), 'picture', true);
				$price = get_post_meta( get_the_ID(), 'price', true);
				$code = get_post_meta( get_the_ID(), 'product_code', true);
				$weight = get_post_meta( get_the_ID(), 'weight', true);
				$material = get_post_meta( get_the_ID(), 'material', true);
			?>
			<div class = "single-product-page container">
				<div class = "row">
					<div class = "col-md-4">
						<img src = "<?php echo wp_get_attachment_url( $image ); ?>" class="img-responsive img-bordered">
					</div>
					<div class = "col-md-8">
						<h1 itemprop="name" class="product_title entry-title"><?php echo the_title(); ?></h1><hr>
						<label>Price</label>Rs. <?php echo $price; ?><br>
						<label>Code</label><?php echo $code; ?><br>
						<label>Weight</label><?php echo $weight; ?><br>
						<label>Material</label><?php echo $material; ?><br><br>

						<button class = "btn btn-success">Inquire about this product</button><br><br>

						<div class = "share-product">
							<a data-site="" class="ssba_google_share" href="https://plus.google.com/share?url=http://cohhe.com/demo/shopera/product/distressed-jeans/" target="_blank">
								<img src="http://cohhe.com/demo/shopera/wp-content/plugins/simple-share-buttons-adder/buttons/somacro/google.png" title="Google+" class="ssba ssba-img" alt="Share on Google+">
							</a>
							<a data-site="" class="ssba_twitter_share" href="http://twitter.com/share?url=http://cohhe.com/demo/shopera/product/distressed-jeans/&amp;text=Distressed+jeans+" target="_blank">
								<img src="http://cohhe.com/demo/shopera/wp-content/plugins/simple-share-buttons-adder/buttons/somacro/twitter.png" title="Twitter" class="ssba ssba-img" alt="Tweet about this on Twitter">
							</a>
							<a data-site="" class="ssba_facebook_share" href="http://www.facebook.com/sharer.php?u=http://cohhe.com/demo/shopera/product/distressed-jeans/" target="_blank">
								<img src="http://cohhe.com/demo/shopera/wp-content/plugins/simple-share-buttons-adder/buttons/somacro/facebook.png" title="Facebook" class="ssba ssba-img" alt="Share on Facebook">
							</a>
						</div>
					</div>
				</div>

				<div class = "similar-prod">
					<h4>Similar products</h4><hr>
					<div class="woocommerce columns-4">
						<ul class="products">
							<?php
								$args = array( 'post_type' => 'product', 'posts_per_page' => 4 );
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
				</div>
			</div>

			<div class="clearfix"></div>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_footer();
