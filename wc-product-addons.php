<?php
/**
 * Plugin Name: WooCommerce Product Addon Options
 * Description: Adds extra addon options to WooCommerce products with prices displayed and calculated dynamically.
 * Version: 1.2.0
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define( 'WC_ADDON_OPTIONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WC_ADDON_OPTIONS_URL', plugin_dir_url( __FILE__ ) );

// Include the main class file
require_once WC_ADDON_OPTIONS_PATH . 'includes/class-wc-product-addon-assets.php';
// Include the enqueue class file
require_once WC_ADDON_OPTIONS_PATH . 'includes/class-wc-product-addon-options.php';

// Initialize the plugin
add_action( 'plugins_loaded', function() {
    new WC_Product_Addon_Assets();
    new WC_Product_Addon_Options();
});
