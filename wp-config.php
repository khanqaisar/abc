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
define('DB_NAME', 'market');

/** MySQL database username */
define('DB_USER', 'market');

/** MySQL database password */
define('DB_PASSWORD', 'admin123');

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
define('AUTH_KEY',         '&C^0hg%e0daM<7<KcJ:M9%7du%2TFX[Jb[[lH@9%JYzJ1X38gFX5L(~!n)QiKMjl');
define('SECURE_AUTH_KEY',  'Y4w9cWIq_kAI?8,iEp&_ex92vZW$@,Qi-Q^%O$9W@#{ _74]>kL)b$Z:a: aU_yP');
define('LOGGED_IN_KEY',    'jk|~e[ d {e-s[}&C0 wnV,&wn;.HYjNPXbvIW@#YWlAZXir0/z/%S7+*E9L>PIH');
define('NONCE_KEY',        '^:1m)Fp!p-Jlu !lY^JB[AG,Ko,&ml>qRTLOyXf6ibi(aRrcv5;`(k#1^!* ;+sC');
define('AUTH_SALT',        'q%1zF8L.92ZN4.!YcfIhgeC(Z3/Hw^v Lp~o%GrEwDEQTs_:eJ`Od:rx5AgGz!LZ');
define('SECURE_AUTH_SALT', 'z:]-D72DI`tS[_.kYH]`E9#RhbQj1ibSEUZQ.7bUW}<YKSf]U8w=2_p$DfIu)Ct|');
define('LOGGED_IN_SALT',   'PO)Z,qqa#)r2hfX*k[@rpnhX}c,^J2DGQ*qqN<H].zA~xPQm`TkYE#=F+60X9Z >');
define('NONCE_SALT',       ')mc~Rhvr/q&F.FQME.;,? Lz+LQ5B[9@J<oGxXqjFYOR0fGpw6MjX%)ooz?f&I/6');

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
