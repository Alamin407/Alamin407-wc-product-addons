<?php
/**
 * Plugin Name: WooCommerce Product Addon Options
 * Description: Adds extra addon options to WooCommerce products with prices displayed and calculated dynamically.
 * Version: 1.2.0
 * Author: MD AL AMIN ISLAM
 * * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define( 'WC_ADDON_OPTIONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WC_ADDON_OPTIONS_URL', plugin_dir_url( __FILE__ ) );

// Include the main class file
require_once WC_ADDON_OPTIONS_PATH . 'includes/class-wc-product-addon-activate.php';
require_once WC_ADDON_OPTIONS_PATH . 'includes/class-wc-product-addon-deactivate.php';

// Register activation and deactivation hooks.
register_activation_hook( __FILE__, [ 'WC_Product_Addon_Activate', 'activate' ] );

register_deactivation_hook( __FILE__, [ 'WC_Product_Addon_Deactivate', 'deactivate' ] );



require_once WC_ADDON_OPTIONS_PATH . 'includes/class-wc-product-addon-assets.php';
// Include the enqueue class file
require_once WC_ADDON_OPTIONS_PATH . 'includes/class-wc-product-addon-options.php';

// Initialize the plugin
add_action( 'plugins_loaded', function() {
    new WC_Product_Addon_Assets();
    new WC_Product_Addon_Options();
});
