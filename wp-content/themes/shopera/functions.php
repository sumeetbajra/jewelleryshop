<?php
/**
 * Shopera 1.0 functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
require( get_template_directory() . '/theme-options.php' );

/**
 * Set up the content width value based on the theme's design.
 *
 * @see shopera_content_width()
 *
 * @since Shopera 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/**
 * Shopera 1.0 only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'shopera_setup' ) ) :
/**
 * Shopera 1.0 setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Shopera 1.0
 */
function shopera_setup() {
	require(get_template_directory() . '/inc/metaboxes/layouts.php');

	/*
	 * Make Shopera 1.0 available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Shopera 1.0, use a find and
	 * replace to change 'shopera' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'shopera', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css' ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'shopera-full-width', 1170, 600, true );
	add_image_size( 'shopera-huge-width', 1800, 600, true );
	add_image_size( 'shopera-cart-item', 46, 46, true );
	add_image_size( 'shopera-brand-image', 170, 110, true );
	add_image_size( 'shopera-post-picture', 400, 260, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'shopera' ),
		'footer'    => __( 'Footer menu', 'shopera' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'shopera_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'shopera_get_featured_posts',
		'max_posts' => 6,
	) );

	add_theme_support( 'featured-side-content', array(
		'featured_content_filter' => 'shopera_get_featured_side_posts',
		'max_posts' => 5,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // shopera_setup
add_action( 'after_setup_theme', 'shopera_setup' );

// Admin CSS
function shopera_admin_css() {
	wp_enqueue_style( 'vh-admin-css', get_template_directory_uri() . '/css/wp-admin.css' );
}

add_action('admin_head','shopera_admin_css');

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'shopera_content_width' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Shopera 1.0
 *
 * @return array An array of WP_Post objects.
 */
function shopera_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Shopera 1.0.
	 *
	 * @since Shopera 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'shopera_get_featured_posts', array() );
}

