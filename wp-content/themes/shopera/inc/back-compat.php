<?php
/**
 * Shopera 1.0 back compat functionality
 *
 * Prevents Shopera 1.0 from running on WordPress versions prior to 3.6,
 * since this theme is not meant to be backward compatible beyond that
 * and relies on many newer functions and markup changes introduced in 3.6.
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

/**
 * Prevent switching to Shopera 1.0 on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'shopera_upgrade_notice' );
}
add_action( 'after_switch_theme', 'shopera_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Shopera 1.0 on WordPress versions prior to 3.6.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_upgrade_notice() {
	$message = sprintf( __( 'Shopera 1.0 requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'shopera' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Theme Customizer from being loaded on WordPress versions prior to 3.6.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_customize() {
	wp_die( sprintf( __( 'Shopera 1.0 requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'shopera' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'shopera_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 3.4.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Shopera 1.0 requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'shopera' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'shopera_preview' );
