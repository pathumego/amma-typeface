<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'vishvaka_other');

/** MySQL database username */
define('DB_USER', 'vishvaka_other');

/** MySQL database password */
define('DB_PASSWORD', 'xk6au16PS7');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'sre86ntifsvnadcv8vrvdvrebysvlngdacittqzu4nrcdqdfbandpcwd1szdxxyf');
define('SECURE_AUTH_KEY',  'roy0mtxnl9oudoyeid5tdoydrbudfeody70e0azyj3qys84dsvuqf3prwlueqfto');
define('LOGGED_IN_KEY',    'xy3degh3l7jgvjgbrfi9zq2crrnnykw9lge87xqrbcuijugioxpss8bj0jer6cd6');
define('NONCE_KEY',        'lcj4ombgdry7dgj51mwmmqgez281askeec78tged7zia2227dlummoi9qrjoshap');
define('AUTH_SALT',        'ykmtcfl2cumueuwbco1wk9ru39hedpgtgqou2zh82ge8tpvjosxfwfztsteet3zh');
define('SECURE_AUTH_SALT', 'fhsylnp2lua7akt3sqs6aua0l76pugophcbxacbxxdhbkjltlo7uujozwrdegaut');
define('LOGGED_IN_SALT',   'hvd3nvxgdte9jfean4qwoijh0lokddfgqpyzhfq82aavl0tv347kwwydu2mflcuv');
define('NONCE_SALT',       'casjlcqlbcqwbgvtxd7wwbvdaqwdbsmozvo4u9zgnogilndh3ornywv73qvmxiif');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
