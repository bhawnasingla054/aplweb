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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'c6ebh>|$j%tQ9lEd:b%X,`Jh5OVo2T{+:PK)J-[!D?bX`CI[@+h4MkkbZwsH=+vN' );
define( 'SECURE_AUTH_KEY',   '~(v@j<t5Y[,Zn<lCB|t8e}m$_Q F97,}>9`R/5w* N+%TPO$MB:sB=:h4Z9y:V6X' );
define( 'LOGGED_IN_KEY',     'AuORg[4M}*QyWU*W+3O/&QwrZX?&HNVXXnPV!TdWei5)k^M-(z)nexC[w4$Q~6Gv' );
define( 'NONCE_KEY',         'U&[9xn|,Z1~UHDkfX;aeu?TpreZ/0/+rS;08?g/<[aG2C+Ks&O!#]a1,eYXt??e}' );
define( 'AUTH_SALT',         'CxlB2-v#<)O+o]V@:<)eM4or 61_@bIBn[}1&R0xhWAUetV]`z4@cAS*LDVbZ.Ww' );
define( 'SECURE_AUTH_SALT',  ')PA>CsX^GnuIM[zoS8{wB85d.vrEq mrWQ#[:Gim:Rru;LB:Ca-)BL9rQ^TXuLW6' );
define( 'LOGGED_IN_SALT',    'Q2KlDB6Tw1s8^49>}drv*?I!0,w~~aVB,[W9[dESho=5=+bs2Q3NxPFyi2QzG_uM' );
define( 'NONCE_SALT',        'Rh4Y${h[<5<S(NQLZ9fZefEWf*~`cO01VS:!+r6%M3zsNh|vucC>%feXIdMU(Ewq' );
define( 'WP_CACHE_KEY_SALT', 'NSW5kySakWid,_mV)2eZ60|T%Qv5U,0d-qr6t^7K]Rm!kq]~0!.C/.Fde^K{MRQ@' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
