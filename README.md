# WooCommerce Product Addon Options

## Description

WooCommerce Product Addon Options is a WordPress plugin that allows you to add custom addon options to WooCommerce products. It provides an easy way to enhance product customization by offering additional fields with prices that are dynamically displayed and calculated.

---

## Features

- Add unlimited addons with titles and prices.
- Display addon options on the product page.
- Calculate cart totals dynamically based on selected addons.
- Store addon data in WooCommerce order metadata.
- Easily manage addons in the product edit page under a custom tab.

---

## Installation

1. Download the plugin files and upload them to your WordPress `wp-content/plugins` directory.
2. Navigate to the **Plugins** section in the WordPress admin area.
3. Activate the plugin **WooCommerce Product Addon Options**.

---

## Usage

### Adding Addons to a Product

1. Go to the WooCommerce **Products** section and Create New Product or edit the desired product.
2. Navigate to the **Custom Field** tab in the product data panel.
3. Use the "Add Addon" button to create new addon fields with titles and prices.
4. Save the product.

### Updating Addon Title for Display

1. In the **Custom Field** tab, update the "Addon Section Title" field.
2. Save the product.

## Deactivation Behavior

When the plugin is deactivated, it performs the following tasks:

1. Deletes all meta fields (`_addon_titles` and `_addon_prices`) from the database.
2. Removes the plugin's section title option from the WordPress options table.

---

## Contributing

Feel free to fork the repository and submit pull requests. All contributions are welcome!

---

## Changelog

### Version 1.0.0

- Initial release.

## License

This plugin is licensed under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.en.html).
