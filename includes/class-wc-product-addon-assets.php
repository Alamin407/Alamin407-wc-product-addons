<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class WC_Product_Addon_Assets {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function enqueue_admin_assets() {
        wp_enqueue_script(
            'wc-addon-scripts',
            WC_ADDON_OPTIONS_URL . 'assets/js/scripts.js',
            [ 'jquery' ],
            '1.0.0',
            true
        );

        wp_enqueue_style(
            'wc-addon-styles',
            WC_ADDON_OPTIONS_URL . 'assets/css/styles.css',
            [],
            '1.0.0'
        );
    }

    /**
     * Enqueue frontend scripts and styles.
     */
    public function enqueue_frontend_assets() {
        // Register scripts
        wp_register_script(
            'wc-product-addon-frontend',
            WC_ADDON_OPTIONS_URL . 'assets/js/frontend.js',
            [ 'jquery' ],
            '1.0.0',
            true
        );

        // Register styles
        wp_register_style(
            'wc-product-addon-frontend-style',
            WC_ADDON_OPTIONS_URL . 'assets/css/frontend.css',
            [],
            '1.0.0'
        );

        // Enqueue scripts and styles
        wp_enqueue_script( 'wc-product-addon-frontend' );
        wp_enqueue_style( 'wc-product-addon-frontend-style' );
    }
}
