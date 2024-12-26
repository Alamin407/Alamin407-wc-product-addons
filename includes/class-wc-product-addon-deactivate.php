<?php
/**
 * Handles plugin deactivation tasks.
 */
class WC_Product_Addon_Deactivate {

    /**
     * Runs on plugin deactivation.
     */
    public static function deactivate() {
        // Example: Remove options.
        delete_option( 'wc_product_addon_section_title' );

        // Delete all post meta fields added by the plugin.
        global $wpdb;

        // Delete addon titles.
        $wpdb->query( 
            "DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_addon_titles'" 
        );

        // Delete addon prices.
        $wpdb->query( 
            "DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_addon_prices'" 
        );

        // Delete section title.
        $wpdb->query( 
            "DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_addon_section_title'" 
        );

        // You can add more meta cleanup queries here if needed.
    }
}
