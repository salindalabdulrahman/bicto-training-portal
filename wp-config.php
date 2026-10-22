<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bictotrainingportal_db' );

/** Database username */
define( 'DB_USER', 'root_user' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         '2N0,bb9mW6(?3F>.5@XE=cLtU:}S8,LpJZ0$QUTH41J8cSA,Xa]Txq2G{@I-Ly5j' );
define( 'SECURE_AUTH_KEY',  'Z `-)fD5~l dWc;;Fisst:r521:%3i=$bvu*p(~[-F>kY4 vW{vl. 19O>%9d/_,' );
define( 'LOGGED_IN_KEY',    'S*}K/-4@H_44 ~cxzV7++v_Y m:z:pALc>-]R(KQ3v<A3w< /T_w+5G^%Esfp5W/' );
define( 'NONCE_KEY',        '5cH8U/AjBQS~^x0aRy3$:.%dOxQcbQ]TeyZVxznIy:.1ZBk#j5`^6(DZ1_#y_FXU' );
define( 'AUTH_SALT',        '$K*Pq{O6})T#4m]p#&v|z#TTJKqk;,vf!zBHFDqT)keWLzml_cmBXX98fhg;)lyR' );
define( 'SECURE_AUTH_SALT', 'y-=KXjT~$&gy[j^siuC&6cLfODsFHweAe.PB#44~AurAyEZxw0GY;s!ad8r@up_)' );
define( 'LOGGED_IN_SALT',   'NL/MO>MsW@S=jax6^FIN!#]u>d-6&.pjVuqv=@o/u.ZJJcg{Fi5ib=4[UgArF@Ik' );
define( 'NONCE_SALT',       'QDuP*}`cK>e]McE1ap3U@X:uWu047IAjW`$}N/)*@])-#9%pK/A:j.6qFSslY|L_' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', '0' );

define( 'FS_METHOD', 'direct' );
/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
