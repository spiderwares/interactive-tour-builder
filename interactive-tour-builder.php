<?php
/**
 * Plugin Name:       Interactive Tour Builder
 * Description:       Create immersive and interactive tours for your website with the Interactive Tour Builder plugin. Engage your audience by showcasing key features, areas, or products through step-by-step virtual tours, pop-up tooltips, and guided highlights.
 * Version:           1.0.5
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Jthemes Studio
 * Author URI:        https://jthemes.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       interactive-tour-builder
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

if ( ! defined( 'INTB_FILE' ) ) {
    define( 'INTB_FILE', __FILE__ ); // Define the plugin file path.
}

if ( ! defined( 'INTB_BASENAME' ) ) {
    define( 'INTB_BASENAME', plugin_basename( INTB_FILE ) ); // Define the plugin basename.
}

if ( ! defined( 'INTB_VERSION' ) ) {
    define( 'INTB_VERSION', '1.0.5' ); // Define the plugin version.
}

if ( ! defined( 'INTB_PATH' ) ) {
    define( 'INTB_PATH', plugin_dir_path( __FILE__ ) ); // Define the plugin directory path.
}

if ( ! defined( 'INTB_URL' ) ) {
    define( 'INTB_URL', plugin_dir_url( __FILE__ ) ); // Define the plugin directory URL.
}

if ( ! defined( 'INTB_UPGRADE_URL' ) ) {
    define( 'INTB_UPGRADE_URL', 'https://codecanyon.net/item/wordpress-interactive-step-by-step-website-tour-builder/56730735' ); // Define the upgrade URL.
}

// Include the main INTB class file.
if ( ! class_exists( 'INTB', false ) ) {
    include_once INTB_PATH . 'include/class-intb.php';
}

// Initialize the plugin.
$GLOBALS['intb'] = INTB::instance();