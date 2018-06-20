<?php
/**
 * Plugin Name: Martfury Addons
 * Plugin URI: http://drfuri.com/martfury
 * Description: Extra elements for Visual Composer. It was built for Martfury theme.
 * Version: 1.0.1
 * Author: DrFuri
 * Author URI: http://drfuri.com/
 * License: GPL2+
 * Text Domain: martfury
 * Domain Path: /lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'MARTFURY_ADDONS_DIR' ) ) {
	define( 'MARTFURY_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'MARTFURY_ADDONS_URL' ) ) {
	define( 'MARTFURY_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once MARTFURY_ADDONS_DIR . '/inc/taxonomies.php';
require_once MARTFURY_ADDONS_DIR . '/inc/visual-composer.php';
require_once MARTFURY_ADDONS_DIR . '/inc/shortcodes.php';
require_once MARTFURY_ADDONS_DIR . '/inc/socials.php';

if ( is_admin() ) {
	require_once MARTFURY_ADDONS_DIR . '/inc/importer.php';
}

/**
 * Init
 */
function martfury_vc_addons_init() {
	load_plugin_textdomain( 'martfury', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

	new Martfury_Taxonomies;
	new Martfury_VC;
	new Martfury_Shortcodes;

}

add_action( 'after_setup_theme', 'martfury_vc_addons_init', 30 );

