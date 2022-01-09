<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'innoshop' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Q7q74hTCT`8Yjw<OwFsFpW2@aI;J~W)yplElk~VWuL$[Rj1xzVZ(s91L2@hLG.}%' );
define( 'SECURE_AUTH_KEY',  '@TGc%&$}CN+bs:[GQ]*M${tT)BmqnvK$[[,UV>lao5bg]X=BY!N@nZ]b#2&YPW#9' );
define( 'LOGGED_IN_KEY',    '+;,%CU-4q0Nkn`lC1[6x9^^Z8U:7wOi4w$2lG$umaA(W>5T~,8lev5Dm;||E #Tp' );
define( 'NONCE_KEY',        '570b|kPMWXaer;d*4;juTn^zH4HxRysVUm)W`2rcPnUbdE`q7;}4-004rnS0%2ZU' );
define( 'AUTH_SALT',        'zLzJ k5)6qd:Wq:x>JsdJq?LczDS.g!_gTa`ZyHlC<|!H|j<zCpy[^)It8DF6WC#' );
define( 'SECURE_AUTH_SALT', '8L,E;BJ02nfYP9pDv*/,Qa=ooIL:D=5g%R{@i:tG7|b@D[wYuKvOc`YrhR=t-Mf/' );
define( 'LOGGED_IN_SALT',   'z*J0Bu@WXl%h6Vhedk2Z,WRzCa&d=T^6/45D^1yaS}6PJ}fxc;/QR-78ds`:L_^|' );
define( 'NONCE_SALT',       'Zv}Uy]Hr}lS>j?~Phg{9U<B3D-$fm;#j.MrJG9)}c[7>*KStjCskyL]K! Ic(]K~' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_innoshop';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
