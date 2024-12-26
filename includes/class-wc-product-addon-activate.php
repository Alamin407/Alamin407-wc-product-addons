<?php
/**
 * Handles plugin activation tasks.
 */
class WC_Product_Addon_Activate {

    /**
     * Runs on plugin activation.
     */
    public static function activate() {
        // Example: Set default options for the plugin.
        $default_section_title = 'Choose Addons';
        if ( ! get_option( 'wc_product_addon_section_title' ) ) {
            update_option( 'wc_product_addon_section_title', $default_section_title );
        }
    }
    
}
