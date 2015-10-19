<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'jewellery');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'PkGs?b!y{hZ| XkeD{p_E}Id/X,Xpf1VX)t|<[;]gIy(.4M P[~M?|MW9i-yNn?|');
define('SECURE_AUTH_KEY',  'sj,ho|v3S!2-+6iVF#.)kOD;hOv9+BR1m37;+$jPs>)6o7Tp<d^-x;Bl?+_fKZl?');
define('LOGGED_IN_KEY',    'L2NpW1L1RN-){(j}F^X0#b8k)p]#bulNlS+r;5OmT^u&:zEA+KI3QP s{h-3^>SG');
define('NONCE_KEY',        'Nw@@p=6R^w73dm:w=FsP&)$?1&Q/~?6y5ZAl;WTn7oV0+lTyw*`MUB+H(-Q!w)q^');
define('AUTH_SALT',        '=Hy**N:/YT]f0Xu=izFMCJE{jXfIM4H4Xz<O{2Ox%?ekeipn`-+2aP;a/5WN6h-|');
define('SECURE_AUTH_SALT', '<1Aws@k&yr^ytFoSGbU|a~*xuU_Wz1(Mv#A|{NXQMm0Kyo!8L)xo8Hn7Mz~1,TJ[');
define('LOGGED_IN_SALT',   'ef{D@2P!+CExD@K,?vT1Kw!k~7D3;_QiX@_E|ShvB#2ooElS-7<$n=KDfE0]3{*v');
define('NONCE_SALT',       'D)hZv)j|!_cjvvgL1v]i}LZ<y%1DkW(!j=YFtG^C#CJi~3+t{wRzx/]Ref,/pjpL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
