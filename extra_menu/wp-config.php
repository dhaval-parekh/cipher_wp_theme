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
define('DB_NAME', 'i658486_oh671');

/** MySQL database username */
define('DB_USER', 'i658486_oh671');

/** MySQL database password */
define('DB_PASSWORD', 'T]2StN*3XE12(^6');

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
define('AUTH_KEY',         'h1isRGxGXVkPValylU2mDtHhGPcJYo7t0wfFwvjuZXEY8qLM3ZKYRkct2RsXv9dn');

define('SECURE_AUTH_KEY',  '8uAAPjGX9DQXskTXDKtlqThHvgIxFckFABvSdWcDxDQux3cHyPY8ocQvatVy3CTk');

define('LOGGED_IN_KEY',    '0QCJEZ0WGJq0FmeTEJuAEIryKhSnT7LUzHG15hwjwLzADfur3XKLGDI7R18s4qtS');

define('NONCE_KEY',        'hiicBof28J6yfQGPgQyI6Iz23Yxmc5HGmviIZqCbQkzB90xExaMj0u1M1fcnGjvu');

define('AUTH_SALT',        'wttIf9r44gWgXiFYcDfpCnyIk6LJl4YWNgGwFJmG1ctPmXWo7zVlWmIlbmeloYN8');

define('SECURE_AUTH_SALT', 'D5rIcpAOc6kvvjcWQkvah9SkDaCu79Xs8HRrgJPdIpeNMI7W4U3G1DuguHI9YC7W');

define('LOGGED_IN_SALT',   'bAqOkRYxcqUm9P01G5Z3z73MpHz1VvkGVBTtdhjxZuWfpIrTvEJ7K7tmTPKjVMyh');

define('NONCE_SALT',       'e1mC4zAJChjud5HecHifqFc5q4LdvDEBTzgUBZS4juT1Qo4HaCtJStUbUcO38LXF');



/**

 * Other customizations.

 */

define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');



/**

 * Turn off automatic updates since these are managed upstream.

 */

define('AUTOMATIC_UPDATER_DISABLED', true);



/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'oh67_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
