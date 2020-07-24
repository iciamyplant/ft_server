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
define( 'DB_USER', 'wordpress_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'e4WvxGz`Wn|4>&@mY9iM9A6[w^-LAmf-86+@sv6b 11rK?XA,kax-|1iYyr5[;5K' );
define( 'SECURE_AUTH_KEY',  'C3tk|[poAR;W5=ArZ( L+O+NbPa,&h`c3vFMkU~-T_b5=?TVzaw*dPzBZDS_z.+j' );
define( 'LOGGED_IN_KEY',    'xqjuR7sRQPZ,=aIzv91c BWHa4 ^+,,@t c^ju?6O*A_2:x|*9ipm1Y/y[10PpHv' );
define( 'NONCE_KEY',        '.<MrGUo`5onLp2(DK?twOCl/DBom#]n_qB#CLUQ*R-^5w1]SGedLhr+yR^?VrB=s' );
define( 'AUTH_SALT',        '0 k<@]|&~R:/ne; #:Z=khXb.CRV:`B:|U2Q.W/XX^vO2QUAK@/~k|D4p2<$7L(T' );
define( 'SECURE_AUTH_SALT', '-Y0R2mO3~+0{9(^~>=*E_M<i?y^l|l5?QXxy];iH3Z_|,Uq?w1]D.qkwl+&DRMda' );
define( 'LOGGED_IN_SALT',   'W;z+R`0ote|s+*P&{^+j^nB4_.ob0x]5Ini3wA-.>j*vS}(fNsxQW/<A?t/U*OWy' );
define( 'NONCE_SALT',       'qvLnRDxkv3-Wp>lq_xjnl]R9T|C^MSc9ZW<rN3nb~akZM2wjG-1hjCGD}QA8lvL(' );

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
