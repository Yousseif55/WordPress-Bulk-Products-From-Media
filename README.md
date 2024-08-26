# Bulk Products From Media

**Plugin Name:** Bulk Products From Media  
**Description:** Allows you to create products from the Media Library in bulk. The plugin integrates with WordPress to enable bulk product creation from media attachments, handling existing products and generating notices for operations performed.  
**Author:** Yousseif Ahmed  
**Version:** 1.8

## Description

The "Bulk Products From Media" plugin provides functionality for bulk creating WooCommerce products from media items in your WordPress Media Library. Key features include:

- **Bulk Action:** A bulk action in the Media Library to generate products from selected media items.
- **Existing Products Handling:** Skips creation for media items that already have associated products.
- **Notices:** Provides feedback on the number of products generated and any existing products skipped.
- **Single Image Action:** Adds a "Generate Product" action link for individual media items.

## Installation

1. Upload the `bulk-products-from-media` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the bulk actions dropdown in the Media Library or individual media row actions to generate products.

## Usage

- **Bulk Generation:** Select multiple media items in the Media Library, choose "Generate Product(s)" from the bulk actions dropdown, and click "Apply".
- **Single Generation:** Click "Generate Product" from the row actions of individual media items in the Media Library.

## Features

- **Bulk Product Creation:** Efficiently creates products from media items in bulk.
- **Existing Product Detection:** Avoids creating duplicate products for media items that already have associated products.
- **Admin Notices:** Displays success or warning notices to inform you of the process results.

## Changelog

### 1.8
- Updated to fix issues with row actions and existing product detection.
- Resolved problems with exploded values and accurate counter notices.

## Screenshots

- **Bulk Actions Dropdown:** Screenshot of the bulk actions dropdown with "Generate Product(s)" option.
- **Row Actions:** Screenshot showing the "Generate Product" link in the media row actions.
- **Admin Notices:** Examples of success and warning notices displayed after product generation.

## Frequently Asked Questions

**Q: What if the product already exists?**  
A: The plugin will skip the generation for media items that already have associated products, and notify you of these skipped items.

**Q: Can I generate products for individual media items?**  
A: Yes, you can generate products for individual media items using the "Generate Product" link in the row actions.

## Note

This plugin is a sample project provided for demonstration purposes. Some features and functionality may be customized based on specific requirements or project needs.

## License

This plugin is released under the [GPLv3 License](https://www.gnu.org/licenses/gpl-3.0.en.html).