function shopera_get_featured_side_posts() {
	/**
	 * Filter the featured posts to return in Shopera 1.0.
	 *
	 * @since Shopera 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'shopera_get_featured_side_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Shopera 1.0
 *
 * @return bool Whether there are featured posts.
 */
function shopera_has_featured_posts() {
	return ! is_paged() && (bool) shopera_get_featured_posts();
}

function shopera_has_featured_side_posts() {
	return ! is_paged() && (bool) shopera_get_featured_side_posts();
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Shopera 1.0
 *
 * @return bool Whether there are featured posts.
 */
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
	ob_start();
	
	?>
	<div class="cart-contents">
		<span class="cart-items glyphicon glyphicon-shopping-cart"><span>
		<span class="cart-items-total"><?php echo $woocommerce->cart->cart_contents_count?></span>
		<div class="cart-content-list">
			<?php
				$cart_items = $woocommerce->cart->cart_contents;
				foreach ($cart_items as $cart_value) {
					$price = get_post_meta( $cart_value['product_id'], '_regular_price', true);
					echo '<div class="cart-list-item">';
						echo get_the_post_thumbnail($cart_value['data']->id, 'shopera-cart-item');
						echo '<div class="product-info">';
							echo '<span class="cart-item-title">'.$cart_value['data']->post->post_title.'</span>';
							echo '<span class="quantity">'.$cart_value['quantity'].' x <span>'.get_woocommerce_currency_symbol().$cart_value['line_subtotal'].'</span></span>';
						echo '</div>';
						echo '<span class="cart-item-price">'.get_woocommerce_currency_symbol().$price.'</span>';
						echo '<div class="clearfix"></div>';
					echo '</div>';
				}
			?>
			<div class="cart-lower">
				<?php 
				global $woocommerce;
				if ( sizeof( $woocommerce->cart->cart_contents) > 0 ) { ?>
				<a href="<?php echo $woocommerce->cart->get_checkout_url() ?>" class="button left" title="<?php _e( 'Checkout', 'shopera' ) ?>"><?php _e( 'Checkout', 'shopera' ) ?></a>
				<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="button right"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
				
				<span class="subtotal">
					<?php
					echo __('Subtotal:', 'shopera'). ' <span>' . get_woocommerce_currency_symbol() . $woocommerce->cart->cart_contents_total.'</span>';
					?>
				</span>
				<div class="clearfix"></div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
	
	$fragments['div.cart-contents'] = ob_get_clean();
	
	return $fragments;
	
}

/**
 * Register three Shopera 1.0 widget areas.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'shopera' ),
		'id'            => 'sidebar-1',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Main sidebar that appears on the left.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'shopera' ),
		'id'            => 'sidebar-2',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Additional sidebar that appears on the right.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'shopera' ),
		'id'            => 'sidebar-6',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Additional sidebar that appears on the right.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 1', 'shopera' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 2', 'shopera' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Appears in the footer section of the site.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 3', 'shopera' ),
		'id'            => 'sidebar-5',
		'description'   => __( 'Appears in the footer section of the site.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
}
add_action( 'widgets_init', 'shopera_widgets_init' );

/**
 * Register Google fonts for Shopera 1.0.
 *
 * @since Shopera 1.0
 *
 * @return string
 */
function shopera_font_url() {
	$fonts_url        = '';
	$roboto           = ot_get_option('google_font_roboto');
	$roboto_slab      = ot_get_option('google_font_roboto_slab');
	$open_sans        = ot_get_option('google_font_open_sans');
	$satisfy          = ot_get_option('google_font_satisfy');
	$roboto_condensed = ot_get_option('google_font_roboto_condensed');

	$font_families = array();
	
	if ( 'off' !== $roboto ) {
		$font_families[] = 'Raleway:400,100,300,700,900';
	}

	if ( 'off' !== $roboto_slab ) {
		$font_families[] = 'Raleway+Slab:400,100,300,700';
	}

	if ( 'off' !== $open_sans ) {
		$font_families[] = 'Open+Sans:400,300,700';
	}

	if ( 'off' !== $satisfy ) {
		$font_families[] = 'Satisfy:400,100,300,700,900';
	}

	if ( 'off' !== $roboto_condensed ) {
		$font_families[] = 'Roboto Condensed:400,100,300,700,900';
	}

	if ( !empty($font_families) ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

function vh_woocommerce_output_related_products() {

	$args = array(
		'posts_per_page' => 4,
		'columns' => 4,
		'orderby' => 'rand'
	);

	woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_sidebar', 'vh_woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array() );

	// Add Google fonts
	// wp_register_style('googleFonts');
	wp_enqueue_style( 'googleFonts', shopera_font_url());

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'shopera-style', get_stylesheet_uri(), array( 'genericons' ) );

	wp_enqueue_style( 'responsiveness', get_template_directory_uri() . '/css/responsive.css', array(), '3.0.2' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'shopera-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() ) {
		wp_enqueue_script( 'shopera-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
	}

	wp_enqueue_script( 'shopera-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20131209', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '20131209', true );
	wp_enqueue_script( 'jcarousel', get_template_directory_uri() . '/js/jquery.jcarousel.pack.js', array( 'jquery' ), '20131209', true );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array() );
}
add_action( 'wp_enqueue_scripts', 'shopera_scripts' );

// Admin Javascript
add_action( 'admin_enqueue_scripts', 'shopera_admin_scripts' );
function shopera_admin_scripts() {
	wp_register_script('master', get_template_directory_uri() . '/inc/js/admin-master.js', array('jquery'));
	wp_enqueue_script('master');
}

if ( ! function_exists( 'shopera_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Shopera 1.0 attachment size.
	 *
	 * @since Shopera 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'shopera_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Shopera 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function shopera_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	$post_grid = ot_get_option('blog_post_grid');
	if ( ( is_archive() || is_search() || is_home() ) && ( $post_grid == 'on' && !is_single() ) ) {
		$classes[] = 'post-grid';
	}

	return $classes;
}
add_filter( 'body_class', 'shopera_body_classes' );

function shopera_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'vh' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'vh' ), '<span class="edit-link button blue">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 60;
						echo get_avatar( $comment, $avatar_size );							
					?>
				</div><!-- .comment-author .vcard -->
			</div>

			<div class="comment-content">
				<?php
					echo '<a href="'.get_author_posts_url($comment->user_id).'" class="fn">' . get_comment_author_link() . '</a>';
					echo '<div class="reply-edit-container">';
					echo '<span class="comment-time">'.get_comment_time("F d, Y g:i a").'</span>';
				?>
					<span class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'vh' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</span><!-- end of reply -->
					<?php edit_comment_link( __( 'Edit', 'vh' ), '<span class="edit-link button blue">', '</span>' ); ?>
					<div class="clearfix"></div>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'vh' ); ?></em>
				<?php endif; ?>
				<?php comment_text(); ?>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div><!-- end of comment -->

	<?php
			break;
	endswitch;
}

