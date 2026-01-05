<?php
/**
 * Plugin Name: WebP Auto Processor & Resizer
 * Description: Automatically converts uploads to WebP, resizes, and compresses.
 * Version: 0.1
 * Author: vmisai
 */

if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'wap_add_settings_page');
function wap_add_settings_page() {
    add_options_page(
        'WebP Processor Settings',
        'WebP Processor',
        'manage_options',
        'webp-processor-settings',
        'wap_render_settings_page'
    );
}

add_action('admin_init', 'wap_register_settings');
function wap_register_settings() {
    register_setting('wap_settings_group', 'wap_max_dimension');
    register_setting('wap_settings_group', 'wap_quality');
    
    // Set defaults if they don't exist
    if (false === get_option('wap_max_dimension')) update_option('wap_max_dimension', 1920);
    if (false === get_option('wap_quality')) update_option('wap_quality', 95);
}

function wap_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>WebP Auto Processor Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wap_settings_group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Max Dimension (px)</th>
                    <td>
                        <input type="number" name="wap_max_dimension" value="<?php echo esc_attr(get_option('wap_max_dimension')); ?>" />
                        <p class="description">Images wider or taller than this will be downscaled. (Default: 1920)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">WebP Quality (%)</th>
                    <td>
                        <input type="number" name="wap_quality" min="1" max="100" value="<?php echo esc_attr(get_option('wap_quality')); ?>" />
                        <p class="description">Compression quality from 1 to 100. (Default: 95)</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_filter('wp_handle_upload', 'wap_process_image_on_upload');

function wap_process_image_on_upload($upload) {
    $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($upload['type'], $valid_types)) return $upload;

    $file_path = $upload['file'];
    $editor = wp_get_image_editor($file_path);

    if (!is_wp_error($editor)) {

        $max_dim = (int) get_option('wap_max_dimension', 1920);
        $quality = (int) get_option('wap_quality', 95);

        $size = $editor->get_size();
        if ($size['width'] > $max_dim || $size['height'] > $max_dim) {
            $editor->resize($max_dim, $max_dim, false);
        }

        $editor->set_quality($quality);

        $info = pathinfo($file_path);
        $webp_path = $info['dirname'] . '/' . $info['filename'] . '.webp';
        $saved = $editor->save($webp_path, 'image/webp');

        if (!is_wp_error($saved)) {
            unlink($file_path);
            $upload['file'] = $saved['path'];
            $upload['url']  = str_replace(basename($file_path), basename($saved['path']), $upload['url']);
            $upload['type'] = 'image/webp';
        }
    }

    return $upload;
}

add_filter('upload_mimes', function($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
});
