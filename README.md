=== WebP Auto Processor & Resizer ===

Contributors: vmisai

Tags: webp, image optimization, resize, conversion, performance

Requires at least: 5.0

Tested up to: 6.9

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically converts uploaded images to WebP format, resizes large dimensions, and applies high-quality compression to boost site performance.

== Description ==

WebP Auto Processor is a lightweight, "set-it-and-forget-it" solution for image optimization. Every time you upload a JPEG, PNG, or GIF to your Media Library, this plugin intercepts the process to:

* **Convert to WebP:** Reduces file size significantly while maintaining visual quality.
* **Auto-Resize:** Ensures no image exceeds your defined maximum dimensions (default 1920px), preventing accidental uploads of 4K+ raw photos.
* **Optimize Quality:** Applies a consistent compression level (default 95%) using WordPress's native `WP_Image_Editor` class.
* **Storage Cleanup:** Automatically deletes the original heavy source file (JPG/PNG) to keep your server storage lean.

This plugin uses your server's native GD or ImageMagick libraries for processing, meaning no external API keys or monthly subscription fees are required.

== Installation ==

1. Upload the `webp-auto-processor` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to **Settings > WebP Processor** to configure your preferred dimensions and quality.

== Frequently Asked Questions ==

= Does this process existing images? =
Currently, this plugin only processes new uploads. To convert existing images, you would need to re-upload them or use a bulk-processing extension.

= What happens to my original PNG/JPG files? =
To save disk space, the plugin deletes the original file after the WebP version is successfully created.

= Which image libraries are required? =
The plugin requires either the **GD** or **Imagick** PHP extension enabled on your server. Most modern hosting providers have these enabled by default.

== Changelog ==

= 0.1 =
* Added Settings page under Settings > WebP Processor.
* Added dynamic variables for quality and dimensions.

= 0.01 =
* Initial release with hardcoded 1920px limit and WebP conversion.
