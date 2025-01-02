<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class WC_Product_Addon_Options {

    public function __construct() {
        // Add custom tab
        add_filter( 'woocommerce_product_data_tabs', [ $this, 'add_custom_tab' ] );
        // Add custom fields to the custom tab
        add_action( 'woocommerce_product_data_panels', [ $this, 'add_custom_tab_content' ] );
        // Save custom fields
        add_action( 'woocommerce_process_product_meta', [ $this, 'save_custom_fields' ] );

        // Display addon options on the frontend
        add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'display_addon_options' ] );
        add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_cart_item_data' ], 10, 2 );

        // Update cart item price
        add_filter( 'woocommerce_get_item_data', [ $this, 'display_cart_item_data' ], 10, 2 );
        add_filter( 'woocommerce_cart_item_price', [ $this, 'update_cart_item_price' ], 10, 3 );
        add_filter( 'woocommerce_cart_item_subtotal', [ $this, 'update_cart_item_subtotal' ], 10, 3 );
        add_action( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_item_meta_to_order' ], 10, 4 );

        // Adjust cart totals
        add_action( 'woocommerce_before_calculate_totals', [ $this, 'adjust_cart_totals' ] );
    }

    public function add_custom_tab( $tabs ) {
        $tabs['custom_field'] = [
            'label'    => __( 'Custom Field', 'woocommerce' ),
            'target'   => 'custom_field_data',
            'class'    => ['show_if_simple', 'show_if_variable'],
            'priority' => 80,
        ];

        return $tabs;
    }

    public function add_custom_tab_content() {
        global $post;
    
        // Retrieve saved meta values
        $addon_titles = get_post_meta( $post->ID, '_addon_titles', true );
        $addon_prices = get_post_meta( $post->ID, '_addon_prices', true );
        $addon_section_title = get_post_meta( $post->ID, '_addon_section_title', true );
    
        echo '<div id="custom_field_data" class="panel woocommerce_options_panel">';
        echo '<div class="options_group">';
    
        // Addon Section Title Field
        echo '<p class="form-field">
                <label>' . __( 'Addon Section Title', 'woocommerce' ) . '</label>
                <input type="text" name="addon_section_title" class="short" value="' . esc_attr( $addon_section_title ) . '" placeholder="' . __( 'Ex: Accessories', 'woocommerce' ) . '" />
                <span class="description">' . __( 'Set the title for the addon section displayed on the product page.', 'woocommerce' ) . '</span>
              </p>';
    
        // Addon Fields Container
        echo '<div id="addon-fields-container">';
    
        if ( ! empty( $addon_titles ) && is_array( $addon_titles ) ) {
            foreach ( $addon_titles as $index => $title ) {
                $price = isset( $addon_prices[ $index ] ) ? esc_attr( $addon_prices[ $index ] ) : '';
                echo '<div class="addon-field-row">
                        <p class="form-field">
                            <label>' . __( 'Addon Title', 'woocommerce' ) . '</label>
                            <input type="text" name="addon_titles[]" class="short" value="' . esc_attr( $title ) . '" placeholder="' . __( 'Enter title', 'woocommerce' ) . '" />
                        </p>
                        <p class="form-field">
                            <label>' . __( 'Addon Price', 'woocommerce' ) . '</label>
                            <input type="number" step="0.01" name="addon_prices[]" class="short" value="' . esc_attr( $price ) . '" placeholder="' . __( 'Enter price', 'woocommerce' ) . '" />
                        </p>
                        <button type="button" class="button remove-addon-button">' . __( 'Remove Addon', 'woocommerce' ) . '</button>
                    </div>';
            }
        }
    
        echo '</div>';
        echo '<button type="button" class="button" id="add-addon-button">' . __( 'Add Addon', 'woocommerce' ) . '</button>';
        echo '</div>';
        echo '</div>';
    }
    

    public function save_custom_fields( $post_id ) {
        $addon_section_title = isset( $_POST['addon_section_title'] ) ? sanitize_text_field( $_POST['addon_section_title'] ) : '';
        
        update_post_meta( $post_id, '_addon_section_title', $addon_section_title );
    
        $addon_titles = isset( $_POST['addon_titles'] ) ? array_map( 'sanitize_text_field', $_POST['addon_titles'] ) : [];
        $addon_prices = isset( $_POST['addon_prices'] ) ? array_map( 'sanitize_text_field', $_POST['addon_prices'] ) : [];
    
        update_post_meta( $post_id, '_addon_titles', $addon_titles );
        update_post_meta( $post_id, '_addon_prices', $addon_prices );
    }
    

    public function display_addon_options() {
        global $product;

        $addon_section_title = get_post_meta( $product->get_id(), '_addon_section_title', true );
        $addon_titles = get_post_meta( $product->get_id(), '_addon_titles', true );
        $addon_prices = get_post_meta( $product->get_id(), '_addon_prices', true );

        if ( $addon_titles && $addon_prices ) {
            echo '<div class="product-addon-options">';
            echo '<h4>' . esc_html( $addon_section_title ?: __( 'Choose Addons', 'woocommerce' ) ) . '</h4>';

            foreach ( $addon_titles as $index => $title ) {
                $price = isset( $addon_prices[ $index ] ) ? floatval( $addon_prices[ $index ] ) : 0;
                echo '<p><input type="radio" name="product_addon" value="' . esc_attr( $price ) . '" /> ' . esc_html( $title ) . ' (+ ' . wc_price( $price ) . ')</p>';
            }

            echo '</div>';
        }
    }


    public function add_cart_item_data( $cart_item_data, $product_id ) {
        if ( isset( $_POST['product_addon'] ) ) {
            $cart_item_data['product_addon_price'] = floatval( $_POST['product_addon'] );
            $cart_item_data['unique_key'] = md5( microtime() . rand() ); // Unique key for cart items
        }

        return $cart_item_data;
    }

    public function display_cart_item_data( $item_data, $cart_item ) {
        if ( isset( $cart_item['product_addon_price'] ) ) {
            $item_data[] = [
                'key'   => __( 'Addon Price', 'woocommerce' ),
                'value' => wc_price( $cart_item['product_addon_price'] )
            ];
        }

        return $item_data;
    }

    public function update_cart_item_price( $price, $cart_item, $cart_item_key ) {
        if ( isset( $cart_item['product_addon_price'] ) ) {
            $price += $cart_item['product_addon_price'];
        }

        return wc_price( $price );
    }

    public function update_cart_item_subtotal( $subtotal, $cart_item, $cart_item_key ) {
        $line_total = isset( $cart_item['line_total'] ) ? $cart_item['line_total'] : 0;
    
        // Include the addon price if it exists
        if ( isset( $cart_item['product_addon_price'] ) ) {
            $line_total += $cart_item['product_addon_price'];
        }
    
        return wc_price( $line_total );
    }

    public function adjust_cart_totals( $cart ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            return;
        }
    
        foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
            if ( isset( $cart_item['product_addon_price'] ) ) {
                $addon_price = floatval( $cart_item['product_addon_price'] );
                $product = $cart_item['data'];
    
                // Use the sale price if available, otherwise use the regular price
                $product_price = $product->is_on_sale() ? floatval( $product->get_sale_price() ) : floatval( $product->get_regular_price() );
    
                // Set the cart item's price to sale price + addon price
                $product->set_price( $product_price + $addon_price );
            }
        }
    }

    public function add_item_meta_to_order( $item, $cart_item_key, $values, $order ) {
        if ( isset( $values['product_addon_price'] ) ) {
            $item->add_meta_data( __( 'Addon Price', 'woocommerce' ), wc_price( $values['product_addon_price'] ) );
        }
    }
}