// custom comment fields
function vh_custom_comment_fields($fields) {
	global $post, $commenter;

	$fields['author'] = '<div class="comment_auth_email"><p class="comment-form-author">
							<input id="author" name="author" type="text" class="span4" placeholder="' . __( 'Name', 'vh' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" aria-required="true" size="30" />
						 </p>';

	$fields['email'] = '<p class="comment-form-email">
							<input id="email" name="email" type="text" class="span4" placeholder="' . __( 'Email', 'vh' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" aria-required="true" size="30" />
						</p></div>';

	$fields = array( $fields['author'], $fields['email'] );
	return $fields;
}
add_filter( 'comment_form_default_fields', 'vh_custom_comment_fields' );

function vh_woo_edit_before_shop_page() {
	if ( is_active_sidebar( 'sidebar-6' ) ) {
		$extra = ' col-sm-9 col-md-9 col-lg-9';
	} else {
		$extra = '';
	}
	echo '<div class="woo-shop-page'.$extra.'">';
}
add_action( 'woocommerce_before_shop_loop', 'vh_woo_edit_before_shop_page' );

function vh_woo_edit_after_shop_page() {
	echo '</div>';
	echo get_sidebar( 'shop' );
}
add_action( 'woocommerce_after_shop_loop', 'vh_woo_edit_after_shop_page' );

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Shopera 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function shopera_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'shopera_post_classes' );

function get_woo_categories( $post_id, $category_slug ) {
	$cat_post = get_post( $post_id ); 
	$cat_excerpt = $cat_post->post_excerpt;
	$output = '';

	$output .= '<div class="woo-category-item">';
		$slide_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'shopera-huge-width' );
		$output .= '<div class="woo-category-image" style="background-image:url('.$slide_image_url[0].');"></div>';
		$output .= '<div class="woo-category-inner">';
			$output .= '<span class="woo-category-title">'.get_the_title($post_id);
			$output .= '<br /><span class="woo-category-excerpt">-'.$cat_excerpt.'-</span>';
			$output .= '</span>';
		$output .= '</div>';
		$output .= '<a href="'.site_url().'/?product_cat='.$category_slug.'"></a>';
	$output .= '</div>';

	echo $output;
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Shopera 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function shopera_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'shopera' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'shopera_wp_title', 10, 2 );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}

if ( ! class_exists( 'Featured_Content_Side' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content-side.php';
}

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    http://wordpress.stackexchange.com/q/14037/
 * @author toscho, http://toscho.de
 */
class Header_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes         = empty ( $item->classes ) ? array () : (array) $item->classes;
		$has_description = '';

		$class_names = join(
			' '
		,   apply_filters(
				'nav_menu_css_class'
			,   array_filter( $classes ), $item
			)
		);

		// insert description for top level elements only
		// you may change this
		$description = ( ! empty ( $item->description ) )
			? '<small>' . esc_attr( $item->description ) . '</small>' : '';

		$has_description = ( ! empty ( $item->description ) )
			? 'has-description ' : '';

		! empty ( $class_names )
			and $class_names = ' class="' . $has_description . esc_attr( $class_names ) . '"';

		$output .= "<li id='menu-item-$item->ID' $class_names>";

		$attributes  = '';

		if ( !isset($item->target) ) {
			$item->target = '';
		}

		if ( !isset($item->attr_title) ) {
			$item->attr_title = '';
		}

		if ( !isset($item->xfn) ) {
			$item->xfn = '';
		}

		if ( !isset($item->url) ) {
			$item->url = '';
		}

		if ( !isset($item->title) ) {
			$item->title = '';
		}

		if ( !isset($item->ID) ) {
			$item->ID = '';
		}

		if ( !isset($args->link_before) ) {
			$args = new stdClass();
			$args->link_before = '';
		}

		if ( !isset($args->before) ) {
			$args->before = '';
		}

		if ( !isset($args->link_after) ) {
			$args->link_after = '';
		}

		if ( !isset($args->after) ) {
			$args->after = '';
		}

		! empty( $item->attr_title )
			and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
		! empty( $item->target )
			and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
		! empty( $item->xfn )
			and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
		! empty( $item->url )
			and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$item_output = $args->before
			. "<a $attributes>"
			. $args->link_before
			. '<span>' . $title . '</span>'
			. $description
			. '</a> '
			. $args->link_after
			. $args->after;

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
		,   $item_output
		,   $item
		,   $depth
		,   $args
		);
	}
}