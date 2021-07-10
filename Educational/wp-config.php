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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ET|Q$cbF9W?{y4=Kq&05cLimYix]%m&RUY+F;I:t)gtEpT]Y!+q@74&8Z@_2dqNf' );
define( 'SECURE_AUTH_KEY',  'k71NQ33lEiu8fjNhB{w<;L8-tJD+ig}g0e1&{yux4mp)X?><E.sw8)+O^+)}zDVv' );
define( 'LOGGED_IN_KEY',    '5rd$TPILcPx?O<5s^WGT`{E*49r.jqLh?NJlob- ZQSh0Kdtr,(@@CH3sIm}1>k^' );
define( 'NONCE_KEY',        'qxbfZ6p2!IC*FgC#1z4b2gn_>`T=FB8guhL`d&CWri`(6k7GH)D-Wc=,Kg*/$?6S' );
define( 'AUTH_SALT',        'vDp#@S)ULvgZm^VSQ#1QEt-9cPROgo @8d|HL^8PIzAQEKsCk:Pmycy55EYc7,zC' );
define( 'SECURE_AUTH_SALT', 'Udv}:k_h+iJHe=qEqZKvo;07I)r7ZyA($?m^R@j8PaeT(Gihff0$qew8(ltO#(Km' );
define( 'LOGGED_IN_SALT',   'S>Oxfxn5`SK%{#e02._#}eTEG?kP7z3L /pu)H#H2K:d{Wsb_[0kqx3!VD).,=<,' );
define( 'NONCE_SALT',       'NP1u]hR`ibh`j#sO|P@kh0hxQ4 ]k;bm_oiz>F&+,gbFbV ;BOlYwEqnbV}Yz& 5' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
