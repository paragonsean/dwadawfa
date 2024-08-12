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
define( 'WP_MEMORY_LIMIT','1256M' );
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define('DISABLE_WP_CRON', 'true');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Px/(xhPMv2X61_L@X0RFaloL23z:IQx~DMp-U%kXa!~VRx!A#9tb3MNsz6~p6_p/');
define('SECURE_AUTH_KEY', 'K_+B@qE9C9/0&g4z72[umoL2p&@5+S8~uH44Y969C2[Px|-Ey9[nrsJcb7)@:-6C');
define('LOGGED_IN_KEY', '05gb9nwpX10@7fJN1I||:z8;/5+bIDz6ScE[3L]5G14A513QTq5BFpL!7N;78/8b');
define('NONCE_KEY', 'elb*v)a_pf3(D]8A[49t;)I4#rXxOM0L639m_[_f*h5YQm@;9d4C512@b4w96gde');
define('AUTH_SALT', 'TY:#nsQ[|G4e18H~aSBYUP#VAzNW7KM!MZare#839Ix@ds8P840[7)46T97-b2U|');
define('SECURE_AUTH_SALT', 'J_vk27273UUCJ3&0tOr/9/O48M2A+9;9AO4;T#9H1G92ZSDN]OAMy8n41H@exu)J');
define('LOGGED_IN_SALT', '0rMq48Y:)*&3/&m0Pe3;]3G3qfvW67QlP5I/WyB!v[9;j|941IFpd2Uk0#l_H~!2');
define('NONCE_SALT', 'pe:gV#[do5;ZC3j:E]O@NMZn-b(i~9ZZH:MxT64)Z#+3tzI65m)GlaIde41!&n5U');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'heoswlz9_';


define('WP_ALLOW_MULTISITE', true);
define( 'DISALLOW_FILE_EDIT', true );
define( 'CONCATENATE_SCRIPTS', false );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
